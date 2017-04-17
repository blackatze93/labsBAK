<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;

// TODO: comprobar si se puede hacer un bulk import de las entidades
/**
 * Elemento.
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
     * @ORM\Column(type="string", length=45, nullable=false, unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\Length(max="60")
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=true, unique=true)
     * @Assert\Length(max="60")
     */
    private $serial;

    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar", inversedBy="elementos")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $fechaIngreso;

    // TODO: bueno, dañado
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $estado;

    // TODO: especializado, computador
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipo;

    // TODO: funcionanrio - estudiante
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipoPrestamo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $activo;

    /**
     * @var Equipo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipo", inversedBy="elementos")
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id", nullable=true)
     * @Assert\Type("AppBundle\Entity\Equipo")
     */
    private $equipo;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param string $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param string $serial
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    /**
     * @return Lugar
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param Lugar $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param \DateTime $fechaIngreso
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getTipoPrestamo()
    {
        return $this->tipoPrestamo;
    }

    /**
     * @param string $tipoPrestamo
     */
    public function setTipoPrestamo($tipoPrestamo)
    {
        $this->tipoPrestamo = $tipoPrestamo;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return bool
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param bool $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return Equipo
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * @param Equipo $equipo
     */
    public function setEquipo($equipo)
    {
        $this->equipo = $equipo;
    }

    function __toString()
    {
        return $this->getNombre();
    }
}
