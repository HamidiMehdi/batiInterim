<?php

namespace meh\batiInterimBundle\Controller\CommunController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Artisan;
use meh\batiInterimBundle\Entity\Gestionnaire;
use meh\batiInterimBundle\Entity\Entrepreneur;

class ConnexionController extends Controller
{
    public function pageConnexionAction()
    {   
        $user = array( 1 => 'Artisan', 2 => 'Entrepreneur', 3 => 'Gestionnaire', 4 => 'Chef de chantier');
        
        $form = $this->createFormBuilder()
            ->add('login', 'text', array( 'label' => "Nom d'utilisateur", 'attr' => array( 'class' => 'form-control')))
            ->add('mdp', 'password', array( 'label' => "Mot de passe", 'attr' => array( 'class' => 'form-control')))
            ->add('profils', 'choice', array('empty_value' => '-- Choisissez votre profil --', 'choices' => $user, 'label' => "Votre profil", 'attr' => array('class' => 'form-control') ))
            ->add('Connexion', 'submit', array( 'label' => "Se connecter", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $request = $this->get('request');
        $form->handleRequest($request);
        
        $request->getSession()->clear(); // au cas ou il est connecté et il repart sur la page de connexion avec l'url
        
        $erreurConnexion = "";
        
        if($form->isValid()){
            
            $login = $form['login']->getData() ;
            $mdp = $form['mdp']->getData();
            $profil = $form['profils']->getData();
            
            $em = $this->getDoctrine()->getManager();
            
            $artisan = $em->getRepository('mehbatiInterimBundle:Artisan') ;
            $entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur') ;
            $gestionnaire = $em->getRepository('mehbatiInterimBundle:Gestionnaire') ;
            $chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier') ;
            
            if($profil == 1){
                $artisanExiste = $artisan->findOneBy(array('login' => $login, 'mdp' => md5($mdp))) ;
                if($artisanExiste != null){
                    $this->getRequest()->getSession()->set('id', $artisanExiste->getIdartisan());
                    $this->getRequest()->getSession()->set('nom', $artisanExiste->getNom());
                    $this->getRequest()->getSession()->set('prenom', $artisanExiste->getPrenom());
                    $this->getRequest()->getSession()->set('mdp', $artisanExiste->getMdp());
                    $this->getRequest()->getSession()->set('profil', 'artisan');
                    $this->getRequest()->getSession()->set('menu', 1);
                    return $this->redirectToRoute('page_accueil');
                }
                else{
                    $erreurConnexion = "Nom d'utilisateur et/ou mot de passe incorrect";
                    return $this->render('mehbatiInterimBundle:Commun:VueConnexion.html.twig', array('form' => $form->createView(), 'erreurConnexion' => $erreurConnexion));
                }
            }
            else if($profil == 2){
                $entrepreneurExiste = $entrepreneur->findOneBy(array('login' => $login, 'mdp' => md5($mdp))) ;
                if($entrepreneurExiste != null){
                    $this->getRequest()->getSession()->set('id', $entrepreneurExiste->getIdentrepreneur());
                    $this->getRequest()->getSession()->set('nom', $entrepreneurExiste->getNomchef());
                    $this->getRequest()->getSession()->set('prenom', $entrepreneurExiste->getPrenomchef());
                    $this->getRequest()->getSession()->set('mdp', $entrepreneurExiste->getMdp());
                    $this->getRequest()->getSession()->set('nomSociete', $entrepreneurExiste->getNomsociete());
                    $this->getRequest()->getSession()->set('profil', 'entrepreneur');
                    $this->getRequest()->getSession()->set('menu', 1);
                    return $this->redirectToRoute('page_accueil');
                }
                else{
                    $erreurConnexion = "Nom d'utilisateur et/ou mot de passe incorrect";
                    return $this->render('mehbatiInterimBundle:Commun:VueConnexion.html.twig', array('form' => $form->createView(), 'erreurConnexion' => $erreurConnexion));
                }
            }
            else if($profil == 3){
                $gestionnaireExist = $gestionnaire->findOneBy(array('login' => $login, 'mdp' => $mdp )) ;
                if($gestionnaireExist != null){
                    $this->getRequest()->getSession()->set('mdp', $gestionnaireExist->getMdp());
                    $this->getRequest()->getSession()->set('nom', $gestionnaireExist->getNom());
                    $this->getRequest()->getSession()->set('prenom', $gestionnaireExist->getPrenom());
                    $this->getRequest()->getSession()->set('profil', 'gestionnaire');
                    $this->getRequest()->getSession()->set('menu', 1);
                    return $this->redirectToRoute('page_accueil');
                }
                else{
                    $erreurConnexion = "Nom d'utilisateur et/ou mot de passe incorrect";
                    return $this->render('mehbatiInterimBundle:Commun:VueConnexion.html.twig', array('form' => $form->createView(), 'erreurConnexion' => $erreurConnexion));
                }
            }
            else{
                $chefChantierExiste = $chefChantier->findOneBy(array('login' => $login, 'mdp' => md5($mdp))) ;
                if($chefChantierExiste != null){
                    $this->getRequest()->getSession()->set('id', $chefChantierExiste->getIdchefchantier());
                    $this->getRequest()->getSession()->set('nom', $chefChantierExiste->getNom());
                    $this->getRequest()->getSession()->set('prenom', $chefChantierExiste->getPrenom());
                    $this->getRequest()->getSession()->set('mdp', $chefChantierExiste->getMdp());
                    $this->getRequest()->getSession()->set('entreprise', $chefChantierExiste->getIdentrepreneur()->getIdentrepreneur());
                    $this->getRequest()->getSession()->set('profil', 'chef de chantier');
                    $this->getRequest()->getSession()->set('menu', 1);
                    return $this->redirectToRoute('page_accueil');
                    
                }
                else{
                    $erreurConnexion = "Nom d'utilisateur et/ou mot de passe incorrect";
                    return $this->render('mehbatiInterimBundle:Commun:VueConnexion.html.twig', array('form' => $form->createView(), 'erreurConnexion' => $erreurConnexion));
                }
            }
            
        }
        
        return $this->render('mehbatiInterimBundle:Commun:VueConnexion.html.twig', array('form' => $form->createView(), 'erreurConnexion' => $erreurConnexion));
    }
    
    
    public function deconnexionAction(){
        $request = $this->get('request');
        $request->getSession()->clear();
        return $this->redirectToRoute('page_de_connexion');
    }
 
}
