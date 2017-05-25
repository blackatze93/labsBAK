<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Elemento;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ElementoController.
 */
class ElementoController extends BaseAdminController
{
    /**
     * @Route("/elementos/", name="elementos")
     *
     * @return Response
     */
    public function elementosAction() {
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $sql = "SELECT * FROM elementoslaboratorio";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();


        var_dump($result[0]);

        $lugarRepository = $em->getRepository('AppBundle:Lugar');
        $equipoRepository = $em->getRepository('AppBundle:Equipo');

        $lugar = $lugarRepository->findOneBy(array(
            'nombre' => $result[0]['Ubicacion_EL']
        ));
        $equipo = $equipoRepository->findOneBy(array(
            'nombre' => $result[0]['RelacionEquipo_EL']
        ));

        $elemento = new Elemento();
        $elemento->setSerial($result[0]['Serial_EL']);
        $elemento->setPlaca($result[0]['Plaqueta_EL']);
        $elemento->setLugar($lugar);
        $elemento->setEquipo($equipo);
        // modelo
        $elemento->setMarca($result[0]['Marca_EL']);
        $elemento->setDescripcion($result[0]['Descripcion_EL']);
        // tipo
        // fechaingreso
        $elemento->setEstado($result[0]['Estado_EL']);
        $elemento->setObservaciones($result[0]['Observaciones_EL']);

        $elemento->setNombre($result[0]['']);

        $em->persist($elemento);
        $em->flush();
        var_dump($elemento);

        return new Response("correcto");
    }

    /**
     * @return JsonResponse
     */
    protected function autocompleteAction()
    {
        $referer = $this->request->headers->get('referer');
        $isPrestamo = strpos($referer, 'PrestamoElemento');
        $dqlFilter = null;

        if ($isPrestamo) {
            $dqlFilter = 'entity.activo = true and entity.prestado = false and entity.tipoPrestamo != \'Nadie\'';
        } else {
            $dqlFilter = 'entity.activo = true and entity.prestado = false';
        }

        $results = $this->get('easyadmin.autocomplete')->find(
            $this->request->query->get('entity'),
            $this->request->query->get('query'),
            $this->request->query->get('page', 1),
            $dqlFilter
        );

        return new JsonResponse($results);
    }

    /**
     * Metodo que lista los objetos encontrados en el sitio web.
     *
     * @Route("/elementos_prestamo/", name="elementos_prestamo")
     */
    public function objetosEncontradosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $elementos = $em->getRepository('AppBundle:Elemento')->findBy(
            array(
                'activo' => true,
                'prestado' => false,
                'tipoPrestamo' => 'Todos',
            ),
            array('nombre' => 'ASC')
        );

        return $this->render('elementos_prestamo.html.twig', array(
            'elementos' => $elementos,
        ));
    }
}
