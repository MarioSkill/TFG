<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comparativa
 *
 * @ORM\Table(name="Comparativa", indexes={@ORM\Index(name="test", columns={"test"})})
 * @ORM\Entity
 */
class Comparativa
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var \BenchmarkBundle\Entity\Test
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="BenchmarkBundle\Entity\Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test", referencedColumnName="id")
     * })
     */
    private $test;



    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Comparativa
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Comparativa
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set test
     *
     * @param \BenchmarkBundle\Entity\Test $test
     *
     * @return Comparativa
     */
    public function setTest(\BenchmarkBundle\Entity\Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \BenchmarkBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }
    private $em;
    function __construct($em=null,$id,$fecha,$test){
        $this -> em =$em;
        $this -> id = $id;
        $this -> fecha = $fecha;
        $this -> test = $test;

    }

    public function getComparativas(){
        return $this -> em->createQuery(
       'SELECT DISTINCT f.id,f.fecha
        FROM BenchmarkBundle:Comparativa f'
      )->getResult();
    }
    public function getComparativaByTestID($id){
        return $this -> em ->createQuery('SELECT t,r
                FROM BenchmarkBundle:Resultado r 
                JOIN r.test t
                JOIN BenchmarkBundle:Comparativa f WITH t.id = f.test
                WHERE f.id = :id')->setParameter('id', $id)->getResult();
    }
}
