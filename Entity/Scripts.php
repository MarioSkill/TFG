<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scripts
 *
 * @ORM\Table(name="Scripts", indexes={@ORM\Index(name="Algoritmo", columns={"Algoritmo"}), @ORM\Index(name="Programa", columns={"Programa"})})
 * @ORM\Entity
 */
class Scripts
{
    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="bin", type="string", length=300, nullable=false)
     */
    private $bin;

    /**
     * @var string
     *
     * @ORM\Column(name="class", type="string", length=2000, nullable=true)
     */
    private $class;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BenchmarkBundle\Entity\Algoritmos
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Algoritmos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Algoritmo", referencedColumnName="id")
     * })
     */
    private $algoritmo;

    /**
     * @var \BenchmarkBundle\Entity\Programas
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Programas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Programa", referencedColumnName="id")
     * })
     */
    private $programa;



    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Scripts
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set bin
     *
     * @param string $bin
     *
     * @return Scripts
     */
    public function setBin($bin)
    {
        $this->bin = $bin;

        return $this;
    }

    /**
     * Get bin
     *
     * @return string
     */
    public function getBin()
    {
        return $this->bin;
    }

// ------------------------------------------------------------------------------

    /**
     * Set class
     *
     * @param string $class
     *
     * @return Scripts
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }


// ------------------------------------------------------------------------------
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
     * Set algoritmo
     *
     * @param \BenchmarkBundle\Entity\Algoritmos $algoritmo
     *
     * @return Scripts
     */
    public function setAlgoritmo(\BenchmarkBundle\Entity\Algoritmos $algoritmo = null)
    {
        $this->algoritmo = $algoritmo;

        return $this;
    }

    /**
     * Get algoritmo
     *
     * @return \BenchmarkBundle\Entity\Algoritmos
     */
    public function getAlgoritmo()
    {
        return $this->algoritmo;
    }

    /**
     * Set programa
     *
     * @param \BenchmarkBundle\Entity\Programas $programa
     *
     * @return Scripts
     */
    public function setPrograma(\BenchmarkBundle\Entity\Programas $programa = null)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \BenchmarkBundle\Entity\Programas
     */
    public function getPrograma()
    {
        return $this->programa;
    }
    private $em;

    function __construct($em){
        $this -> em =$em;
    }

    public function getDataByAlgoritmoYPrograma($algoritmo,$programa){
  
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Scripts f
        WHERE f.algoritmo = :algoritmo and f.programa = :programa')
        ->setParameter('algoritmo', $algoritmo)->setParameter('programa', $programa)
        ->getSingleResult();
    }
}
