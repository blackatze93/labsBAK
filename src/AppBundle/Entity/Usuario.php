<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Usuario.
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * @DoctrineAssert\UniqueEntity("id")
 */
class Usuario implements AdvancedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="bigint", unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", unique=true)
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)-
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\Length(min = 6)
     * @Assert\NotBlank(groups={"new"})
     */
    private $passwordEnClaro;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $rol;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100")
     */
    private $cargo;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaCreacion;

    // TODO: paz y salvo o en mora
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     */
    private $estado;

    /**
     * @var Dependencia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id", nullable=true)
     * @Assert\Type("AppBundle\Entity\Dependencia")
     */
    private $dependencia;

    /**
     * @var ProyectoCurricular
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProyectoCurricular")
     * @ORM\JoinColumn(name="proyecto_curricular_id", referencedColumnName="id", nullable=true)
     * @Assert\Type("AppBundle\Entity\ProyectoCurricular")
     */
    private $proyectoCurricular;

    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->fechaCreacion = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNombre().' '.$this->getApellido();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param int $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
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
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPasswordEnClaro()
    {
        return $this->passwordEnClaro;
    }

    /**
     * @param string $passwordEnClaro
     */
    public function setPasswordEnClaro($passwordEnClaro)
    {
        $this->passwordEnClaro = $passwordEnClaro;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * @param string $rol
     */
    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    /**
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param string $cargo
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    /**
     * @return bool
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param bool $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param \DateTime $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * @param Dependencia %dependencia
     */
    public function setDependencia(Dependencia $dependencia)
    {
        $this->dependencia = $dependencia;
    }

    /**
     * @return ProyectoCurricular
     */
    public function getProyectoCurricular()
    {
        return $this->proyectoCurricular;
    }

    /**
     * @param ProyectoCurricular $proyectoCurricular
     */
    public function setProyectoCurricular(ProyectoCurricular $proyectoCurricular)
    {
        $this->proyectoCurricular = $proyectoCurricular;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array($this->rol);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getId();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->passwordEnClaro = null;
    }

    /**
     * ({@inheritdoc}).
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * ({@inheritdoc}).
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * ({@inheritdoc}).
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * ({@inheritdoc}).
     */
    public function isEnabled()
    {
        return $this->isActivo();
    }
}
