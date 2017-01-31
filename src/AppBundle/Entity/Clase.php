<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Clase.
 *
 * @ORM\Table(name="clase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClaseRepository")
 * @DoctrineAssert\UniqueEntity(fields={"lugar", "fecha_inicio", "fecha_fin"}, repositoryMethod="findRangoClases",
 *     message="Ya existe una clase asociada a esa fecha y lugar.")
 */

// TODO: modificar fecha inicio y fecha fin para solo una fecha y dos horas hora inicio hora fin
class Clase
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
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=false, unique=false)
     * @Assert\DateTime()
     */
    private $fecha_inicio;

    /**
     * @var \DateTime
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=false, unique=false)
     * @Assert\DateTime()
     * @Assert\Expression(
     *     "this.getFechaInicio() < this.getFechaFin()",
     *     message="La fecha final debe ser mayor a la fecha de inicio"
     * )
     */
    private $fecha_fin;

    /**
     * @var int
     *
     * @Assert\NotBlank(groups={"new"})
     * @Assert\Range(min="1", max="50")
     */
    private $semanas;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=15, nullable=false, unique=false)
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="materia", type="string", length=45, unique=false, nullable=true)
     * @Assert\Length(max="45")
     */
    private $materia;

    /**
     * @var string
     *
     * @ORM\Column(name="grupo", type="string", length=10, unique=false, nullable=true)
     * @Assert\Length(max="10")
     */
    private $grupo;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, unique=false, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

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
     * @param \DateTime $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param \DateTime $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
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
     * @return Clase
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
     * @return Clase
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
     * @return Clase
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
     * @return Clase
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
        $horaInicio = $this->getFechaInicio()->format('H:i');

        $horaFin = $this->getFechaFin()->format('H:i');

        $horaMin = new \DateTime('06:00');
        $horaMin = $horaMin->format('H:i');

        $horaMax = new \DateTime('22:00');
        $horaMax = $horaMax->format('H:i');

        if ($horaInicio < $horaMin || $horaInicio > $horaMax) {
            $context->buildViolation('La hora debería estar entre las 6am y 10pm.')
                ->atPath('fecha_inicio')
                ->addViolation()
            ;
        } elseif ($horaFin < $horaMin || $horaFin > $horaMax) {
            $context->buildViolation('La hora debería estar entre las 6am y 10pm.')
                ->atPath('fecha_fin')
                ->addViolation()
            ;
        }
    }
}
