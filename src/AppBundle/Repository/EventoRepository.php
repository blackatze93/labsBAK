<?php
namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;
/**
 * ClaseRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventoRepository extends EntityRepository
{
    public function finAllTipos()
    {
        return $this
            ->createQueryBuilder('eventos')
            ->distinct('tipo')
            ->getQuery()->getResult();
    }
}