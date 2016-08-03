<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BenchmarkBundle\Entity\Resultado;
use BenchmarkBundle\Entity\Comparativa;
class ResultadosController extends Controller {

    public function verResultadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('slug');
        $resultado = new Resultado($em);

        $resultado = $resultado->getResultadoByTestID($id);
   
        $test = $resultado->getTest();
        $programa = $test->getPrograma();

        $cpu =explode(',',$resultado->getCpu());
        $ram =explode(',',$resultado->getRam());
        $mCPU =max($cpu);
        $mRAM =max($ram);
        

        return $this->render(
          'BenchmarkBundle:Apache:Test/results.html.twig',
           [
            'result' => $resultado,
            'test' => $test,
            'tool' => $programa,
            'ram' =>$ram,
            'cpu' =>$cpu,
             ]
        );
    }

    public

    function verComparativaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comparativa = new Comparativa($em,null,null,null);
        $resultado = new Resultado($em);
        $id = $request->get('slug');

        $comparativa    =   $comparativa ->getComparativaByTestID($id);
        $maxTiempo      =   max($resultado ->getMaxTiempoByComparativaId($id));




        return $this->render(
          'BenchmarkBundle:Apache:Test/results2.html.twig',
          [
            'comparativa' => $comparativa,
            'maxTiempo'=>$maxTiempo['mtiempo'],
          ]
        );
    }

}
