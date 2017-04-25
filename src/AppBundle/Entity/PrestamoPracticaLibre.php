<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * PrestamoPracticaLibre.
 *
 * @ORM\Table(name="prestamo_practica_libre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestamoPracticaLibreRepository")
 */
class PrestamoPracticaLibre
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fechaPrestamo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     */
    private $horaEntrada;

    /**
     * @var \DateTime
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     * @Assert\Expression(
     *     "this.getHoraEntrada() < this.getHoraSalida()",
     *     message="La hora final debe ser mayor a la hora de inicio"
     * )
     */
    private $horaSalida;

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
     * @var Equipo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipo")
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Equipo")
     */
    private $equipo;

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
    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }

    /**
     * @param \DateTime $horaEntrada
     */
    public function setHoraEntrada($horaEntrada)
    {
        $this->horaEntrada = $horaEntrada;
    }

    /**
     * @return \DateTime
     */
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    /**
     * @param \DateTime $horaSalida
     */
    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;
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
     * @return Equipo
     */
    public function getEquipo()
    {
        return $this->equipo;
    }

    /**
     * @param Equipo $equipo
     */
    public function setEquipo($equipo)
    {
        $this->equipo = $equipo;
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
