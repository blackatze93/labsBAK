<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evento;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

/**
 * Class EventoController.
 */
class EventoController extends BaseAdminController
{
    protected function newAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_NEW);

        $entity = $this->createNewEntity();

        $easyadmin = $this->request->attributes->get('easyadmin');
        $easyadmin['item'] = $entity;
        $this->request->attributes->set('easyadmin', $easyadmin);

        $fields = $this->entity['new']['fields'];

        $newForm = $this->createNewForm($entity, $fields);

        $newForm->handleRequest($this->request);
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));

            $this->prePersistEntity($entity);

            // Obtiene el usuario logueado
            $usuario = $this->getUser();

            // Obtiene la cantidad de semanas que se debe repetir el evento
            $semanas = $entity->getSemanas();

            // Se crean tantos eventos como repeticiones en el campo semanas se indica
            for ($i = 0; $i < $semanas; ++$i) {
                $evento = new Evento();
                $fechaAux = clone $entity->getFecha();
                $evento->setLugar($entity->getLugar());
                $evento->setFecha($fechaAux->modify('+'.$i.' week'));
                $evento->setHoraInicio($entity->getHoraInicio());
                $evento->setHoraFin($entity->getHoraFin());
                $evento->setEstado($entity->getEstado());
                $evento->setAsignatura($entity->getAsignatura());
                $evento->setGrupo($entity->getGrupo());
                $evento->setUsuarioRegistra($usuario);
                $evento->setObservaciones($entity->getObservaciones());

                $this->em->persist($evento);
            }

            $this->em->flush();

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            $refererUrl = $this->request->query->get('referer', '');

            return !empty($refererUrl)
                ? $this->redirect(urldecode($refererUrl))
                : $this->redirect($this->generateUrl('easyadmin', array('action' => 'list', 'entity' => $this->entity['name'])));
        }

        $this->dispatch(EasyAdminEvents::POST_NEW, array(
            'entity_fields' => $fields,
            'form' => $newForm,
            'entity' => $entity,
        ));

        return $this->render($this->entity['templates']['new'], array(
            'form' => $newForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
        ));
    }
}
