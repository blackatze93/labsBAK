<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * ProyectoCurricular.
 *
 * @ORM\Table(name="proyecto_curricular")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoCurricularRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class ProyectoCurricular
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
     * @ORM\Column(name="nombre", type="string", length=45, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="facultad", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $facultad;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id..
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
     * @return ProyectoCurricular
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
     * Set facultad.
     *
     * @param string $facultad
     *
     * @return ProyectoCurricular
     */
    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;

        return $this;
    }

    /**
     * Get facultad.
     *
     * @return string
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }
}
