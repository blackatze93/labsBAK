<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Lugar.
 *
 * @ORM\Table(name="lugar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LugarRepository")
 * @DoctrineAssert\UniqueEntity("nombre")
 */
class Lugar
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
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $visible;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elemento", mappedBy="lugar")
     */
    private $elementos;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ElementoPerdido", mappedBy="lugar")
     */
    private $elementosPerdidos;


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

    /**
     * @return mixed
     */
    public function getElementos()
    {
        return $this->elementos;
    }
    
    /**
     * @return mixed
     */
    public function getElementosPerdidos()
    {
        return $this->elementosPerdidos;
    }

    public function __construct()
    {
        $this->elementos = new ArrayCollection();
        $this->elementosPerdidos = new ArrayCollection();
    }

    function __toString()
    {
        return $this->getNombre();
    }
}
