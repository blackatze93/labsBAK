<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Facultad
 *
 * @ORM\Table(name="facultad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacultadRepository")
 * @DoctrineAssert\UniqueEntity("id")
 */
class Facultad
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
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
}
