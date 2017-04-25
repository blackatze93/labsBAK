<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * PrestamoElemento.
 *
 * @ORM\Table(name="prestamo_elemento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestamoElementoRepository")
 */
class PrestamoElemento
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
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaPrestamo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaDevolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuario;

    /**
     * @var Elemento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Elemento")
     * @ORM\JoinColumn(name="elemento_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Elemento")
     */
    private $elemento;

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
     * @return \DateTime
     */
    public function getFechaPrestamo()
    {
        return $this->fechaPrestamo;
    }

    /**
     * @param \DateTime $fechaPrestamo
     */
    public function setFechaPrestamo($fechaPrestamo)
    {
        $this->fechaPrestamo = $fechaPrestamo;
    }

    /**
     * @return \DateTime
     */
    public function getFechaDevolucion()
    {
        return $this->fechaDevolucion;
    }

    /**
     * @param \DateTime $fechaDevolucion
     */
    public function setFechaDevolucion($fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
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

    /*
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
//    public function validarUsuario(ExecutionContextInterface $context)
//    {
//        if (is_null($this->estudiante) && is_null($this->usuario)){
//            $context->buildViolation('Debe asignar un estudiante o usuario al prestamo.')
//                ->atPath('estudiante')
//                ->addViolation()
//            ;
//        } elseif (!is_null($this->estudiante) && !is_null($this->usuario)) {
//            $context->buildViolation('No puede asignar un prestamo a un estudiante y un usuario al mismo tiempo.')
//                ->atPath('usuario')
//                ->addViolation();
//        }
//    }
}
