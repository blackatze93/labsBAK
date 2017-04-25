<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * TrasladoElemento.
 *
 * @ORM\Table(name="traslado_elemento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrasladoElementoRepository")
 * @DoctrineAssert\UniqueEntity(fields={"nombre", "facultad"})
 */
class TrasladoElemento
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
     * @var Traslado
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Traslado")
     * @ORM\JoinColumn(name="traslado_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Traslado")
     */
    private $traslado;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Traslado
     */
    public function getTraslado()
    {
        return $this->traslado;
    }

    /**
     * @param Traslado $traslado
     */
    public function setTraslado($traslado)
    {
        $this->traslado = $traslado;
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
}
