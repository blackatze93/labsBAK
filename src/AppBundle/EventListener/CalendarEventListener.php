<?php

namespace AppBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class CalendarEventListener.
 */
class CalendarEventListener
{
    private $entityManager;
    private $router;

    /**
     * CalendarEventListener constructor.
     *
     * @param EntityManager $entityManager
     * @param Router        $router
     */
    public function __construct(EntityManager $entityManager, Router $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @param CalendarEvent $calendarEvent
     */
    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // The original request so you can get filters from the calendar
        // Use the filter in your query for example

//        $request = $calendarEvent->getRequest();
//        $filter = $request->get('filter');

        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $clases = $this->entityManager->getRepository('AppBundle:Clase')
            ->createQueryBuilder('clases')
            ->where('clases.fecha BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d'))
            ->setParameter('endDate', $endDate->format('Y-m-d'))
            ->getQuery()->getResult();

        // $clases and $clase in this example
        // represent entities from your database, NOT instances of EventEntity
        // within this bundle.
        //
        // Create EventEntity instances and populate it's properties with data
        // from your own entities/database values.

        foreach ($clases as $clase) {
            $fecha = $clase->getFecha();
            $horaInicio = $clase->getHoraInicio();
            $horaFin = $clase->getHoraFin();
            $fechaInicio = new \DateTime($fecha->format('Y-m-d').' '.$horaInicio->format('H:i'));
            $fechaFin = new \DateTime($fecha->format('Y-m-d').' '.$horaFin->format('H:i'));

            // create an event with a start/end time
            $eventEntity = new EventEntity($clase->getMateria(), $fechaInicio, $fechaFin);

            //optional calendar event settings
//            $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
//            $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
//            $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            // TODO: agregar condicion para mostrar solo url a los autenticados con permisos
            // TODO: formulario para clases multiples, con lunes de 6 a 8 ejemplo
            $eventEntity->setUrl($this->router->generate('clase_show', array('id' => $clase->getId()))); // url to send user to when event label is clicked
//            $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels
            $eventEntity->addField('resourceId', $clase->getLugar()->getId());

            $eventEntity->addField('estado', $clase->getEstado());

            $eventEntity->addField('grupo', $clase->getGrupo());

            $eventEntity->addField('observaciones', $clase->getObservaciones());

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }
}
