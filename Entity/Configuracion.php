<?php

namespace BenchmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracion
 *
 * @ORM\Table(name="Configuracion")
 * @ORM\Entity
 */
class Configuracion
{
    /**
     * @var string
     *
     * @ORM\Column(name="OP", type="string", length=100, nullable=false)
     */
    private $op;

    /**
     * @var string
     *
     * @ORM\Column(name="FicheroSalida", type="string", length=300, nullable=false)
     */
    private $ficherosalida;

    /**
     * @var string
     *
     * @ORM\Column(name="Logs", type="string", length=300, nullable=false)
     */
    private $logs;

    /**
     * @var string
     *
     * @ORM\Column(name="paramEjucucion", type="string", length=5000, nullable=true)
     */
    private $paramejucucion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set op
     *
     * @param string $op
     *
     * @return Configuracion
     */
    public function setOp($op)
    {
        $this->op = $op;

        return $this;
    }

    /**
     * Get op
     *
     * @return string
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * Set ficherosalida
     *
     * @param string $ficherosalida
     *
     * @return Configuracion
     */
    public function setFicherosalida($ficherosalida)
    {
        $this->ficherosalida = $ficherosalida;

        return $this;
    }

    /**
     * Get ficherosalida
     *
     * @return string
     */
    public function getFicherosalida()
    {
        return $this->ficherosalida;
    }

    /**
     * Set logs
     *
     * @param string $logs
     *
     * @return Configuracion
     */
    public function setLogs($logs)
    {
        $this->logs = $logs;

        return $this;
    }

    /**
     * Get logs
     *
     * @return string
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set paramejucucion
     *
     * @param string $paramejucucion
     *
     * @return Configuracion
     */
    public function setParamejucucion($paramejucucion)
    {
        $this->paramejucucion = $paramejucucion;

        return $this;
    }

    /**
     * Get paramejucucion
     *
     * @return string
     */
    public function getParamejucucion()
    {
        return $this->paramejucucion;
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
