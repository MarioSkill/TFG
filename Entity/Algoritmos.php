<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Algoritmos
 *
 * @ORM\Table(name="Algoritmos")
 * @ORM\Entity
 */
class Algoritmos
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
     * @ORM\Column(name="Descripcion", type="string", length=100, nullable=true)
     */
    private $descripcion;

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
     * @return Algoritmos
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Algoritmos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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

    public function getAlgoritmoByID($id){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Algoritmos q
            WHERE q.id = :id')->setParameter('id', $id);
        return $e->getSingleResult();
    }
    public function getAlgoritmoByNombre($nombre){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Algoritmos q
            WHERE q.nombre = :nombre')->setParameter('nombre', $nombre);
        return $e->getSingleResult();
    }
}
