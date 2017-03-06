<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * PrestamoElemento
 *
 * @ORM\Table(name="prestamo_elemento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestamoElementoRepository")
 */
class PrestamoElemento
{
    /**
     * @var Prestamo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prestamo")
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
     * @return Prestamo
     */
    public function getPrestamo()
    {
        return $this->prestamo;
    }

    /**
     * @param Prestamo $prestamo
     */
    public function setPrestamo($prestamo)
    {
        $this->prestamo = $prestamo;
    }

    /**
     * @return Elemento
     */
    public function getElemento()
    {
        return $this->elemento;
    }

    /**
     * @param Elemento $elemento
     */
    public function setElemento($elemento)
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
