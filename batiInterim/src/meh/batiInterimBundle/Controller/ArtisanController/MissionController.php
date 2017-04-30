<?php

namespace meh\batiInterimBundle\Controller\ArtisanController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MissionController extends Controller
{
    public function pageMissionAction()
    {
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisan = $repository_artisan->find($request->getSession()->get('id'));
        
        $repository_Effectuer = $em->getRepository('mehbatiInterimBundle:Effectuer');
        $effectuers = $repository_Effectuer->findBy(array('idartisan' => $artisan));
        
        return $this->render('mehbatiInterimBundle:Artisan:VueMission.html.twig', array('missions' => $effectuers));
    }
    
    
    public function updateEtatMissionAction($idMission, $btn) {
         
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisan = $repository_artisan->find($request->getSession()->get('id'));
        
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $mission = $repository_mission->find($idMission);
        
        $repository_Effectuer = $em->getRepository('mehbatiInterimBundle:Effectuer');
        $effectuers = $repository_Effectuer->findBy(array('idartisan' => $artisan, 'idmission' => $mission));
        
        if($btn == 1){ // btn accepter
            $repository_etat = $em->getRepository('mehbatiInterimBundle:Etat');
            $etatAccepter = $repository_etat->find(2);
            foreach($effectuers as $unEffectuer){
                $unEffectuer->setIdetat($etatAccepter);
                $em->persist($unEffectuer);
            }
        }
        if($btn == 2){  // btn refuser
            $repository_etat = $em->getRepository('mehbatiInterimBundle:Etat');
            $etatRefuser = $repository_etat->find(3);
            foreach($effectuers as $unEffectuer){
                $unEffectuer->setIdetat($etatRefuser);
                $em->persist($unEffectuer);
            }
        }
        $em->flush();
         
        return $this->redirectToRoute('page_mission_artisan');
         
     }
    
    
    
    
}
