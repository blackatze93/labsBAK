<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Elemento
 *
 * @ORM\Table(name="elemento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElementoRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity("serial")
 */
class Elemento
{
    // TODO: placa del equipo
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=20, nullable=false, unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=60, nullable=true)
     * @Assert\Length(max="60")
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $descripcion;

    // TODO: disponible, clase, practica, mirar si este atributo debe ir ahi
    // TODO: mirar si con un trigger se puede usar
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $estado;

    // TODO: especializado, computador
    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=60, nullable=true, unique=true)
     * @Assert\Length(max="60")
     */
    private $serial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaIngreso", type="date", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fechaIngreso;

    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    // TODO: funcionanrio - estudiante
    /**
     * @var string
     *
     * @ORM\Column(name="tipoPrestamo", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipoPrestamo;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

    /**
     * Set id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Elemento
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
     * Set marca
     *
     * @param string $marca
     * @return Elemento
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Elemento
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
     * Set estado
     *
     * @param string $estado
     * @return Elemento
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Elemento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return Elemento
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Elemento
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param Lugar $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return Lugar
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set tipoPrestamo
     *
     * @param string $tipoPrestamo
     * @return Elemento
     */
    public function setTipoPrestamo($tipoPrestamo)
    {
        $this->tipoPrestamo = $tipoPrestamo;

        return $this;
    }

    /**
     * Get tipoPrestamo
     *
     * @return string 
     */
    public function getTipoPrestamo()
    {
        return $this->tipoPrestamo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Elemento
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
