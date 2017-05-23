<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pagina.
 *
 * @ORM\Entity()
 * @ORM\Table(name="pagina")
 */
class Pagina
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenido;

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
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param string $contenido
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }
}
