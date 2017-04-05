<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Dependencia.
 *
 * @ORM\Table(name="dependencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DependenciaRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class Dependencia
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var Facultad
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facultad")
     * @ORM\JoinColumn(name="facultad_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Facultad")
     * @Assert\NotBlank()
     */
    private $facultad;

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
     * @return Facultad
     */
    public function getFacultad()
    {
        return $this->facultad;
    }

    /**
     * @param Facultad $facultad
     */
    public function setFacultad($facultad)
    {
        $this->facultad = $facultad;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre().' - '.$this->getFacultad();
    }
}
