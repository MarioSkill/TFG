<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="Estado")
 * @ORM\Entity
 */
class Estado
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=false)
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
     * @return Estado
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
     * @return Estado
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
    private $em;
    function __construct($em){
        $this -> em =$em;
    }

    public function getEstadoBy($nombre){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Estado q
            WHERE q.nombre = :estado')->setParameter('estado', $nombre);
        return $e->getSingleResult();
    }
    public function getEstados(){
        $e = $this -> em -> createQuery('SELECT q
            FROM BenchmarkBundle:Estado q');
        return $e->getResult();
    }
}
