<?php

namespace meh\batiInterimBundle\Controller\EntrepreneurChefChantierController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Effectuer;

class AffecterController extends Controller
{
    public function pageAffecterMissionChantierAction()
    {
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        if( $request->getSession()->get('profil') == 'entrepreneur'){
            
            $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
            $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
            
            $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
            $chantiers = $repository_chantier->findBy(array('identrepreneur' => $entrepreneur));
            
        }
        else if($request->getSession()->get('profil') == 'chef de chantier'){
            
            $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
            $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
            
            $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
            $chantiers = $repository_chantier->findBy(array('idchefchantier' => $chefChantier));
            
        }
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueAffecterMissionChantier.html.twig', array('chantiers' => $chantiers));
        
    }
    
    
    public function pageAffecterArtisanMissionAction($id)
    {
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
        $chantier = $repository_chantier->find($id);
        
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $missions = $repository_mission->findBy(array('idchantier' => $chantier));
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueAffecterMission.html.twig', array('missions' => $missions));
        
    }
    
    
    public function pageSelectionArtisanAffectationAction($id)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        $lesArtisan = array();
        
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $mission = $repository_mission->find($id);
        
        foreach($mission->getIdcorpmetier() as $unCorp){
            $repository_corpsMetier = $em->getRepository('mehbatiInterimBundle:Corpsmetier');
            $corpsMetier = $repository_corpsMetier->find($unCorp);
        }
        
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisans = $repository_artisan->findAll();
        
        foreach ($artisans as $unArtisan){
            $repository_conger = $em->getRepository('mehbatiInterimBundle:Conger');
            $conges = $repository_conger->findBy(array('idartisan' => $unArtisan));
            $etreConge = false ;
            foreach($conges as $unConge){
                if($unConge->getDatedebut() >= $mission->getDatedebut() && $unConge->getDatedebut() <= $mission->getDatefin() && $unConge->getValider() != 'Refuser'){
                    $etreConge = TRUE ;
                }
                if($unConge->getDatefin() >= $mission->getDatedebut() && $unConge->getDatefin() <= $mission->getDatefin() && $unConge->getValider() != 'Refuser'){
                    $etreConge = TRUE ;
                }
            }
            $repository_Effectuer = $em->getRepository('mehbatiInterimBundle:Effectuer');
            $effectuers = $repository_Effectuer->findAll();
            $dejaEffectuer = false ;
            foreach($effectuers as $unEffectuer){
                if($unEffectuer->getIdartisan() == $unArtisan && $unEffectuer->getIdmission() == $mission){
                    $dejaEffectuer = true;
                }
            }
            
            if($etreConge == false && $dejaEffectuer == false){
                $sesCm = $unArtisan->getIdcorpmetier() ;
                foreach($sesCm as $unCm){
                    if($unCm == $corpsMetier){
                        array_push($lesArtisan, $unArtisan);
                    }
                }
            }
            
        }
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueAffecterArtisan.html.twig', array('artisans' => $lesArtisan, 'mission' => $mission));

    }
    
    public function selectionArtisanAction($idMission, $idArtisan)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $mission = $repository_mission->find($idMission);
        
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisan = $repository_artisan->find($idArtisan);
        
        $repository_etat = $em->getRepository('mehbatiInterimBundle:Etat');
        $etat = $repository_etat->find(1);
        
        $effectuer = new Effectuer();
        $effectuer->setIdmission($mission);
        $effectuer->setIdetat($etat);
        $effectuer->setIdartisan($artisan);
            
        $em->persist($effectuer);
        $em->flush();
        
        return $this->redirectToRoute('page_affecter_artisan', array('id' => $mission->getIdmission()));
    
    }
    
    public function pageGestionAffecterAction()
    {
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $repository_Effectuer = $em->getRepository('mehbatiInterimBundle:Effectuer');
        $effectuers = $repository_Effectuer->findAll();
        
        $lesArtisanAffecter = array();
        
        if( $request->getSession()->get('profil') == 'entrepreneur'){
            
            $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
            $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
            
            foreach($effectuers as $unEffectuer){
                if($unEffectuer->getIdmission()->getIdchantier()->getIdentrepreneur() == $entrepreneur){
                    array_push($lesArtisanAffecter, $unEffectuer);
                }
            }
            
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueGestionAffecter.html.twig', array('lesAffecter' => $lesArtisanAffecter));
            
        }
        else if($request->getSession()->get('profil') == 'chef de chantier'){
            
            $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
            $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
            
            foreach($effectuers as $unEffectuer){
                if($unEffectuer->getIdmission()->getIdchantier()->getIdchefchantier() == $chefChantier){
                    array_push($lesArtisanAffecter, $unEffectuer);
                }
            }
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueGestionAffecter.html.twig', array('lesAffecter' => $lesArtisanAffecter));
            
        }
    }
    
    public function deleteUneAffectationAction($idMission, $idArtisan)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();
        
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $mission = $repository_mission->find($idMission);
        
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisan = $repository_artisan->find($idArtisan);
        
        $repository_Effectuer = $em->getRepository('mehbatiInterimBundle:Effectuer');
        $effectuers = $repository_Effectuer->findBy(array('idartisan' => $artisan, 'idmission' => $mission));
        
        foreach($effectuers as $unEffectuer){
            $em->remove($unEffectuer);
        }
        $em->flush();
        
        return $this->redirectToRoute('page_gestion_affecter');
    }
    
    
}
    
