<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ficheros
 *
 * @ORM\Table(name="Ficheros")
 * @ORM\Entity
 */
class Ficheros
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=125, nullable=false)
     */
    private $ruta;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=100, nullable=false)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="ext", type="string", length=3, nullable=true)
     */
    private $ext;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaDataDocker", type="string", length=250, nullable=false)
     */
    private $rutadatadocker;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ficheros
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
     * Set ruta
     *
     * @param string $ruta
     *
     * @return Ficheros
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Ficheros
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set ext
     *
     * @param string $ext
     *
     * @return Ficheros
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Ficheros
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
     * Set rutadatadocker
     *
     * @param string $rutadatadocker
     *
     * @return Ficheros
     */
    public function setRutadatadocker($rutadatadocker)
    {
        $this->rutadatadocker = $rutadatadocker;

        return $this;
    }

    /**
     * Get rutadatadocker
     *
     * @return string
     */
    public function getRutadatadocker()
    {
        return $this->rutadatadocker;
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
    public function __toString(){
        return $this->nombre." - ". $this->size." MB";
    }
    private $em;

    function __construct($em){
        $this -> em =$em;
    }

    public function getFicheroByNombre($nombre){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Ficheros q
            WHERE q.nombre = :nombre')->setParameter('nombre', $nombre);
        return $e->getSingleResult();
    }
    public function getFicheroByID($id){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Ficheros q
            WHERE q.id = :id')->setParameter('id', $id);
        return $e->getSingleResult();
    }
    public function getFicheros(){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Ficheros q');
        return $e->getResult();
    }
}
