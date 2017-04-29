<?php

namespace AppBundle\EventListener;

use JavierEguiluz\Bundle\EasyAdminBundle\Exception\EntityRemoveException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class ExceptionListener
 * @package AppBundle\EventListener
 */
class ExceptionListener
{
    private $router;

    /**
     * ExceptionListener constructor.
     * @param Router $router
     * @param Session $session
     */
    public function __construct(Router $router, Session $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) {
        // You get the exception object from the received event
        $exception = $event->getException();

        if ($exception instanceof EntityRemoveException) {
            $easyadmin = $event->getRequest()->attributes->get('easyadmin');
            $url = $this->router->generate('easyadmin', array('action' => 'list', 'entity' => $easyadmin['entity']['name']));
            $this->session->getFlashBag()->add('error', 'No se puede eliminar la entidad');
            $event->setResponse(new RedirectResponse($url));
        }
    }
}