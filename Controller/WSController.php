<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BenchmarkBundle\Helpers\Benchmark;
use BenchmarkBundle\Helpers\ConfiguracionBenchmark;
use BenchmarkBundle\Entity\Programas;
use BenchmarkBundle\Entity\Algoritmos;
use BenchmarkBundle\Entity\Ficheros;
class WSController extends Controller {
    public function serverAction(Request $request) {

  
      	$get = $request->request->all();
    	$em = $this->getDoctrine()->getManager();
        $programa = null; 
        $algoritmo= null; 
        $fichero =null;
        
        $c = new ConfiguracionBenchmark();
        $b = new Benchmark(
            $em,
            $programa,
            $algoritmo,
            $fichero,
            $c -> getRutaProyecto(),
            $c -> getRutaDatosDocker()
        ); 
        ///$b -> salvarResultadoYlanzarSiguienteTarea('SPARK_27_06_2016_29_6721f4d565c3ff51e4d366bf9807a553',0,0,0,$c);


        if (isset($get['op'])){ 

        	switch($get['op']) {
        		case 'SetAndNext':
    					if (isset($get['id']))      $containerID    = $get['id'];       else    $containerID    = "null";
                        if (isset($get['tool']))    $tool           = $get['tool'];     else    $tool           = "null";
                        if (isset($get['time']))    $tiempo         = $get['time'];     else    $tiempo         = "null";
                        if (isset($get['ram']))     $ram            = $get['ram'];      else    $ram            = "null";
                        if (isset($get['cpu']))     $cpu            = $get['cpu'];      else    $cpu            = "null";
                        $r=$b -> getMediciones();
                        $ram="";
                        //print_r($r);
                        foreach ($r["RAM"] as $key => $value) {
                            $ram .=$value.",";
                        }
                        $ram = substr($ram, 0, -1);
                        foreach ($r["CPU"] as $key => $value) {
                            if ($value !=0)
                            $cpu .=$value.",";
                        }
                        $cpu = substr($cpu, 0, -1);

                        $b -> salvarResultadoYlanzarSiguienteTarea($containerID,$tiempo,$cpu,$ram,$c);
        		break;
                case 'AddNewTest':
                    if (isset($get['algoritmo']))      $algoritmoID     = $get['algoritmo'];      else    break;
                    if (isset($get['programa']))       $programaID      = $get['programa'];       else    break;
                    if (isset($get['fichero']))        $ficheroID       = $get['fichero'];        else    break;
                    if (isset($get['paramEjecucion'])) $paramEjecucion  = $get['paramEjecucion']; else    $paramEjecucion  =$c->getParamEjucucion();

                    $algoritmo = new Algoritmos($em);
                    $programa = new Programas($em);
                    $fichero = new Ficheros($em);

                    $algoritmo = $algoritmo -> getAlgoritmoByID($algoritmoID);
                    $programa = $programa -> getProgramaByID($programaID);
                    $fichero = $fichero->getFicheroByID($ficheroID);
                    $b = new Benchmark(
                        $em,
                        $programa,
                        $algoritmo,
                        $fichero,
                        $c -> getRutaProyecto(),
                        $c -> getRutaDatosDocker(),
                        $paramEjecucion
                    ); 
                    $idTest=$b -> crearPrueba();
                    echo $idTest."\n<br>";
                break;
                default: echo "La operacion no Existe:".$get['op']."<br>";
        	}
        }else{
            echo "Operacion no definida<br>";
        }

       return new Response('ok');
    }

}
