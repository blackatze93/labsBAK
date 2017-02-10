<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Prestamo.
 *
 * @ORM\Table(name="prestamo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestamoRepository")
 */
class Prestamo
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_prestamo", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaPrestamo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_devolucion", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $fechaDevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_devolucion", type="string", length=45, nullable=true)
     * @Assert\Length(max="45")
     */
    private $estadoDevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_devolucion", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $descripcionDevolucion;

    /**
     * @var Elemento
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Elemento")
     * @Assert\Type("AppBundle\Entity\Elemento")
     */
    private $elemento;

    /**
     * @var Estudiante
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Estudiante")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id", nullable=true, unique=false)
     * @Assert\Type("AppBundle\Entity\Estudiante")
     */
    private $estudiante;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true, unique=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuario;

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
     * Set fechaPrestamo.
     *
     * @param \DateTime $fechaPrestamo
     *
     * @return Prestamo
     */
    public function setFechaPrestamo($fechaPrestamo)
    {
        $this->fechaPrestamo = $fechaPrestamo;

        return $this;
    }

    /**
     * Get fechaPrestamo.
     *
     * @return \DateTime
     */
    public function getFechaPrestamo()
    {
        return $this->fechaPrestamo;
    }

    /**
     * Set fechaDevolucion.
     *
     * @param \DateTime $fechaDevolucion
     *
     * @return Prestamo
     */
    public function setFechaDevolucion($fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;

        return $this;
    }

    /**
     * Get fechaDevolucion.
     *
     * @return \DateTime
     */
    public function getFechaDevolucion()
    {
        return $this->fechaDevolucion;
    }

    /**
     * Set estadoDevolucion.
     *
     * @param string $estadoDevolucion
     *
     * @return Prestamo
     */
    public function setEstadoDevolucion($estadoDevolucion)
    {
        $this->estadoDevolucion = $estadoDevolucion;

        return $this;
    }

    /**
     * Get estadoDevolucion.
     *
     * @return string
     */
    public function getEstadoDevolucion()
    {
        return $this->estadoDevolucion;
    }

    /**
     * Set descripcionDevolucion.
     *
     * @param string $descripcionDevolucion
     *
     * @return Prestamo
     */
    public function setDescripcionDevolucion($descripcionDevolucion)
    {
        $this->descripcionDevolucion = $descripcionDevolucion;

        return $this;
    }

    /**
     * Get descripcionDevolucion.
     *
     * @return string
     */
    public function getDescripcionDevolucion()
    {
        return $this->descripcionDevolucion;
    }

    /**
     * @param Estudiante $estudiante
     */
    public function setEstudiante($estudiante)
    {
        $this->estudiante = $estudiante;
    }

    /**
     * @return Estudiante
     */
    public function getEstudiante()
    {
        return $this->estudiante;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }


    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validarUsuario(ExecutionContextInterface $context)
    {
        if (is_null($this->estudiante) && is_null($this->usuario)){
            $context->buildViolation('Debe asignar un estudiante o usuario al prestamo.')
                ->atPath('estudiante')
                ->addViolation()
            ;
        } elseif (!is_null($this->estudiante) && !is_null($this->usuario)) {
            $context->buildViolation('No puede asignar un prestamo a un estudiante y un usuario al mismo tiempo.')
                ->atPath('usuario')
                ->addViolation();
        }
    }
}
