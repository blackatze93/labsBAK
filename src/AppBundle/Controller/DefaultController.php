<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
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
 