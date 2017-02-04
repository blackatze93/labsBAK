<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Estudiante.
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EstudianteRepository")
 * @DoctrineAssert\UniqueEntity("id")
 */
class Estudiante
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     * @Assert\Email()
     * @Assert\Length(max="100")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $estado;

    /**
     * @var ProyectoCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProyectoCurricular")
     * @ORM\JoinColumn(name="proyectocurricular_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\ProyectoCurricular")
     * @Assert\NotBlank()
     */
    private $proyectocurricular;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Estudiante
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
     * Set apellido
     *
     * @param string $apellido
     * @return Estudiante
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Estudiante
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Estudiante
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param ProyectoCurricular $proyectocurricular
     */
    public function setProyectocurricular($proyectocurricular)
    {
        $this->proyectocurricular = $proyectocurricular;
    }

    /**
     * @return ProyectoCurricular
     */
    public function getProyectocurricular()
    {
        return $this->proyectocurricular;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre().' '.$this->getApellido();
    }
}
