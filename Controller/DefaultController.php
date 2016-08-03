<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BenchmarkBundle\Helpers\Benchmark;
use BenchmarkBundle\Helpers\ClientSocket;

use BenchmarkBundle\Entity\Estado;
use BenchmarkBundle\Entity\Comparativa;
use BenchmarkBundle\Entity\Test;

use BenchmarkBundle\Entity\Scripts;

class DefaultController extends Controller {
    public function indexAction() {
    	$em = $this->getDoctrine()->getManager();
    	$estados = new Estado($em);
		  $comparativa = new Comparativa ($em,null,null,null);
		  $test = new Test($em);

  		$estados 		    = $estados 		  -> 	getEstados();
  		$programas[0] 	= $test 		    ->	getTestByProgramaId(1);//Spark
  		$programas[1] 	= $test 		    ->	getTestByProgramaId(2);//Flink
  		$programas[2] 	= $test 		    ->	getTestByProgramaId(3);//Storm
  		$comparativa 	  = $comparativa 	-> 	getComparativas();
  		$numTest		    = $test         ->  getNumTestByPrograma();
      $s              = new ClientSocket();
/*

      $prueba__= new Scripts($em);
      $res=$prueba__ -> getDataByAlgoritmoYPrograma(1,1);
      echo "..";
      print_r($res->getClass());
    */

      //$r=$s->peticion("MEDIR_REQUEST");
      //$r=$s->peticion("GETDATA_REQUEST");      

    	return $this->render(
          'BenchmarkBundle:Default:index1.html.twig',
          [
            'programas' 	=> $programas,
            'estados' 		=> $estados,
            'comparativa' 	=> $comparativa,
            'numTest'		=> $numTest,
            'puerto' => $s->getPort(),
            'ip' => $s->getHost(),
            'estado' =>$s -> getServerStatus(),
          ]
        );
    }
}
