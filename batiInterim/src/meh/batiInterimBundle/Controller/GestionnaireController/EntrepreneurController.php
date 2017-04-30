<?php

namespace meh\batiInterimBundle\Controller\GestionnaireController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Entrepreneur;
use meh\batiInterimBundle\Entity\Chefchantier;

class EntrepreneurController extends Controller
{
    public function pageNewEntrepreneurAction()
    {
        $secteur = $this->getLesSecteurs();
        
        $formNewEntrepreneur = $this->createFormBuilder()
            ->add('nom', 'text', array('label' => "Nom", 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array( 'label' => "Prenom", 'attr' => array( 'class' => 'form-control')))
            ->add('nomSociete', 'text', array( 'label' => "Nom de votre société", 'attr' => array( 'class' => 'form-control')))
            ->add('numTel', 'number', array( 'label' => "Numero de telephone", 'attr' => array( 'class' => 'form-control')))
            ->add('adresse', 'text', array( 'label' => "Adresse", 'attr' => array( 'class' => 'form-control')))
            ->add('cp', 'text', array( 'label' => "Code postal", 'attr' => array( 'class' => 'form-control')))
            ->add('secteur', 'choice', array('choices' => $secteur, 'label' => "Votre secteur", 'attr' => array('class' => 'form-control') ))
            ->add('ajouter', 'submit', array( 'label' => "Ajouter le(s) chef(s) de chantier", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $request = $this->get('request');
        $formNewEntrepreneur->handleRequest($request);
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($formNewEntrepreneur->isValid()){
            
            $em = $this->getDoctrine()->getManager();
            
            $nom = $formNewEntrepreneur['nom']->getData() ;
            $prenom = $formNewEntrepreneur['prenom']->getData() ;
            $nomSociete = $formNewEntrepreneur['nomSociete']->getData() ;
            $numTel = $formNewEntrepreneur['numTel']->getData() ;
            $adresse = $formNewEntrepreneur['adresse']->getData() ;
            $cp = $formNewEntrepreneur['cp']->getData() ;
            
            $premierLettrePrenom = substr($prenom, 0, 1);
            $login ;
            if(strlen($nom) >= 9){
                $nomLogin = substr($nom, 0, 9);
                $login = $premierLettrePrenom.$nomLogin ;
            }
            else{
                $login = $premierLettrePrenom.$nom ;
            }
            
            $secteurRattacher = $this->getDoctrine()->getManager()->getRepository('mehbatiInterimBundle:Secteur')->find($formNewEntrepreneur['secteur']->getData());
            
            $entrepreneur = new Entrepreneur();
            $entrepreneur->setNomchef($nom);
            $entrepreneur->setPrenomchef($prenom);
            $entrepreneur->setNomsociete($nomSociete);
            $entrepreneur->setNumtel($numTel);
            $entrepreneur->setAdresse($adresse);
            $entrepreneur->setCp($cp);
            $entrepreneur->setLogin(strtolower($login));
            $entrepreneur->setMdp(md5(strtolower($login)));
            $entrepreneur->setMdpchanger(false);
            $entrepreneur->addIdsecteur($secteurRattacher);
            
            $secteurRattacher->addIdentrepreneur($entrepreneur);
            
            $em->persist($entrepreneur);
            $em->persist($secteurRattacher);
            $em->flush();
            
            return $this->redirectToRoute('page_inserer_chef_chantier', array('nomSociete' => $nomSociete));

            
        }
        return $this->render('mehbatiInterimBundle:Gestionnaire:VueNewEntrepreneur.html.twig', array('form' => $formNewEntrepreneur->createView()));

    }
    
    public function getLesSecteurs(){
        $em = $this->getDoctrine()->getManager();
        $repository_secteur = $em->getRepository('mehbatiInterimBundle:Secteur');
        $lesSecteurs = $repository_secteur->findAll();
        $secteurs = array();
        foreach ($lesSecteurs as $unSecteur){
            $secteurs[$unSecteur->getIdsecteur()] = $unSecteur->getLibelle();
        }
        return $secteurs;
    }
    
    public function pageSelectChefChantierAction($nomSociete){
        
        $formNewChefChantier = $this->createFormBuilder()
            ->add('nom', 'text', array('label' => "Le nom du chef de chantier", 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array('label' => "Le prenom du chef de chantier", 'attr' => array( 'class' => 'form-control')))
            ->add('ajouter', 'submit', array( 'label' => "Ajouter le chef de chantier pour ".$nomSociete , 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $request = $this->get('request');
        $formNewChefChantier->handleRequest($request);
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($formNewChefChantier->isValid()){
            
            $nom = $formNewChefChantier['nom']->getData() ;
            $prenom = $formNewChefChantier['prenom']->getData() ;
            
            $premierLettrePrenom = substr($prenom, 0, 1);
            $login ;
            if(strlen($nom) >= 9){
                $nomLogin = substr($nom, 0, 9);
                $login = $premierLettrePrenom.$nomLogin ;
            }
            else{
                $login = $premierLettrePrenom.$nom ;
            }
            
            $em = $this->getDoctrine()->getManager();
            $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
            $entrepreneur = $repository_entrepreneur->findOneBy(array('nomsociete' => $nomSociete));
            
            $chefChantier = new Chefchantier();
            $chefChantier->setNom($nom);
            $chefChantier->setPrenom($prenom);
            $chefChantier->setLogin(strtolower($login));
            $chefChantier->setMdp(md5(strtolower(($login))));
            $chefChantier->setMdpchanger(false);
            $chefChantier->setIdentrepreneur($entrepreneur);
            
            $em->persist($chefChantier);
            $em->flush();
            
            return $this->redirectToRoute('page_inserer_chef_chantier', array('nomSociete' => $nomSociete));
        }
        
        return $this->render('mehbatiInterimBundle:Gestionnaire:VueInsererChefChantier.html.twig', array('nomSociete' => $nomSociete, 'form' => $formNewChefChantier->createView()));
    }
    
    
    public function pageGestionEntrepreneurAction() {
        
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
        $entrepreneurs = $repository_entrepreneur->findAll();
        
        return $this->render('mehbatiInterimBundle:Gestionnaire:VueGestionEntrepreneur.html.twig', array('entrepreneurs' => $entrepreneurs));

    }
    
    
    public function deleteEntrepreneurAction($id) {
        
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
        $entrepreneur = $repository_entrepreneur->findOneBy(array('identrepreneur' => $id));
        
        $repository_chefChantier = $em->getRepository('mehbatiInterimBundle:Chefchantier');
        $chefsChantier = $repository_chefChantier->findAll();
        
        foreach($chefsChantier as $unChef){
            if($unChef->getIdentrepreneur() == $entrepreneur){
                $em->remove($unChef);
            }
        }
        $em->remove($entrepreneur);
        $em->flush();
        
        return $this->redirectToRoute('page_gestion_entrepreneur');
        
    }
    
    public function pageMajEntrepreneurAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $repository_entrepreneur = $em->getRepository('mehbatiInterimBundle:Entrepreneur');
        $entrepreneur = $repository_entrepreneur->findOneBy(array('identrepreneur' => $id));
        
        $secteurActuel = $this->getLesLibellesSecteurs($entrepreneur);
        
        $formMajEntrepreneurDisabled = $this->createFormBuilder()
            ->add('nom', 'text', array('data' => $entrepreneur->getNomChef(), 'disabled' => true, 'label' => "Nom", 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array('data' => $entrepreneur->getPrenomChef(), 'disabled' => true, 'label' => "Prenom", 'attr' => array( 'class' => 'form-control')))
            ->add('nomSociete', 'text', array('data' => $entrepreneur->getNomSociete(), 'disabled' => true, 'label' => "Nom de votre société", 'attr' => array( 'class' => 'form-control')))
            ->add('numTel', 'number', array('data' => $entrepreneur->getNumTel(), 'disabled' => true, 'label' => "Numero de telephone", 'attr' => array( 'class' => 'form-control')))
            ->add('adresse', 'text', array('data' => $entrepreneur->getAdresse(), 'disabled' => true, 'label' => "Adresse", 'attr' => array( 'class' => 'form-control')))
            ->add('cp', 'text', array('data' => $entrepreneur->getCp(), 'disabled' => true, 'label' => "Code postal", 'attr' => array( 'class' => 'form-control')))
            ->add('secteur', 'text', array('data' => $secteurActuel, 'label' => "Secteur",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->getForm() ;
        
        $lesSecteurs = $this->getLesSecteurs();
        
        $formMajEntrepreneur = $this->createFormBuilder()
            ->add('nom', 'text', array('required' => false, 'label' => "Nom", 'attr' => array( 'class' => 'form-control')))
            ->add('prenom', 'text', array('required' => false, 'label' => "Prenom", 'attr' => array( 'class' => 'form-control')))
            ->add('nomSociete', 'text', array('required' => false, 'label' => "Nom de votre société", 'attr' => array( 'class' => 'form-control')))
            ->add('numTel', 'number', array('required' => false, 'label' => "Numero de telephone", 'attr' => array( 'class' => 'form-control')))
            ->add('adresse', 'text', array('required' => false, 'label' => "Adresse", 'attr' => array( 'class' => 'form-control')))
            ->add('cp', 'text', array('required' => false, 'label' => "Code postal", 'attr' => array( 'class' => 'form-control')))
            ->add('secteurs', 'choice', array('required' => false, 'empty_value' => '-- Choisissez votre secteur --', 'choices' => $lesSecteurs, 'label' => "Votre secteur", 'attr' => array('class' => 'form-control') ))
            ->add('maj', 'submit', array( 'label' => "Mettre à jour", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $request = $this->get('request');
        $formMajEntrepreneur->handleRequest($request);
        
        if($request->getSession()->get('profil') != 'gestionnaire'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($formMajEntrepreneur->isValid()){
            
            if($formMajEntrepreneur['nom']->getData() != null){
                $entrepreneur->setNomchef($formMajEntrepreneur['nom']->getData());
            }
            if($formMajEntrepreneur['prenom']->getData() != null){
                $entrepreneur->setPrenomchef($formMajEntrepreneur['prenom']->getData());
            }
            if($formMajEntrepreneur['nomSociete']->getData() != null){
                $entrepreneur->setNomsociete($formMajEntrepreneur['nomSociete']->getData());
            }
            if($formMajEntrepreneur['numTel']->getData() != null){
                $entrepreneur->setNumtel($formMajEntrepreneur['numTel']->getData());
            }
            if($formMajEntrepreneur['adresse']->getData() != null){
                $entrepreneur->setAdresse($formMajEntrepreneur['adresse']->getData());
            }
            if($formMajEntrepreneur['cp']->getData() != null){
                $entrepreneur->setCp($formMajEntrepreneur['cp']->getData());
            }
            if($formMajEntrepreneur['secteurs']->getData() != null){
                
                foreach ($entrepreneur->getIdsecteur() as $unSecteur){
                        $unSecteur->removeIdentrepreneur($entrepreneur);
                        $em->persist($unSecteur);
                }
                $nouveauSecteur = $em->getRepository('mehbatiInterimBundle:Secteur')->find($formMajEntrepreneur['secteurs']->getData());
                $nouveauSecteur->addIdentrepreneur($entrepreneur);
                $em->persist($nouveauSecteur);
            }
            
            $em->persist($entrepreneur);
            $em->flush();
            
            return $this->redirectToRoute('page_gestion_entrepreneur');
        }
        
        return $this->render('mehbatiInterimBundle:Gestionnaire:VueMajEntrepreneur.html.twig', array('entrepreneurDisabled' => $formMajEntrepreneurDisabled->createView(), 'entrepreneur' => $formMajEntrepreneur->createView()));
    }
    
    public function getLesLibellesSecteurs($entrepreneur){
        
        $lesLibelles = "";
        foreach($entrepreneur->getIdsecteur() as $unSecteur){
            $lesLibelles = $lesLibelles." ".$unSecteur->getLibelle();
        }
        return $lesLibelles;
    }
    
}