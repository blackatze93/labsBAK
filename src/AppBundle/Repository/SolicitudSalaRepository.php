<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SolicitudSalaRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SolicitudSalaRepository extends EntityRepository
{
    /**
     * @param array $criteria
     *
     * @return array
     */
    public function findRangoEvento(array $criteria)
    {
        $em = $this->getEntityManager()->getRepository('AppBundle:Evento');



        return $em
            ->createQueryBuilder('eventos')
            ->where(':horaInicio >= eventos.horaInicio AND :horaInicio < eventos.horaFin')
            ->orWhere(':horaFin > eventos.horaInicio AND :horaFin <= eventos.horaFin')
            ->andWhere('eventos.lugar = :lugar')
            ->andWhere('eventos.fecha = :fecha')
            ->setParameters($criteria)
            ->getQuery()->getResult()
            ;
    }
}
