<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Documento.
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentoRepository")
 * @Vich\Uploadable
 */
class Documento
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
     * @ORM\Column(name="fecha", type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $tipo;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     * @Assert\NotBlank()
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $documento;

    /**
     * @var File
     *
     *
     */
    private $documentoFile;
}
