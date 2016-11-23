<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProyectoCurricularRepository extends EntityRepository {
    public function findUsuarios($proyectoCurricular) {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT u FROM AppBundle:Usuario u
                                      WHERE u.proyectoCurricular = :proyectoCurricular');
        $consulta->setParameter('proyectoCurricular', $proyectoCurricular);

        return $consulta->getResult();

    }
}