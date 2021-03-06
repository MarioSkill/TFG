<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table(name="Resultado", indexes={@ORM\Index(name="test", columns={"test"})})
 * @ORM\Entity
 */
class Resultado
{
  
   /**
     * @var string
     *
     * @ORM\Column(name="tiempo", type="string", length=3000, nullable=true)
     */
    private $tiempo;

    /**
     * @var string
     *
     * @ORM\Column(name="cpu", type="text", length=65535, nullable=true)
     */
    private $cpu;

    /**
     * @var string
     *
     * @ORM\Column(name="ModeloCPU", type="string", length=300, nullable=true)
     */
    private $modelocpu;

    /**
     * @var string
     *
     * @ORM\Column(name="NucleosCPU", type="string", length=100, nullable=true)
     */
    private $nucleoscpu;

    /**
     * @var string
     *
     * @ORM\Column(name="ram", type="text", length=65535, nullable=true)
     */
    private $ram;

    /**
     * @var string
     *
     * @ORM\Column(name="TotalRAM", type="string", length=100, nullable=true)
     */
    private $totalram;

    /**
     * @var string
     *
     * @ORM\Column(name="log", type="text", length=65535, nullable=true)
     */
    private $log;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BenchmarkBundle\Entity\Test
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test", referencedColumnName="id")
     * })
     */
    private $test;



    /**
     * Set tiempo
     *
     * @param string $tiempo
     *
     * @return Resultado
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return string
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set cpu
     *
     * @param string $cpu
     *
     * @return Resultado
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;

        return $this;
    }

    /**
     * Get cpu
     *
     * @return string
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * Set modelocpu
     *
     * @param string $modelocpu
     *
     * @return Resultado
     */
    public function setModelocpu($modelocpu)
    {
        $this->modelocpu = $modelocpu;

        return $this;
    }

    /**
     * Get modelocpu
     *
     * @return string
     */
    public function getModelocpu()
    {
        return $this->modelocpu;
    }

    /**
     * Set nucleoscpu
     *
     * @param string $nucleoscpu
     *
     * @return Resultado
     */
    public function setNucleoscpu($nucleoscpu)
    {
        $this->nucleoscpu = $nucleoscpu;

        return $this;
    }

    /**
     * Get nucleoscpu
     *
     * @return string
     */
    public function getNucleoscpu()
    {
        return $this->nucleoscpu;
    }

    /**
     * Set ram
     *
     * @param string $ram
     *
     * @return Resultado
     */
    public function setRam($ram)
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get ram
     *
     * @return string
     */
    public function getRam()
    {
        return $this->ram;
    }

    /**
     * Set totalram
     *
     * @param string $totalram
     *
     * @return Resultado
     */
    public function setTotalram($totalram)
    {
        $this->totalram = $totalram;

        return $this;
    }

    /**
     * Get totalram
     *
     * @return string
     */
    public function getTotalram()
    {
        return $this->totalram;
    }

    /**
     * Set log
     *
     * @param string $log
     *
     * @return Resultado
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
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
     * @return Resultado
     */
    public function setTest(\BenchmarkBundle\Entity\Test $test = null)
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
    }  private $em;
    function __construct($em){
        $this -> em =$em;
    }
    public function getResultadoByID($id){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Resultado q
            WHERE q.id = :id')->setParameter('id', $id);
        return $e->getSingleResult();
    }
    public function getResultadoByTestID($id){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Resultado q
            WHERE q.test = :id')->setParameter('id', $id);
        return $e->getSingleResult();
    }
    public function getMaxTiempoByComparativaId($id){
        $e = $this -> em -> createQuery('SELECT (r.tiempo) mtiempo
            FROM BenchmarkBundle:Comparativa c
            JOIN BenchmarkBundle:Resultado r WITH r.test = c.test
            WHERE c.id = :id')->setParameter('id', $id);
        return $e->getResult();
    }
}
