<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsuarioController extends Controller
{
    /**
     * @Route("/usuario/", name="usuario_index")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository("AppBundle:Usuario")->findAll();

        return $this->render('usuario/index.html.twig', array('usuarios' => $usuarios));
    }

}