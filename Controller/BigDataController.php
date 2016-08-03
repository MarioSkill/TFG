<?php

namespace BenchmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use BenchmarkBundle\Entity\Ficheros;


class BigDataController extends Controller {

  public function dataAction() {
      
      $em = $this->getDoctrine()->getManager();
      $f = new Ficheros($em);

        return $this->render(
          'BenchmarkBundle:Default:list-files.html.twig',
          [
            'datos' =>$f->getFicheros(),
          ]
        );

    }
public function showAction(Request $request){
  $response = new JsonResponse();
    //$data2 = $request->query->get('data');
    //print_r();
    //$data2="/var/www/html/TFG/src/BenchmarkBundle/Resources/public/tfg/data/FL_insurance_sample.csv";
    //prepare the response, e.g.
    
    $response->setData(array("code" => 100, "success" => true,"file"=>"FICHERO: \n ".file_get_contents($_POST['data'])));

    return $response;
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
