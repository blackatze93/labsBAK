<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * BajaElemento.
 *
 * @ORM\Entity()
 * @ORM\Table(name="baja_elemento")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class BajaElemento
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
     * @var Baja
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Baja")
     * @ORM\JoinColumn(name="baja_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Baja")
     */
    private $baja;

    /**
     * @var Elemento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Elemento")
     * @ORM\JoinColumn(name="elemento_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Elemento")
     */
    private $elemento;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $observacion;

    /**
     * @var MotivoBaja
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MotivoBaja")
     * @ORM\JoinColumn(name="motivo_baja_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\MotivoBaja")
     */
    private $motivoBaja;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Baja
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * @param Baja $baja
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
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
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    }

    /**
     * @return MotivoBaja
     */
    public function getMotivoBaja()
    {
        return $this->motivoBaja;
    }

    /**
     * @param MotivoBaja $motivoBaja
     */
    public function setMotivoBaja($motivoBaja)
    {
        $this->motivoBaja = $motivoBaja;
    }
}
