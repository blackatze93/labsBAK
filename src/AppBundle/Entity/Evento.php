<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Evento.
 *
 * @ORM\Table(name="evento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventoRepository")
 */
// TODO: configurar las relaciones y los constraints de la entidad, la llave primaria
class Evento
{
    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="fecha_inicio", type="string", unique=true, nullable=false)
     * @Assert\DateTime()
     */
    private $fecha_inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_fin", type="string", unique=true, nullable=false)
     * @Assert\DateTime()
     */
    private $fecha_fin;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="materia", type="string", length=45, unique=false, nullable=true)
     * @Assert\Length(max="45")
     */
    private $materia;

    /**
     * @var int
     *
     * @ORM\Column(name="grupo", type="integer", unique=false, nullable=true)
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
    public function setFechaInicio(\DateTime $fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio->format('Y-m-d H:i:s');
    }

    /**
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->fecha_inicio);
    }

    /**
     * @param \DateTime $fecha_fin
     */
    public function setFechaFin(\DateTime $fecha_fin)
    {
        $this->fecha_fin = $fecha_fin->format('Y-m-d H:i:s');
    }

    /**
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->fecha_fin);
    }

    /**
     * Set tipo.
     *
     * @param string $tipo
     *
     * @return Evento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo.
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
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
     * @param int $grupo
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
     * @return int
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
}
