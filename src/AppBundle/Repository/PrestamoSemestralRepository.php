<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PrestamoSemestralRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PrestamoSemestralRepository extends EntityRepository
{
    //    /**
//     * @param array $criteria
//     *
//     * @return array
//     */
//    public function findRangoPrestamoSemestral(array $criteria)
//    {
//        return $this
//            ->createQueryBuilder('horarios')
//            ->where(':horaInicio >= horarios.horaInicio AND :horaInicio < horarios.horaFin')
//            ->orWhere(':horaFin > horarios.horaInicio AND :horaFin <= horarios.horaFin')
//            ->andWhere('horarios.lugar = :lugar')
//            ->andWhere('horarios.fecha = :fecha')
//            ->setParameters($criteria)
//            ->getQuery()->getResult()
//            ;
//    }
}
