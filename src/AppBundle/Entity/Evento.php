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
     * @Assert\NotBlank()
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Lugar $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return Lugar
     */
    public function getLugar()
    {
        return $this->lugar;
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
    public function getFecha()
    {
        return $this->fecha;
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
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * @param \DateTime $horaFin
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;
    }

    /**
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * @param int $semanas
     */
    public function setSemanas($semanas)
    {
        $this->semanas = $semanas;
    }

    /**
     * @return int
     */
    public function getSemanas()
    {
        return $this->semanas;
    }

    /**
     * Set estado.
     *
     * @param string $estado
     *
     * @return Evento
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set materia.
     *
     * @param string $materia
     *
     * @return Evento
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;

        return $this;
    }

    /**
     * Get materia.
     *
     * @return string
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set grupo.
     *
     * @param string $grupo
     *
     * @return Evento
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set observaciones.
     *
     * @param string $observaciones
     *
     * @return Evento
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
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
