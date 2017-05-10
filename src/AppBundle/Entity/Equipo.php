<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var Lugar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Lugar", inversedBy="equipos")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id", nullable=false, unique=false)
     * @Assert\Type("AppBundle\Entity\Lugar")
     * @Assert\NotBlank()
     */
    private $lugar;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $prestado;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Elemento", mappedBy="equipo")
     */
    private $elementos;

    /**
     * Equipo constructor.
     */
    public function __construct()
    {
        $this->elementos = new ArrayCollection();
        $this->setPrestado(false);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
    }

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
     * @return Lugar
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * @param Lugar $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * @return bool
     */
    public function isPrestado()
    {
        return $this->prestado;
    }

    /**
     * @param bool $prestado
     */
    public function setPrestado($prestado)
    {
        $this->prestado = $prestado;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validarElementos(ExecutionContextInterface $context)
    {
        $elementos = $this->getElementos();
        $lugar = $this->getLugar();

        for ($i = 0; $i < $elementos->count(); ++$i) {
            if ($elementos[$i]->getLugar() != $lugar) {
                $context->buildViolation('El elemento '.$elementos[$i].' debe estar en el mismo lugar que el equipo.')
                    ->atPath('elementos')
                    ->addViolation();
            }
        }
    }
}
