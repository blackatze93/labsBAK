<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    // TODO: mirar si la relacion no es muchos a muchos
    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    // TODO: mirar la relacion de estudiante y usuario

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
}
