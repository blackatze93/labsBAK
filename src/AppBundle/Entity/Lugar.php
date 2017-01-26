<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Lugar.
 *
 * @ORM\Table(name="lugar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LugarRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity("nombre")
 */
class Lugar
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", unique=true)
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidad", type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="100")
     */
    private $capacidad;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $visible;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=true)
     * @Assert\Length(max="100")
     */
    private $descripcion;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Lugar
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set capacidad.
     *
     * @param int $capacidad
     *
     * @return Lugar
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad.
     *
     * @return int
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return Lugar
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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

//        if ($this->url !== null) {
//            $event['url'] = $this->url;
//        }
//
//        if ($this->bgColor !== null) {
//            $event['backgroundColor'] = $this->bgColor;
//            $event['borderColor'] = $this->bgColor;
//        }
//
//        if ($this->fgColor !== null) {
//            $event['textColor'] = $this->fgColor;
//        }
//
//        if ($this->cssClass !== null) {
//            $event['className'] = $this->cssClass;
//        }
//
//
//        foreach ($this->otherFields as $field => $value) {
//            $event[$field] = $value;
//        }

        return $lugar;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }
}
