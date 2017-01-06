<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @DoctrineAssert\UniqueEntity("id")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Column(type="string", length=15, unique=true)
     * @ORM\Id
     * @Assert\NotBlank()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @Assert\Length(min = 6)
     * @Assert\NotBlank(groups={"registro"})
     */
    private $passwordEnClaro;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\NotBlank()
     */
    private $cargo;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $funciones;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $fechaAlta;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $estaActivo;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dependencia")
     * @ORM\JoinColumn(name="dependencia_id", referencedColumnName="id", nullable=false)
     * @Assert\Type("AppBundle\Entity\Dependencia")
     * @Assert\NotBlank()
     */
    private $dependencia;

    public function __construct() {
        $this->fechaAlta = new \DateTime();
    }

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
     * @return mixed
     */
    public function getPasswordEnClaro()
    {
        return $this->passwordEnClaro;
    }

    /**
     * @param mixed $passwordEnClaro
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
     * @return mixed
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param mixed $cargo
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    /**
     * @return mixed
     */
    public function getFunciones()
    {
        return $this->funciones;
    }

    /**
     * @param mixed $funciones
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
     * @return mixed
     */
    public function getEstaActivo()
    {
        return $this->estaActivo;
    }

    /**
     * @param mixed $estaActivo
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
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return array($this->cargo);
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
        // TODO: Implement getSalt() method.
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        $this->getId();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        $this->passwordEnClaro = null;
    }
}
