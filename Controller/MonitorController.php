<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BenchmarkBundle\Helpers\Benchmark;
use BenchmarkBundle\Helpers\ConfiguracionBenchmark;
use BenchmarkBundle\Helpers\ClientSocket;


class MonitorController extends Controller {
    public function indexAction() {
    	$em = $this->getDoctrine()->getManager();
      $s = new ClientSocket();
      

      
    	return $this->render(
          'BenchmarkBundle:Monitor:index.html.twig',
          [
            'puerto' => $s->getPort(),
            'ip' => $s->getHost(),
            'estado' =>$s -> getServerStatus(),
            't' =>null,
          ]
        );
    }
  public function ajaxAction(Request $request){

    $get = $request->request->all();
    $response = new JsonResponse();   

    if( strcmp($get['op'],"APAGAR") === 0){
      
      $r= $this -> pararServerSocketAction();

    }else if( strcmp($get['op'],"ENCENDER") === 0){
      
      $r=$this ->arrancarServerSocketAction("127.0.0.1",9002);
    }else if( strcmp($get['op'],"MEDIR") === 0){
      $r=$this ->initMedir();
    }else if( strcmp($get['op'],"GETDATA") === 0){
      $r=$this ->getData();
    }else{
      $r="operacion no definida".$get['op'];
    }
    $response->setData( array(
                              "code" => 100,
                              "success" => true,
                              "servidor"=>$r
                              )
                      );
    return $response;
  }

  private function initMedir() {
    $s = new ClientSocket();
    $r=$s->peticion("MEDIR_REQUEST");
    $r=$r["RESPONSE"];
    return $r;
  }

  private function getData() {
    $s = new ClientSocket();
    $r=json_encode($s->peticion("GETDATA_REQUEST"));
    return $r;
  }


  private function pararServerSocketAction(){
    $s = new ClientSocket();
    $r=$s->peticion("STOP_REQUEST");
    $r=$r["RESPONSE"];
    return $r;
  }

  private function arrancarServerSocketAction($ip,$puerto){
      $rutaServerSocket = "/var/www/default/TFG2/src/BenchmarkBundle/Bin/arrancar.sh > /dev/null 2>/dev/null &";
      $pos = strrpos(shell_exec("netstat -anp | grep $puerto"), "$ip:$puerto");
      if ($pos === false) { // nota: tres signos de igual
        $r=shell_exec($rutaServerSocket);
        $r="START_OK";
        //$r = "apagado: ".shell_exec("/var/www/default/TFG2/src/BenchmarkBundle/Bin/arrancar.sh&");
      }else{
        $r="error:";
      }
      return $r;
  }

}
