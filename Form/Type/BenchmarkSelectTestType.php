<?php
namespace BenchmarkBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BenchmarkSelectTestType extends AbstractType
{
    //private $ruta;
    public function __construct(){
     //   $this-> ruta = $ruta;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->setAction($options['action'])
            ->add('Programa', EntityType::class, array(
                    'class' => 'BenchmarkBundle:Programas',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')->orderBy('u.id','asc');
                    },)
                )
            ->add('Algoritmo', EntityType::class, array(
                    'class' => 'BenchmarkBundle:Algoritmos',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')->orderBy('u.id','asc');
                    },)
                )
            ->add('Fichero', EntityType::class, array(
                    'class' => 'BenchmarkBundle:Ficheros',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')->orderBy('u.id','asc');
                    },)
                )
            ->add('Conf_del_Programa', TextType::class, array('attr' => array('placeholder' => 'configuracion adicional: ejem:--master local[*]...'),'mapped' => false,'required'    => false,))
            ->add('Conf_del_Algoritmo', TextType::class, array('attr' => array('placeholder' => 'configuracion adicional: ejem:k-means num de clases ...'),'mapped' => false,'required'    => false))
            ->add('Empezar', SubmitType::class)
            ->setMethod('POST');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BenchmarkBundle\Entity\Test',
            'cascade_validation' => true,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'task_item',
        ));
    }
    public function createNamedBuilder(){
        return 'form';
    }
    public function getName()
    {
        return 'Benchmark';
    }
}
?>