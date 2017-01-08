<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Dependencia
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DependenciaRepository")
 * @DoctrineAssert\UniqueEntity("id")
 */
class Dependencia
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10, unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
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
     * @return Dependencia
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
     * @return string
     */
    public function __toString() {
        return $this->getNombre();
    }
}
