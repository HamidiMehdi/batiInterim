<?php

namespace meh\batiInterimBundle\Controller\EntrepreneurChefChantierController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtisanController extends Controller
{
    public function pageArtisanParCorpsMetierAction()
    {
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $lesCorpsMetiers = $this->getLesCorpsMetiers();
        
        $lesArtisan = array();
        
        $form = $this->createFormBuilder()
            ->add('corpsMetier', 'choice', array('empty_value' => '-- Choisissez le corps métier --', 'choices' => $lesCorpsMetiers, 'label' => "Corps métier", 'attr' => array('class' => 'form-control') ))
            ->add('chercher', 'submit', array( 'label' => "Chercher", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            $repository_corpsMetier = $em->getRepository('mehbatiInterimBundle:Corpsmetier');
            $corpsmetier = $repository_corpsMetier->find($form['corpsMetier']->getData());
            
            $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
            $artisans = $repository_artisan->findAll();
            
            foreach ($artisans as $unArtisan){
                $sesCm = $unArtisan->getIdcorpmetier() ;
                foreach($sesCm as $unCm){
                    if($unCm == $corpsmetier){
                        array_push($lesArtisan, $unArtisan);
                    }
                }
            }
            
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueArtisanParCorpsMetier.html.twig', array('artisan' => $lesArtisan, 'form' => $form->createView()));
        }
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueArtisanParCorpsMetier.html.twig', array('artisan' => $lesArtisan, 'form' => $form->createView()));
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
    
    
    public function pageArtisanAbsPresentAction() {
        
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $lesCorpsMetiers = $this->getLesCorpsMetiers();
        
        $lesArtisanAbsent = array();
        
        $form = $this->createFormBuilder()
            ->add('dateSelectionee', 'date', array('empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2000, 2017), 'format' => 'd/M/y', 'label' => "Date de début", 'attr' => array( 'class' => 'form-control')))
            ->add('corpsMetier', 'choice', array('empty_value' => '-- Choisissez le corps métier --', 'choices' => $lesCorpsMetiers, 'label' => "Corps métier", 'attr' => array('class' => 'form-control') ))
            ->add('chercher', 'submit', array( 'label' => "Chercher", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            $repository_corpsMetier = $em->getRepository('mehbatiInterimBundle:Corpsmetier');
            $corpsmetier = $repository_corpsMetier->find($form['corpsMetier']->getData());
            
            $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
            $artisans = $repository_artisan->findAll();
            
            foreach ($artisans as $unArtisan){  // pour chaque artisan
                $sesCm = $unArtisan->getIdcorpmetier() ; // on recupére sa liste de corps metier
                foreach($sesCm as $unCm){ // pour chaque corps eetier de l'artisan
                    if($unCm == $corpsmetier){ // si le corps metier selectionnée est present
                        $repository_conger = $em->getRepository('mehbatiInterimBundle:Conger');
                        $conges = $repository_conger->findBy(array('idartisan' => $unArtisan)); // on recup tout les conges de l'artisan
                        foreach($conges as $unConge){ 
                            if($unConge->getDatedebut() <= $form['dateSelectionee']->getData() && $unConge->getDatefin() >= $form['dateSelectionee']->getData() && $unConge->getValider() != "Refuser"){
                                array_push($lesArtisanAbsent, $unArtisan);
                            }
                        }
                    }
                }
            }
            
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueArtisanAbsPresent.html.twig', array('artisanAbs' => $lesArtisanAbsent, 'form' => $form->createView()));
        }
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueArtisanAbsPresent.html.twig', array('artisanAbs' => $lesArtisanAbsent, 'form' => $form->createView()));
        
    }
    
    public function pageCongerDunArtisanAction() {
        
        $request = $this->get('request');
        
        $em = $this->getDoctrine()->getManager();
        
        $conges = null;
        
        $lesArtisan = $this->getLesArtisan();
        
        $form = $this->createFormBuilder()
            ->add('artisans', 'choice', array('empty_value' => '-- Choisissez un artisan --', 'choices' => $lesArtisan, 'label' => "Artisan", 'attr' => array('class' => 'form-control') ))
            ->add('chercher', 'submit', array( 'label' => "Chercher", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $form->handleRequest($request);
        
        if($form->isValid()){
            
            $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
            $artisan = $repository_artisan->find($form['artisans']->getData());
            
            $repository_conger = $em->getRepository('mehbatiInterimBundle:Conger');
            $conges = $repository_conger->findBy(array('idartisan' => $artisan));
            
            return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueCongeDunArtisan.html.twig', array('conges' => $conges, 'form' => $form->createView()));
            
        }
        
        return $this->render('mehbatiInterimBundle:Entrepreneur_ChefChantier:VueCongeDunArtisan.html.twig', array('conges' => $conges, 'form' => $form->createView()));
        
    }
    
    public function getLesArtisan(){
        $em = $this->getDoctrine()->getManager();
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisans = $repository_artisan->findAll();
        $lesArtisans = array();
        
        foreach ($artisans as $unArtisan){
            $lesArtisans[$unArtisan->getIdartisan()] = $unArtisan->getNom()." ".$unArtisan->getPrenom() ;
        }
        return $lesArtisans;
    }
}
