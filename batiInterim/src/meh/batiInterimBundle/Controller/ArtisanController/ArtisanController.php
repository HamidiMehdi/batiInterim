<?php

namespace meh\batiInterimBundle\Controller\ArtisanController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Artisan;

class ArtisanController extends Controller
{
    public function pageMajCoordonneesArtisanAction(){
        
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $artisan = $repository_artisan->findOneBy(array('idartisan' => $request->getSession()->get('id')));
        
        $libelleCorpsMetier = $this->getLibelleCorpsMetier($artisan);
        
        $formMajArtisanDisabled = $this->createFormBuilder()
            ->add('nom', 'text', array('data' => $artisan->getNom(), 'label' => "Nom",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array('data' => $artisan->getPrenom(), 'label' => "Prenom",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('dateNaissance', 'text', array('data' => date_format($artisan->getDatenaissance(), 'd/m/Y'), 'label' => "Date de naissance",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('lieuNaissance', 'text', array('data' => $artisan->getLieuNaissance(), 'label' => "Lieu de naissance",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('numTel', 'number', array('data' => $artisan->getNumTel(), 'label' => "Numero de telephone",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('adresse', 'text', array('data' => $artisan->getAdresse(), 'label' => "Adresse",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('cp', 'text', array('data' => $artisan->getCp(), 'label' => "Code postal",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('corpsMetier', 'text', array('data' => $libelleCorpsMetier, 'label' => "Le(s) metier(s)",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->getForm() ;
        
        $corpsMetiers = $this->getLesCorpsMetiers();
        
        $formMajArtisan = $this->createFormBuilder()
            ->add('nom', 'text', array('required' => false, 'label' => "Nom", 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array('required' => false, 'label' => "Prenom", 'attr' => array( 'class' => 'form-control')))
            ->add('dateNaissance', 'date', array('required' => false, 'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(1955, 2000), 'format' => 'd/M/y', 'label' => "Date de naissance", 'attr' => array( 'class' => 'form-control')))
            ->add('lieuNaissance', 'text', array('required' => false, 'label' => "Lieu de naissance", 'attr' => array( 'class' => 'form-control')))
            ->add('numTel', 'number', array('required' => false, 'label' => "Numero de telephone", 'attr' => array( 'class' => 'form-control')))
            ->add('adresse', 'text', array('required' => false, 'label' => "Adresse", 'attr' => array( 'class' => 'form-control')))
            ->add('cp', 'text', array('required' => false, 'label' => "Code postal", 'attr' => array( 'class' => 'form-control')))
            ->add('corspMetier', 'choice', array('required' => false, 'empty_value' => '-- Choisissez votre metier --', 'choices' => $corpsMetiers, 'label' => "Votre metier", 'attr' => array('class' => 'form-control') ))
            ->add('maj', 'submit', array('label' => "Mettre à jour", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $request = $this->get('request');
        $formMajArtisan->handleRequest($request);
        
        if($formMajArtisan->isValid()){
            
            if($formMajArtisan['nom']->getData() != null){
                $artisan->setNom($formMajArtisan['nom']->getData());
            }
            if($formMajArtisan['prenom']->getData() != null){
                $artisan->setPrenom($formMajArtisan['prenom']->getData());
            }
            if($formMajArtisan['dateNaissance']->getData() != null){
                $artisan->setDatenaissance($formMajArtisan['dateNaissance']->getData());
            }
            if($formMajArtisan['lieuNaissance']->getData() != null){
                $artisan->setLieunaissance($formMajArtisan['lieuNaissance']->getData());
            }
            if($formMajArtisan['numTel']->getData() != null){
                $artisan->setNumtel($formMajArtisan['numTel']->getData());
            }
            if($formMajArtisan['adresse']->getData() != null){
                $artisan->setAdresse($formMajArtisan['adresse']->getData());
            }
            if($formMajArtisan['cp']->getData() != null){
                $artisan->setCp($formMajArtisan['cp']->getData());
            }
            if($formMajArtisan['corspMetier']->getData() != null){
                foreach ($artisan->getIdcorpmetier() as $cm){
                    $artisan->removeIdcorpmetier($cm);
                }
                $artisan->addIdcorpmetier($em->getRepository('mehbatiInterimBundle:Corpsmetier')->find($formMajArtisan['corspMetier']->getData()));
            }
            
            $em->persist($artisan);
            $em->flush();
            
            return $this->redirectToRoute('page_maj_coordonnées_artisan');
        }
        
        return $this->render('mehbatiInterimBundle:Artisan:VueMajCoordonnee.html.twig', array('artisanDisabled' => $formMajArtisanDisabled->createView(), 'artisan' => $formMajArtisan->createView()));
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
    
    public function getLibelleCorpsMetier($artisan){
        $lesLibelles = "";
        foreach($artisan->getIdcorpmetier() as $corpMetier){
            $lesLibelles = $lesLibelles." ".$corpMetier->getLibelle();
        }
        return $lesLibelles;
    }
    
    
}
    
    
        