<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Traslado.
 *
 * @ORM\Entity()
 * @ORM\Table(name="traslado")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class Traslado
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
     * @ORM\JoinColumn(name="usuario_entrega_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuarioEntrega;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_recibe_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuarioRecibe;

    /**
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar")
     * @ORM\JoinColumn(name="lugar_destino_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     */
    private $lugarDestino;

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
    public function getUsuarioEntrega()
    {
        return $this->usuarioEntrega;
    }

    /**
     * @param Usuario $usuarioEntrega
     */
    public function setUsuarioEntrega($usuarioEntrega)
    {
        $this->usuarioEntrega = $usuarioEntrega;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioRecibe()
    {
        return $this->usuarioRecibe;
    }

    /**
     * @param Usuario $usuarioRecibe
     */
    public function setUsuarioRecibe($usuarioRecibe)
    {
        $this->usuarioRecibe = $usuarioRecibe;
    }

    /**
     * @return Lugar
     */
    public function getLugarDestino()
    {
        return $this->lugarDestino;
    }

    /**
     * @param Lugar $lugarDestino
     */
    public function setLugarDestino($lugarDestino)
    {
        $this->lugarDestino = $lugarDestino;
    }
}
