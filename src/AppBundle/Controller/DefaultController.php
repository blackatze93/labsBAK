<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
