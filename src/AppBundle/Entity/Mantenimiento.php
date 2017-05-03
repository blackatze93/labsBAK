<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mantenimiento.
 *
 * @ORM\Entity()
 * @ORM\Table(name="mantenimiento")
 */
class Mantenimiento
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fecha;

    /**
     * @var Elemento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Elemento")
     * @ORM\JoinColumn(name="elemento_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Elemento")
     * @Assert\NotBlank()
     */
    private $elemento;

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
     * Mantenimiento constructor.
     */
    public function __construct()
    {
        $this->fecha = new \DateTime();
    }

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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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
}
