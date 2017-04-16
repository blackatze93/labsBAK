<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ElementoPrestamo.
 *
 * @ORM\Table(name="elemento_prestamo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElementoPrestamoRepository")
 */
class ElementoPrestamo
{
    /**
     * @var Prestamo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prestamo", inversedBy="elementos_prestamo")
     * @ORM\JoinColumn(name="prestamo_id", referencedColumnName="id", nullable=false)
     * @ORM\Id
     * @Assert\Type("AppBundle\Entity\Prestamo")
     * @Assert\NotBlank()
     */
    private $prestamo;

    /**
     * @var Elemento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Elemento")
     * @ORM\JoinColumn(name="elemento_id", referencedColumnName="id", nullable=false)
     * @ORM\Id
     * @Assert\Type("AppBundle\Entity\Elemento")
     * @Assert\NotBlank()
     */
    private $elemento;

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
     * @ORM\Column(name="descripcion_devolucion", type="string", length=45, nullable=true)
     * @Assert\Length(max="45")
     */
    private $descripcionDevolucion;

    /**
     * Get prestamo.
     *
     * @return Prestamo
     */
    public function getPrestamo()
    {
        return $this->prestamo;
    }

    /**
     * Set prestamo.
     *
     * @param Prestamo $prestamo
     *
     * @return ElementoPrestamo
     */
    public function setPrestamo(Prestamo $prestamo = null)
    {
        $this->prestamo = $prestamo;

        return $this;
    }

    /**
     * Get elemento.
     *
     * @return Elemento
     */
    public function getElemento()
    {
        return $this->elemento;
    }

    /**
     * Set elemento.
     *
     * @param Elemento $elemento
     */
    public function setElemento(Elemento $elemento)
    {
        $this->elemento = $elemento;
    }

    /**
     * @return string
     */
    public function getEstadoDevolucion()
    {
        return $this->estadoDevolucion;
    }

    /**
     * @param string $estadoDevolucion
     */
    public function setEstadoDevolucion($estadoDevolucion)
    {
        $this->estadoDevolucion = $estadoDevolucion;
    }

    /**
     * @return string
     */
    public function getDescripcionDevolucion()
    {
        return $this->descripcionDevolucion;
    }

    /**
     * @param string $descripcionDevolucion
     */
    public function setDescripcionDevolucion($descripcionDevolucion)
    {
        $this->descripcionDevolucion = $descripcionDevolucion;
    }
}
