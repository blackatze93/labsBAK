<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function inicioAction()
    {
        // replace this example code with whatever you need
        return $this->render('index.html.twig');
    }
    
    /**
     * @Route ("/nosotros/mision/", name="nosotros_mision")
     */
    public function visionAction() {
        
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/usuario/", name="usuario")
     */
    public function usuarioAction() {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository("AppBundle:Usuario")->findAll();

        return new Response(implode($usuarios));
    }
}
