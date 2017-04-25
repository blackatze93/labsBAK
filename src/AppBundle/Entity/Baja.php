<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Baja.
 *
 * @ORM\Table(name="baja")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BajaRepository")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class Baja
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
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
    private $fecha;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $cedulaRecibe;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombreRecibe;

    /**
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
     * @return string
     */
    public function getCedulaRecibe()
    {
        return $this->cedulaRecibe;
    }

    /**
     * @param string $cedulaRecibe
     */
    public function setCedulaRecibe($cedulaRecibe)
    {
        $this->cedulaRecibe = $cedulaRecibe;
    }

    /**
     * @return string
     */
    public function getNombreRecibe()
    {
        return $this->nombreRecibe;
    }

    /**
     * @param string $nombreRecibe
     */
    public function setNombreRecibe($nombreRecibe)
    {
        $this->nombreRecibe = $nombreRecibe;
    }
}
