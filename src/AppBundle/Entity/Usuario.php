<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @ORM\Column()
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column()
     */
    private $nombre;

    /**
     * @ORM\Column()
     */
    private $apellido;

    /**
     * @ORM\Column()
     */
    private $email;

    /**
     * @ORM\Column()
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaAlta;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProyectoCurricular")
     */
    private $proyectoCurricular;

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




}
