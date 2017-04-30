<?php

namespace meh\batiInterimBundle\Controller\EntrepreneurChefChantierController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Chantier;
use meh\batiInterimBundle\Entity\Mission;

class ChantierController extends Controller
{
    public function pageNewChantierAction()
    {
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        if( $request->getSession()->get('profil') == 'entrepreneur'){
            
            $lesChefChantiers = $this->getLesChefChantier();
            
            $form = $this->createFormBuilder()
            ->add('nomChantier', 'text', array( 'label' => "Nom du chantier", 'attr' => array( 'class' => 'form-control')))
            ->add('chefChantier', 'choice', array('empty_value' => '-- Choisissez le chef de chantier --', 'choices' => $lesChefChantiers, 'label' => "Chef de chantier", 'attr' => array('class' => 'form-control') ))
            ->add('creer', 'submit', array( 'label' => "Creer le chantier", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
            $form->handleRequest($request);
            
            if($form->isValid()){
                
                $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
                $chefChantier = $repository_chefChantier->find($form['chefChantier']->getData());
                
                $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
                $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
                
                $chantier = new Chantier();
                $chantier->setNom($form['nomChantier']->getData());
                $chantier->setIdchefchantier($chefChantier);
                $chantier->setIdentrepreneur($entrepreneur);
                
                $em->persist($chantier);
                $em->flush();
                
                return $this->redirectToRoute('page_gestion_chantier');                
            }
        }
        else if($request->getSession()->get('profil') == 'chef de chantier'){
            
            $form = $this->createFormBuilder()
            ->add('nomChantier', 'text', array( 'label' => "Nom du chantier", 'attr' => array( 'class' => 'form-control')))
            ->add('creer', 'submit', array( 'label' => "Creer le chantier", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
            $form->handleRequest($request);
            
            if($form->isValid()){
                
                $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
                $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
                
                $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
                $entrepreneur = $repository_entrepreneur->find($chefChantier->getIdentrepreneur());
                
                $chantier = new Chantier();
                $chantier->setNom($form['nomChantier']->getData());
                $chantier->setIdchefchantier($chefChantier);
                $chantier->setIdentrepreneur($entrepreneur);
                
                $em->persist($chantier);
                $em->flush();
                
                return $this->redirectToRoute('page_gestion_chantier');                
            }
        }
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueNewChantier.html.twig', array('form' => $form->createView()));

    }
    
    public function getLesChefChantier(){
        
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
        $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
        
        $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
        $chefChantiers = $repository_chefChantier->findBy(array('identrepreneur' => $entrepreneur));
        
        $lesChefChantier = array();
        foreach ($chefChantiers as $unChefChantier){
            $lesChefChantier[$unChefChantier->getIdchefchantier()] = $unChefChantier->getNom()." ".$unChefChantier->getPrenom();
        }
        return $lesChefChantier;
    }
    
    
    public function pageNewMissionAction() {
        
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $succes = "";
        
        if( $request->getSession()->get('profil') == 'entrepreneur'){
            
            $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
            $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
            
            $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
            $chantiers = $repository_chantier->findBy(array('identrepreneur' => $entrepreneur));
            
            $lesChantiers = $this->getLesChantiers($chantiers);
        }
        else if($request->getSession()->get('profil') == 'chef de chantier'){
            
            $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
            $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
            
            $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
            $chantiers = $repository_chantier->findBy(array('idchefchantier' => $chefChantier));
            
            $lesChantiers = $this->getLesChantiers($chantiers);
            
        }
        $lesCorpsMetiers = $this->getLesCorpsMetiers();
            
        $form = $this->createFormBuilder()
            ->add('dateDebut', 'date', array('empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2017, 2020), 'format' => 'd/M/y', 'label' => "Date de début", 'attr' => array( 'class' => 'form-control')))
            ->add('dateFin', 'date', array('empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2017, 2020), 'format' => 'd/M/y', 'label' => "Date de fin", 'attr' => array( 'class' => 'form-control')))
            ->add('intitule', 'text', array( 'label' => "Intitulé de la mission", 'attr' => array( 'class' => 'form-control')))
            ->add('nbArtisan', 'text', array('label' => "Nombre d'artisan", 'attr' => array( 'class' => 'form-control', 'pattern' => '[0-9]+', 'title' => 'Nombre entier positif')))
            ->add('prixJour', 'text', array('label' => "Prix par jour", 'attr' => array( 'class' => 'form-control', 'pattern'=>'[0-9]+(\.[0-9][0-9]?)?', 'title' => 'Nombre positif avec décimal séparé par un point')))    
            ->add('chantier', 'choice', array('empty_value' => '-- Choisissez le chantier --', 'choices' => $lesChantiers, 'label' => "Chantier", 'attr' => array('class' => 'form-control') ))
            ->add('corpsMetier', 'choice', array('empty_value' => '-- Choisissez le corps métier --', 'choices' => $lesCorpsMetiers, 'label' => "Corps métier", 'attr' => array('class' => 'form-control') ))
            ->add('creer', 'submit', array( 'label' => "Creer la mission", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
            $chantier = $repository_chantier->find($form['chantier']->getData());
            
            $repository_corpsMetier = $em->getRepository('mehbatiInterimBundle:Corpsmetier');
            $corpsmetier = $repository_corpsMetier->find($form['corpsMetier']->getData());
            
            $mission = new Mission();
            $mission->setDatedebut($form['dateDebut']->getData());
            $mission->setDatefin($form['dateFin']->getData());
            $mission->setIntitule($form['intitule']->getData());
            $mission->setNbartisans($form['nbArtisan']->getData());
            $mission->setPrixparjour($form['prixJour']->getData());
            $mission->setIdchantier($chantier);
            $mission->addIdcorpmetier($corpsmetier);
            
            $em->persist($mission);
            $em->flush();
            
            $succes = "La mission a bien été crée pour le chantier selectionné.";
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueNewMission.html.twig', array('succes' => $succes, 'form' => $form->createView()));
        }
        
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueNewMission.html.twig', array('succes' => $succes, 'form' => $form->createView()));
        
    }
    
    public function getLesChantiers($chantiers){
        $lesChantiers = array();
        foreach ($chantiers as $unChantier){
            $lesChantiers[$unChantier->getIdchantier()] = $unChantier->getNom();
        }
        return $lesChantiers;
    }
    
    public function getLesCorpsMetiers(){
        $em = $this->getDoctrine()->getManager();
        $repository_corpsMetier = $em->getRepository('mehbatiInterimBundle:Corpsmetier');
        $corpsmetiers = $repository_corpsMetier->findAll();
        $lesCorpsMetiers = array();
        foreach ($corpsmetiers as $unCorpsMetier){
            $lesCorpsMetiers[$unCorpsMetier->getIdcorpmetier()] = $unCorpsMetier->getLibelle();
        }
        return $lesCorpsMetiers;
    }
    
    public function pageGestionChantierAction() {
        
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
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueGestionChantier.html.twig', array('chantiers' => $chantiers));
        
    }
    
    public function pageMissionDunChantierAction($id) {
     
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
       
        $repository_chantier = $em->getRepository('mehbatiInterimBundle:Chantier');
        $chantier = $repository_chantier->find($id);
       
        $repository_mission = $em->getRepository('mehbatiInterimBundle:Mission');
        $missions = $repository_mission->findBy(array('idchantier' => $chantier));
       
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueMissionDunChantier.html.twig', array('missions' => $missions));

    }
    
}
