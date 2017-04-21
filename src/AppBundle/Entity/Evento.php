<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Evento.
 *
 * @ORM\Table(name="evento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventoRepository")
 * @DoctrineAssert\UniqueEntity(fields={"lugar", "fecha", "horaInicio", "horaFin"}, repositoryMethod="findRangoEvento",
 *     message="Ya existe un evento asociado a esa fecha y lugar.")
 */
class Evento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_inicio", type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     */
    private $horaInicio;

    /**
     * @var \DateTime
     * @ORM\Column(name="hora_fin", type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     * @Assert\Expression(
     *     "this.getHoraInicio() < this.getHoraFin()",
     *     message="La hora final debe ser mayor a la hora de inicio"
     * )
     */
    private $horaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    // TODO: el usuario que registra el evento
    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuario;

    /**
     * @var Horario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Horario")
     * @ORM\JoinColumn(name="horario_id", referencedColumnName="id", nullable=true)
     * @Assert\Type("AppBundle\Entity\Horario")
     */
    private $horario;

    /**
     * Evento constructor.
     */
    public function __construct()
    {
        $this->fecha = new \DateTime();
        $this->horaInicio = new \DateTime();
        $this->horaFin = new \DateTime("+2 hours");
    }


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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * @param \DateTime $horaInicio
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;
    }

    /**
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * @param \DateTime $horaFin
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
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
     * @return Lugar
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param Lugar $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
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
     * @return Horario
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * @param Horario $horario
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validarHoras(ExecutionContextInterface $context)
    {
        $horaInicio = $this->getHoraInicio()->format('H:i');

        $horaFin = $this->getHoraFin()->format('H:i');

        $horaMin = new \DateTime('06:00');
        $horaMin = $horaMin->format('H:i');

        $horaMax = new \DateTime('22:00');
        $horaMax = $horaMax->format('H:i');

        if ($horaInicio < $horaMin || $horaInicio > $horaMax) {
            $context->buildViolation('La hora debería estar entre las 6am y 10pm.')
                ->atPath('horaInicio')
                ->addViolation()
            ;
        } elseif ($horaFin < $horaMin || $horaFin > $horaMax) {
            $context->buildViolation('La hora debería estar entre las 6am y 10pm.')
                ->atPath('horaFin')
                ->addViolation()
            ;
        }
    }
}
