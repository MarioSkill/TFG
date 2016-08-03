<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Scriptbenchmark
 *
 * @ORM\Table(name="ScriptBenchmark")
 * @ORM\Entity
 */
class Scriptbenchmark
{
    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="string", length=1024, nullable=false)
     */
    private $contenido;

    /**
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=300, nullable=true)
     */
    private $ruta;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Scriptbenchmark
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set ruta
     *
     * @param string $ruta
     *
     * @return Scriptbenchmark
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
