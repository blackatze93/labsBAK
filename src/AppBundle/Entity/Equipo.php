<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Equipo.
 *
 * @ORM\Entity()
 * @ORM\Table(name="equipo")
 * @DoctrineAssert\UniqueEntity("nombre")
 */
class Equipo
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elemento", mappedBy="equipo")
     */
    private $elementos;

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
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Equipo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getElementos()
    {
        return $this->elementos;
    }

    /**
     * @param $elemento
     *
     * @return $this
     */
    public function addElemento(Elemento $elemento)
    {
        $this->elementos[] = $elemento;
        $elemento->setEquipo($this);

        return $this;
    }

    /**
     * @param $elemento
     *
     * @return $this
     */
    public function removeElemento(Elemento $elemento)
    {
        $this->elementos->removeElement($elemento);
        $elemento->setEquipo(null);

        return $this;
    }

    /**
     * Equipo constructor.
     */
    public function __construct()
    {
        $this->elementos = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }
}
