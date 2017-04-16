<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Facultad.
 *
 * @ORM\Table(name="facultad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FacultadRepository")
 * @DoctrineAssert\UniqueEntity("nombre")
 */
class Facultad
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
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dependencia", mappedBy="facultad")
     */
    private $dependencias;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProyectoCurricular", mappedBy="facultad")
     */
    private $proyectosCurriculares;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return mixed
     */
    public function getDependencias()
    {
        return $this->dependencias;
    }

    /**
     * @return mixed
     */
    public function getProyectosCurriculares()
    {
        return $this->proyectosCurriculares;
    }

    public function __construct()
    {
        $this->dependencias = new ArrayCollection();
        $this->proyectosCurriculares = new ArrayCollection();
    }
}
