<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuarios/", name="usuarios_inicio")
     */
    public function inicioAction() {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository("AppBundle:Usuario")->findAll();

        return $this->render('usuario/inicio.html.twig', array('usuarios' => $usuarios));
    }

}