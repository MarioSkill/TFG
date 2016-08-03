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
use BenchmarkBundle\Entity\Test;
use BenchmarkBundle\Form\Type\BenchmarkSelectTestType;
class LanzarTestController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(BenchmarkSelectTestType::class , new Test($em) , array(

            'action' => $this->generateUrl('benchmark_lanzarTest')
        ));
        return $this->render('BenchmarkBundle:Apache:Test/benchmark.html.twig', ["form" => $form->createView() , ]);
    }

    public function runAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $test = new Test($em);
        $form = $this->createForm(BenchmarkSelectTestType::class , $test, array(

            'action' => $this->generateUrl('benchmark_lanzarTest')
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            $c = new ConfiguracionBenchmark();
            $algoritmo = $test->getAlgoritmo();
            $programa = array($test->getPrograma());
            $fichero = $test->getFichero();
            $paramEjecucion=null;
            $confAdicionalByAlgoritmo=null;

            if ($form->get('Conf_del_Programa')->getData()!= null){
                $paramEjecucion=$form->get('Conf_del_Programa')->getData();
            }
            if ($form->get('Conf_del_Algoritmo')->getData()!= null){
                $confAdicionalByAlgoritmo =$form->get('Conf_del_Algoritmo')->getData();
            }



            $b = new Benchmark(
                    $em,
                    $programa,
                    $algoritmo,
                    $fichero,
                    $c -> getRutaProyecto(),
                    $c -> getRutaDatosDocker(),
                    $paramEjecucion,
                    $confAdicionalByAlgoritmo
                ); 

            $idTest=$b -> crearPrueba();

            //$benchmark = new Benchmark($algorithm->getNombre(), $tool->getNombre(), $data->getNombre());
            
            $r['request'] = ['algorithm' => $algoritmo, 'tool' => $programa, 'data' => $fichero,"docker"=>$idTest,
            "paramEjecucion" =>$paramEjecucion,"confAdicionalByAlgoritmo"=>$confAdicionalByAlgoritmo];
        }
        else {
            return $this->redirect($this->generateUrl("benchmark_test"));
        }

        return $this->render('BenchmarkBundle:Apache:Test/run.html.twig', ['datos' => $r]);
    }

}
