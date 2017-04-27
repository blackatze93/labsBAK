<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Documento.
 *
 * @ORM\Entity()
 * @ORM\Table(name="documento")
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
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var TipoDocumento
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoDocumento", inversedBy="documentos")
     * @ORM\JoinColumn(name="tipo_documento_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\TipoDocumento")
     */
    private $tipoDocumento;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Usuario")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="documentos", fileNameProperty="documento")}
     */
    private $documentoFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_subida", type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaSubida;

    /**
     * Documento constructor.
     */
    public function __construct()
    {
        $this->fechaSubida = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre();
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     * @param string $tipoDocumento
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
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
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param string $documento
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    /**
     * @return mixed
     */
    public function getDocumentoFile()
    {
        return $this->documentoFile;
    }

    /**
     * @param File|null $documento
     *
     * @internal param mixed $documentoFile
     */
    public function setDocumentoFile(File $documento = null)
    {
        $this->documentoFile = $documento;

        if ($documento) {
            $this->fechaSubida = new \DateTime();
        }
    }

    /**
     * @return \DateTime
     */
    public function getFechaSubida()
    {
        return $this->fechaSubida;
    }

    /**
     * @param \DateTime $fechaSubida
     */
    public function setFechaSubida($fechaSubida)
    {
        $this->fechaSubida = $fechaSubida;
    }
}
