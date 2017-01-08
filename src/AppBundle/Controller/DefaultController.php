<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Metodo que genera la pagina principal del sitio web
     *
     * @Route("/", name="index")
     */
    public function indexAction() {
        return $this->render('index.html.twig');
    }
}
 