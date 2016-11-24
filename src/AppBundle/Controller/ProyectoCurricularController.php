<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\ProyectoCurricular;
use Symfony\Component\HttpFoundation\Response;

class ProyectoCurricularController extends Controller {
    /**
     * @Route ("/proyecto/", name="proyecto_index")
     */
     public function indexAction() {
         //throw $this->createAccessDeniedException("Acceso denegado!");
         //return $this->redirect('https://google.com');
         $em = $this->getDoctrine()->getManager();
         $usuarios = $em->getRepository('AppBundle:ProyectoCurricular')->findUsuarios('sistemas');
         return new Response(implode('<br>', $usuarios));
     }
    

    public function createAction() {
        // CREAR PROYECTO
        // $proyecto = new ProyectoCurricular();
        
        // $proyecto->setCodigo('123');
        // $proyecto->setNombre('Sistemas');
        
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($proyecto);
        
        // try {
        //     $em->flush();
        //     return new Response("Creado");    
        // } catch(\Exception $e) {
        //     return new Response("No Creado");    
        // }
    }
    
    /**
     * @Route ("/proyecto/{id}", name="proyecto_read", requirements={"id": "\d+"})
     */
    public function readAction($id) {
        // CONSULTAR PROYECTO
        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository("AppBundle:ProyectoCurricular")->findOneById($id);

        if (!$proyecto){
            throw $this->CreateNotFoundException('No se encontró el proyecto curricular');
        }

        return $this->render('proyecto_curricular/read.html.twig', array('proyecto' => $proyecto));
    }
    
    
    
    public function updateAction() {
        // MODIFICAR PROYECTO
        // $em = $this->getDoctrine()->getManager();
        // $proyecto = $em->getRepository('AppBundle:ProyectoCurricular')->findOneBy(array('codigo' => '123'));
        // $proyecto->setNombre("Electronica");
        // $em->persist($proyecto);
        
        // try {
        //     $em->flush();
        //     return new Response("Modificado");    
        // } catch(\Exception $e) {
        //     return new Response("No Modificado");    
        // }
    }
    
    public function deleteAction() {
        // ELIMINAR PROYECTO
        // $em = $this->getDoctrine()->getManager();
        // $proyecto = $em->getRepository('AppBundle:ProyectoCurricular')->findOneByCodigo('123');
        // if ($proyecto != null) {
        //     $em->remove($proyecto);
        
        //     try {
        //         $em->flush();
        //         return new Response("Eliminado");    
        //     } catch(\Exception $e) {
        //         return new Response("No Eliminado");    
        //     }
        // } else {
        //     return new Response("No Existe");    
        // }
    }

}
 