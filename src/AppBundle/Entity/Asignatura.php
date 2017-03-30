<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

// TODO: completar asignatura
/**
 * Asignatura
 *
 * @ORM\Table(name="asignatura")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsignaturaRepository")
 * @DoctrineAssert\UniqueEntity("id")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class Asignatura
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
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var ProyectoCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProyectoCurricular")
     * @ORM\JoinColumn(name="proyecto_curricular_id", referencedColumnName="id", nullable=true)
     * @Assert\Type("AppBundle\Entity\ProyectoCurricular")
     * @Assert\NotBlank()
     */
    private $proyectoCurricular;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Asignatura
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
}
