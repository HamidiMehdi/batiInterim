<?php

namespace meh\batiInterimBundle\Controller\GestionnaireController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Artisan;

class CongesController extends Controller
{
    
     public function pageCongeAction(){
         
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
         
        $em = $this->getDoctrine()->getManager();
        $repository_conges = $em->getRepository('mehbatiInterimBundle:Conger');
        $conges = $repository_conges->findAll();
         
        return $this->render('mehbatiInterimBundle:Gestionnaire:VueConge.html.twig', array('conges' => $conges));
        
     }
     
     public function updateEtatCongeAction($id, $btn) {
         
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
         
        $em = $this->getDoctrine()->getManager();
        $repository_conges = $em->getRepository('mehbatiInterimBundle:Conger');
        $conges = $repository_conges->find($id);
         
        if($btn == 1){
            $conges->setValider("Valider");
             
        }
        if($btn == 2){
            $conges->setValider("Refuser");
        }
        $em->persist($conges);
        $em->flush();
         
        return $this->redirectToRoute('page_conges_gestionnaire');
         
     }
    
    
    
}
   

