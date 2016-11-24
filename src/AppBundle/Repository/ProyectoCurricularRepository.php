<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProyectoCurricularRepository extends EntityRepository {
    public function findUsuarios($proyectoCurricular) {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('SELECT u, pC FROM AppBundle:Usuario u
                                      JOIN u.proyectoCurricular pC 
                                      WHERE pC.nombre LIKE :proyectoCurricular');
        $consulta->setParameter('proyectoCurricular', $proyectoCurricular);

        return $consulta->getResult();

    }
}