<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BenchmarkBundle\Bin\Shell;
use BenchmarkBundle\Entity\Test;

class DockerController extends Controller {
    public function toolAction() {
        $em = $this->getDoctrine()->getManager();
        $t = new Test($em);
        return $this->render(
            'BenchmarkBundle:Apache:Test/tool.html.twig',
            [
              'docker_id'   => $t->getTestByTestEstado(1),
            ]
          );
    }
  public function manageAction(Request $request){
    
    $s = new  Shell();
    $response = new JsonResponse();
    $res="";
    switch ($_POST['data'] ) {
      case 'list':
        $res = $s->getContainerStatus();
      break;
      case 'list_id':
        $res = $s->getContainerStatusByID($_POST['id']);
      break;
      case 'terminal':
         $res = $s->terminal();
      break;
      case 'clean':
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $q = $qb->update('BenchmarkBundle:Test', 'u')
          ->set('u.estado', '3')
          ->where('u.estado= ?1')
          ->setParameter(1, '1')
          ->getQuery();
        $p = $q->execute();
        $res = htmlspecialchars($s->clean());
      break;
      

    }
   // print_r($res);
    $li ='  
    <li>
        <div class="block">
            <div class="tags">
                <a href="" class="tag">
                    <span>'.strtoupper($_POST['data']).'</span>
                </a>
            </div>
            <div class="block_content">
                <code class="title"><a>'.$res.'</a> </code>
                <div class="byline">
                </div>
                <p class="excerpt"></p>
            </div>
        </div>
    </li>';
      
    $response->setData(array("code" => 100, "success" => true,"file"=>$li ));

    return $response;
  }
}


