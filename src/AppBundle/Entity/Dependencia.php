<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Dependencia.
 *
 * @ORM\Entity()
 * @ORM\Table(name="dependencia")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class Dependencia
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
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $codigo;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facultad", inversedBy="dependencias")
     * @ORM\JoinColumn(name="facultad_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $facultad;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre().' - '.$this->getFacultad();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
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
}
