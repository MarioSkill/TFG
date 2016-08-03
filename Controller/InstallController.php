<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BenchmarkBundle\Helpers\Benchmark;
use BenchmarkBundle\Helpers\ClientSocket;

use BenchmarkBundle\Entity\Estado;
use BenchmarkBundle\Entity\Comparativa;
use BenchmarkBundle\Entity\Test;

use BenchmarkBundle\Entity\Scripts;

class InstallController extends Controller {
    public function indexAction() {
    	$em = $this->getDoctrine()->getManager();
    	return $this->render(
          'BenchmarkBundle:Install:index.html.twig',
          [
     
          ]
        );
    }
}
