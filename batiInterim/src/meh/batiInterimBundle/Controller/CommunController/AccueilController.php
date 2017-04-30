<?php

namespace meh\batiInterimBundle\Controller\CommunController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Artisan;
use meh\batiInterimBundle\Entity\Corpsmetier;

class AccueilController extends Controller
{
    public function pageAccueilAction()
    {
        $request = $this->get('request');
        
        if($request->getSession()->get('menu') != 1){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($request->getSession()->get('profil') == 'artisan'){
            $em = $this->getDoctrine()->getManager();
            $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
            $artisan = $repository_artisan->find($request->getSession()->get('id'));
            
            if($artisan->getMdpchanger() == false){
                return $this->redirectToRoute('page_changer_mdp_permiere_connexion');
            }
        }
        else if($request->getSession()->get('profil') == 'entrepreneur'){
            $em = $this->getDoctrine()->getManager();
            $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
            $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
            
            if($entrepreneur->getMdpchanger() == false){
                return $this->redirectToRoute('page_changer_mdp_permiere_connexion');
            }
        }
        else if($request->getSession()->get('profil') == 'chef de chantier'){
            $em = $this->getDoctrine()->getManager();
            $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
            $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
            
            if($chefChantier->getMdpchanger() == false){
                return $this->redirectToRoute('page_changer_mdp_permiere_connexion');
            }
        }
        
        return $this->render('mehbatiInterimBundle:Commun:VueAccueil.html.twig');
    }
    
    public function pageModificationMdpPremierConnexionAction()
    {
        
        $form = $this->createFormBuilder()
            ->add('mdp1', 'password', array( 'label' => "Mot de passe", 'attr' => array( 'class' => 'form-control')))
            ->add('mdp2', 'password', array( 'label' => "Retapez le mot de passe", 'attr' => array( 'class' => 'form-control')))
            ->add('Valider', 'submit', array( 'label' => "Valider", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $request = $this->get('request');
        $form->handleRequest($request);
        
        if($request->getSession()->get('menu') != 1){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $erreur = "";
        
        if($form->isValid()){
            
            $mdp1 = $form['mdp1']->getData();
            $mdp2 = $form['mdp2']->getData();
            
            if($mdp1 == $mdp2){
                
                if($request->getSession()->get('profil') == 'artisan'){
                $em = $this->getDoctrine()->getManager();
                $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
                $artisan = $repository_artisan->find($request->getSession()->get('id'));
                
                $artisan->setMdp(md5($mdp1));
                $artisan->setMdpchanger(true);
                
                $em->persist($artisan);
                $em->flush();
                return $this->redirectToRoute('page_accueil');
                
                }
                else if($request->getSession()->get('profil') == 'entrepreneur'){
                    $em = $this->getDoctrine()->getManager();
                    $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
                    $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
                    
                    $entrepreneur->setMdp(md5($mdp1));
                    $entrepreneur->setMdpchanger(true);
                    
                    $em->persist($entrepreneur);
                    $em->flush();
                    return $this->redirectToRoute('page_accueil');

                }
                else if($request->getSession()->get('profil') == 'chef de chantier'){
                    $em = $this->getDoctrine()->getManager();
                    $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
                    $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
                    
                    $chefChantier->setMdp(md5($mdp1));
                    $chefChantier->setMdpchanger(true);
                    
                    $em->persist($chefChantier);
                    $em->flush();
                    return $this->redirectToRoute('page_accueil');

                }
                   
            }
            else{
                $erreur = "Les deux mots de passe ne sont pas identiques";
                return $this->render('mehbatiInterimBundle:Commun:VueChangerMdpPremierConnexion.html.twig',array('erreur' => $erreur, 'form' => $form->createView()));

            }
            
        }
        
        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdpPremierConnexion.html.twig',array('erreur' => $erreur, 'form' => $form->createView()));
    }
    
    public function pageChangerMdpAction() {
        
        $request = $this->get('request');
        
        if($request->getSession()->get('menu') != 1){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder()
            ->add('mdpActuel', 'password', array( 'label' => "Mot de passe actuel", 'attr' => array( 'class' => 'form-control')))
            ->add('mdp1', 'password', array( 'label' => "Nouveau mot de passe", 'attr' => array( 'class' => 'form-control')))
            ->add('mdp2', 'password', array( 'label' => "Retapez votre nouveau mot de passe", 'attr' => array( 'class' => 'form-control')))
            ->add('Valider', 'submit', array( 'label' => "Modifier", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $form->handleRequest($request);
        
        $erreurMdpActuel = "";
        $erreurNewMdp = "";
        $succes = "";
        
        if($form->isValid()){
            
            if( $request->getSession()->get('profil') == 'gestionnaire'){
                $repository_gestionnaire = $em->getRepository('mehbatiInterimBundle:Gestionnaire');
                $gestionnaire = $repository_gestionnaire->find(1);
                if($gestionnaire->getMdp() == $form['mdpActuel']->getData()){
                    if($form['mdp1']->getData() == $form['mdp2']->getData()){
                        $gestionnaire->setMdp($form['mdp1']->getData());
                        $em->persist($gestionnaire);
                        $em->flush();
                        
                        $succes = "Le nouveau mot de passe a bien été enregistré.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                    else{
                        $erreurNewMdp = "Les deux nouveaux mot de passe ne sont pas identique.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                }
                else{
                    $erreurMdpActuel = "Votre mot de passe actuel est incorrect.";
                    return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                }
            }
            
            else if($request->getSession()->get('profil') == 'artisan'){
                $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
                $artisan = $repository_artisan->find($request->getSession()->get('id'));
                if($artisan->getMdp() == md5($form['mdpActuel']->getData())){
                    if($form['mdp1']->getData() == $form['mdp2']->getData()){
                        $artisan->setMdp(md5($form['mdp1']->getData()));
                        $em->persist($artisan);
                        $em->flush();
                        
                        $succes = "Le nouveau mot de passe a bien été enregistré.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                    else{
                        $erreurNewMdp = "Les deux nouveaux mot de passe ne sont pas identique.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                }
                else{
                    $erreurMdpActuel = "Votre mot de passe actuel est incorrect.";
                    return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                }
            }
            
            else if($request->getSession()->get('profil') == 'entrepreneur'){
                $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
                $entrepreneur = $repository_entrepreneur->find($request->getSession()->get('id'));
                if($entrepreneur->getMdp() == md5($form['mdpActuel']->getData())){
                    if($form['mdp1']->getData() == $form['mdp2']->getData()){
                        $entrepreneur->setMdp(md5($form['mdp1']->getData()));
                        $em->persist($entrepreneur);
                        $em->flush();
                        
                        $succes = "Le nouveau mot de passe a bien été enregistré.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                    else{
                        $erreurNewMdp = "Les deux nouveaux mot de passe ne sont pas identique.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                }
                else{
                    $erreurMdpActuel = "Votre mot de passe actuel est incorrect.";
                    return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                }
            }
            
            else if($request->getSession()->get('profil') == 'chef de chantier'){
                $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
                $chefChantier = $repository_chefChantier->find($request->getSession()->get('id'));
                if($chefChantier->getMdp() == md5($form['mdpActuel']->getData())){
                    if($form['mdp1']->getData() == $form['mdp2']->getData()){
                        $chefChantier->setMdp(md5($form['mdp1']->getData()));
                        $em->persist($chefChantier);
                        $em->flush();
                        
                        $succes = "Le nouveau mot de passe a bien été enregistré.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                    else{
                        $erreurNewMdp = "Les deux nouveaux mot de passe ne sont pas identique.";
                        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                    }
                }
                else{
                    $erreurMdpActuel = "Votre mot de passe actuel est incorrect.";
                    return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
                }
            }
            
        }
        
        return $this->render('mehbatiInterimBundle:Commun:VueChangerMdp.html.twig', array('succes' => $succes,  'erreurNewMdp' => $erreurNewMdp, 'erreurMdpActuel' => $erreurMdpActuel, 'form' => $form->createView()));
    }
    
}