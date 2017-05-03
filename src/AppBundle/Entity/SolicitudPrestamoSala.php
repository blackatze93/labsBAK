<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SolicitudPrestamoSala.
 *
 * @ORM\Entity()
 * @ORM\Table(name="solicitud_prestamo_sala")
 */
class SolicitudPrestamoSala
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // TODO: pendiente, aprobado, rechazado
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaRespuesta;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observaciones;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_realiza_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     * @Assert\NotBlank()
     */
    private $usuarioRealiza;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_responde_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     * @Assert\NotBlank()
     */
    private $usuarioResponde;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return \DateTime
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * @param \DateTime $fechaSolicitud
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    /**
     * @return \DateTime
     */
    public function getFechaRespuesta()
    {
        return $this->fechaRespuesta;
    }

    /**
     * @param \DateTime $fechaRespuesta
     */
    public function setFechaRespuesta($fechaRespuesta)
    {
        $this->fechaRespuesta = $fechaRespuesta;
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
    public function getUsuarioRealiza()
    {
        return $this->usuarioRealiza;
    }

    /**
     * @param Usuario $usuarioRealiza
     */
    public function setUsuarioRealiza($usuarioRealiza)
    {
        $this->usuarioRealiza = $usuarioRealiza;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioResponde()
    {
        return $this->usuarioResponde;
    }

    /**
     * @param Usuario $usuarioResponde
     */
    public function setUsuarioResponde($usuarioResponde)
    {
        $this->usuarioResponde = $usuarioResponde;
    }
}
