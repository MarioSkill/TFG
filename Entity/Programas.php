<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programas
 *
 * @ORM\Table(name="Programas")
 * @ORM\Entity
 */
class Programas
{
    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Version", type="string", length=10, nullable=true)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="Dockerfile", type="text", length=65535, nullable=true)
     */
    private $dockerfile;

    /**
     * @var string
     *
     * @ORM\Column(name="Bin", type="string", length=300, nullable=false)
     */
    private $bin;

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
     * @return Programas
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
     * Set version
     *
     * @param string $version
     *
     * @return Programas
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set dockerfile
     *
     * @param string $dockerfile
     *
     * @return Programas
     */
    public function setDockerfile($dockerfile)
    {
        $this->dockerfile = $dockerfile;

        return $this;
    }

    /**
     * Get dockerfile
     *
     * @return string
     */
    public function getDockerfile()
    {
        return $this->dockerfile;
    }

    /**
     * Set bin
     *
     * @param string $bin
     *
     * @return Programas
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
        return $this->nombre;
    }
    private $em;
    function __construct($em){
        $this -> em =$em;
    }
    public function setEM($em) {
        $this -> em = $em;
    }
    public function getProgramaByNombre($nombre){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Programas q
            WHERE q.nombre = :nombre')->setParameter('nombre', $nombre);
        return $e->getSingleResult();
    }
    public function getProgramaByID($id){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Programas q
            WHERE q.id = :id')->setParameter('id', $id);
        return $e->getResult();
    }
    public function getTodosProgramas(){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Programas q
            WHERE q.nombre != :nombre')->setParameter('nombre', "TODOS");
        return $e->getResult();
    }
}
