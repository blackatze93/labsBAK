<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Elemento
 *
 * @ORM\Table(name="elemento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElementoRepository")
 */
class Elemento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=45)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=60)
     */
    private $serial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaIngreso", type="date", nullable=true)
     */
    private $fechaIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=255)
     */
    private $ubicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoPrestamo", type="string", length=255)
     */
    private $tipoPrestamo;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255)
     */
    private $marca;


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
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Elemento
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
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
}
