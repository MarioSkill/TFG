<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BenchmarkBundle\Entity\Programas;

class ApacheController extends Controller {
  public function sparkAction() {
    $em = $this->getDoctrine()->getManager();
    $spark = new Programas($em);
    $spark =$spark -> getProgramaByNombre("SPARK");
      return $this->render(
        'BenchmarkBundle:Apache:Spark/index.html.twig',
        [ 
          "get" => $spark,
        ]
      );

    }
  public function stormAction() {

    $em = $this->getDoctrine()->getManager();
    $storm = new Programas($em);
    $storm =$storm -> getProgramaByNombre("STORM");
      return $this->render(
        'BenchmarkBundle:Apache:Spark/index.html.twig',
        [ 
          "get" => $storm
        ]
      );
      
    }
  public function flinkAction() {

    $em = $this->getDoctrine()->getManager();
    $flink = new Programas($em);
    $flink =$flink -> getProgramaByNombre("FLINK");
      return $this->render(
        'BenchmarkBundle:Apache:Spark/index.html.twig',
        [ 
          "get" => $flink
        ]
      );
      
    }
}
