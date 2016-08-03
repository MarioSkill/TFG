<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="Test", indexes={@ORM\Index(name="Fichero", columns={"Fichero", "Programa", "Algoritmo", "Estado", "ScriptBenchmark"}), @ORM\Index(name="ScriptBenchmark", columns={"ScriptBenchmark"}), @ORM\Index(name="Programa", columns={"Programa"}), @ORM\Index(name="Estado", columns={"Estado"}), @ORM\Index(name="Algoritmo", columns={"Algoritmo"}), @ORM\Index(name="Configuracion", columns={"Configuracion"}), @ORM\Index(name="IDX_784DD1323B547DA8", columns={"Fichero"})})
 * @ORM\Entity
 */
class Test
{
    /**
     * @var string
     *
     * @ORM\Column(name="comand", type="string", length=1024, nullable=false)
     */
    private $comand;

    /**
     * @var string
     *
     * @ORM\Column(name="container_id", type="string", length=64, nullable=true)
     */
    private $containerId;

    /**
     * @var string
     *
     * @ORM\Column(name="container_name", type="string", length=128, nullable=false)
     */
    private $containerName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="datetime", nullable=true)
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetime", nullable=true)
     */
    private $fin;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \BenchmarkBundle\Entity\Scriptbenchmark
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Scriptbenchmark")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ScriptBenchmark", referencedColumnName="id")
     * })
     */
    private $scriptbenchmark;

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
     * @var \BenchmarkBundle\Entity\Estado
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Estado", referencedColumnName="id")
     * })
     */
    private $estado;

    /**
     * @var \BenchmarkBundle\Entity\Ficheros
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Ficheros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Fichero", referencedColumnName="id")
     * })
     */
    private $fichero;

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
     * @var \BenchmarkBundle\Entity\Configuracion
     *
     * @ORM\ManyToOne(targetEntity="BenchmarkBundle\Entity\Configuracion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Configuracion", referencedColumnName="id")
     * })
     */
    private $configuracion;



    /**
     * Set comand
     *
     * @param string $comand
     *
     * @return Test
     */
    public function setComand($comand)
    {
        $this->comand = $comand;

        return $this;
    }

    /**
     * Get comand
     *
     * @return string
     */
    public function getComand()
    {
        return $this->comand;
    }

    /**
     * Set containerId
     *
     * @param string $containerId
     *
     * @return Test
     */
    public function setContainerId($containerId)
    {
        $this->containerId = $containerId;

        return $this;
    }

    /**
     * Get containerId
     *
     * @return string
     */
    public function getContainerId()
    {
        return $this->containerId;
    }

    /**
     * Set containerName
     *
     * @param string $containerName
     *
     * @return Test
     */
    public function setContainerName($containerName)
    {
        $this->containerName = $containerName;

        return $this;
    }

    /**
     * Get containerName
     *
     * @return string
     */
    public function getContainerName()
    {
        return $this->containerName;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     *
     * @return Test
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Test
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
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
     * Set scriptbenchmark
     *
     * @param \BenchmarkBundle\Entity\Scriptbenchmark $scriptbenchmark
     *
     * @return Test
     */
    public function setScriptbenchmark(\BenchmarkBundle\Entity\Scriptbenchmark $scriptbenchmark = null)
    {
        $this->scriptbenchmark = $scriptbenchmark;

        return $this;
    }

    /**
     * Get scriptbenchmark
     *
     * @return \BenchmarkBundle\Entity\Scriptbenchmark
     */
    public function getScriptbenchmark()
    {
        return $this->scriptbenchmark;
    }

    /**
     * Set programa
     *
     * @param \BenchmarkBundle\Entity\Programas $programa
     *
     * @return Test
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

    /**
     * Set estado
     *
     * @param \BenchmarkBundle\Entity\Estado $estado
     *
     * @return Test
     */
    public function setEstado(\BenchmarkBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \BenchmarkBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fichero
     *
     * @param \BenchmarkBundle\Entity\Ficheros $fichero
     *
     * @return Test
     */
    public function setFichero(\BenchmarkBundle\Entity\Ficheros $fichero = null)
    {
        $this->fichero = $fichero;

        return $this;
    }

    /**
     * Get fichero
     *
     * @return \BenchmarkBundle\Entity\Ficheros
     */
    public function getFichero()
    {
        return $this->fichero;
    }

    /**
     * Set algoritmo
     *
     * @param \BenchmarkBundle\Entity\Algoritmos $algoritmo
     *
     * @return Test
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
     * Set configuracion
     *
     * @param \BenchmarkBundle\Entity\Configuracion $configuracion
     *
     * @return Test
     */
    public function setConfiguracion(\BenchmarkBundle\Entity\Configuracion $configuracion = null)
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    /**
     * Get configuracion
     *
     * @return \BenchmarkBundle\Entity\Configuracion
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }
    private $em;
    function __construct($em){
        $this -> em =$em;
    }

    public function getNextTask(){
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Test f
        WHERE f.estado = :programado')->setParameter('programado', 5)->setMaxResults(1)->getSingleResult();
    }
    public function getTestByContainerName($id){
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Test f
        WHERE f.containerName = :id')->setParameter('id', $id)->getSingleResult();   
    }
    public function getNumTestByPrograma(){
        return $this -> em -> createQuery('SELECT COUNT(f.id) numero,p.nombre
        FROM BenchmarkBundle:Test f
        INNER JOIN f.programa p 
        GROUP BY p.id')->getResult(); 
    }
    public function getTestByProgramaId($id){
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Test f
        WHERE f.programa = :id')->setParameter('id', $id)->getResult();    
    }
    public function getTestById($id){
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Test f
        WHERE f.id = :id')->setParameter('id', $id)->getSingleResult();    
    }
    public function getTestByTestEstado($estado){
        return $this -> em -> createQuery('SELECT f
        FROM BenchmarkBundle:Test f
        WHERE f.estado = :estado')->setParameter('estado', $estado)->getResult();    
    }
}
