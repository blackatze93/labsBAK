<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
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
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     * @Assert\Length(max="60")
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
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\Length(max="60")
     */
    private $funciones;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $fechaAlta;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $estaActivo;

    /**
     * @var Dependencia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Dependencia")
     * @Assert\NotBlank()
     */
    private $dependencia;

    /**
     * Usuario constructor.
     */
    public function __construct() {
        $this->fechaAlta = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getNombre().' '.$this->getApellido();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getFunciones()
    {
        return $this->funciones;
    }

    /**
     * @param string $funciones
     */
    public function setFunciones($funciones)
    {
        $this->funciones = $funciones;
    }

    /**
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * @param \DateTime $fechaAlta
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
    }

    /**
     * @return boolean
     */
    public function getEstaActivo()
    {
        return $this->estaActivo;
    }

    /**
     * @param boolean $estaActivo
     */
    public function setEstaActivo($estaActivo)
    {
        $this->estaActivo = $estaActivo;
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
    public function getRoles() {
        return array($this->cargo);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {
        return $this->getId();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
        $this->passwordEnClaro = null;
    }

    /**
     * (@inheritdoc)
     */
    public function isAccountNonExpired() {
        return true;
    }

    /**
     * (@inheritdoc)
     */
    public function isAccountNonLocked() {
        return true;
    }

    /**
     * (@inheritdoc)
     */
    public function isCredentialsNonExpired() {
        return true;
    }

    /**
     * (@inheritdoc)
     */
    public function isEnabled() {
        return $this->estaActivo;
    }
}
