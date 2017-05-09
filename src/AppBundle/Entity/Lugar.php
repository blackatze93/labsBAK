<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lugar.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LugarRepository")
 * @ORM\Table(name="lugar")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity("nombre")
 */
class Lugar
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min="0", max="100")
     */
    private $cantidadEquipos;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Equipo", mappedBy="lugar", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $equipos;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $visible;

    /**
     * Lugar constructor.
     *
     * @param $equipos
     */
    public function __construct()
    {
        $this->equipos = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }

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
     * @return int
     */
    public function getCantidadEquipos()
    {
        return $this->cantidadEquipos;
    }

    /**
     * @param int $cantidadEquipos
     */
    public function setCantidadEquipos($cantidadEquipos)
    {
        $this->cantidadEquipos = $cantidadEquipos;
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
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return mixed
     */
    public function getEquipos()
    {
        return $this->equipos;
    }

    /**
     * Convert lugar details to an array to use in calendar.
     *
     * @return array $lugar
     */
    public function toArray()
    {
        $lugar = array();

        $lugar['id'] = $this->id;
        $lugar['title'] = $this->nombre;

        return $lugar;
    }
}
