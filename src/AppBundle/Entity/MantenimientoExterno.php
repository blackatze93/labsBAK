<?php

namespace AppBundle\Entity;

use AppBundle\Form\Type\UsuarioType;
use Doctrine\ORM\Mapping as ORM;

/**
 * MantenimientoExterno
 *
 * @ORM\Table(name="mantenimiento_externo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MantenimientoExternoRepository")
 */
class MantenimientoExterno
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombreEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombreTecnico;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", unique=true)
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $cedulaTecnico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $descripcion;

    // TODO: el usuario que registra el mantenimiento
    /**
     * @var UsuarioType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     * @Assert\NotBlank()
     */
    private $usuario;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * @param string $nombreEmpresa
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;
    }

    /**
     * @return string
     */
    public function getNombreTecnico()
    {
        return $this->nombreTecnico;
    }

    /**
     * @param string $nombreTecnico
     */
    public function setNombreTecnico($nombreTecnico)
    {
        $this->nombreTecnico = $nombreTecnico;
    }

    /**
     * @return int
     */
    public function getCedulaTecnico()
    {
        return $this->cedulaTecnico;
    }

    /**
     * @param int $cedulaTecnico
     */
    public function setCedulaTecnico($cedulaTecnico)
    {
        $this->cedulaTecnico = $cedulaTecnico;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
     * @return UsuarioType
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param UsuarioType $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}