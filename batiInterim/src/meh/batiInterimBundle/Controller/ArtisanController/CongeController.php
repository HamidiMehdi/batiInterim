<?php

namespace meh\batiInterimBundle\Controller\ArtisanController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meh\batiInterimBundle\Entity\Conger;

class CongeController extends Controller
{
    public function pageNouveauCongeAction()
    { 
        $form = $this->createFormBuilder()
            ->add('dateDebut', 'date', array('empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2000, 2020), 'format' => 'd/M/y', 'label' => "Date de début", 'attr' => array( 'class' => 'form-control')))
            ->add('dateFin', 'date', array('empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2000, 2020), 'format' => 'd/M/y', 'label' => "Date de fin", 'attr' => array( 'class' => 'form-control')))
            ->add('ajouter', 'submit', array( 'label' => "Ajouter un congé", 'attr' => array( 'class' => 'btn btn-lg btn-theme btn-block')))
            ->getForm() ;
        
        $request = $this->get('request');
        $form->handleRequest($request);
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($form->isValid()){
            
            $em = $this->getDoctrine()->getManager();
            
            $repository_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
            $artisan = $repository_artisan->find($request->getSession()->get('id'));
            
            $repository_gestionnaire = $em->getRepository('mehbatiInterimBundle:Gestionnaire');
            $gestionnaire = $repository_gestionnaire->find(1);
            
            $conge = new Conger();
            $conge->setDatedebut($form['dateDebut']->getData());
            $conge->setDatefin($form['dateFin']->getData());
            $conge->setIdartisan($artisan);
            $conge->getIdgestionnaire($gestionnaire);
            $conge->setValider('En attente');
            
            $em->persist($conge);
            $em->flush();
            
            return $this->redirectToRoute('page_gestion_conge');
           
        }
        
        return $this->render('mehbatiInterimBundle:Artisan:VueNouveauConge.html.twig', array('form' => $form->createView()));

    }
    
    
    public function pageGestionCongeAction(){
        
        $request = $this->get('request');
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        $em = $this->getDoctrine()->getManager();
        $reposiroty_artisan = $em->getRepository('mehbatiInterimBundle:Artisan');
        $repository_conges = $em->getRepository('mehbatiInterimBundle:Conger');
        
        $artisan = $reposiroty_artisan->find($request->getSession()->get('id'));
        $conges = $repository_conges->findBy(array('idartisan' => $artisan->getIdArtisan()));
        
        
        return $this->render('mehbatiInterimBundle:Artisan:VueGestionConge.html.twig', array('conges' => $conges));
    }
    
    public function deleteCongeAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $repository_conge = $em->getRepository('mehbatiInterimBundle:Conger');
        $leConge = $repository_conge->find($id);
        
        $em->remove($leConge);
        $em->flush();
        
        return $this->redirectToRoute('page_gestion_conge');
        
    }
    
    public function pageModifierCongeAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $repository_conges = $em->getRepository('mehbatiInterimBundle:Conger');
        $conges = $repository_conges->find($id);
        
        $formCongeDisabled = $this->createFormBuilder()
            ->add('date1', 'text', array('data' => date_format($conges->getDatedebut(), 'd/m/Y'), 'label' => "Date de debut",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->add('date2', 'text', array('data' => date_format($conges->getDatefin(), 'd/m/Y'), 'label' => "Date de fin",'disabled' => true, 'attr' => array( 'class' => 'form-control')))
            ->getForm() ;
        
        
        $formConge = $this->createFormBuilder()
            ->add('dateDebut', 'date', array('required' => false, 'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2000, 2017), 'format' => 'd/M/y', 'label' => "Date de début", 'attr' => array( 'class' => 'form-control')))
            ->add('dateFin', 'date', array('required' => false, 'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),'years' => range(2000, 2017), 'format' => 'd/M/y', 'label' => "Date de fin", 'attr' => array( 'class' => 'form-control')))
            ->add('maj', 'submit', array('label' => "Modifier", 'attr' => array( 'class' => 'btn btn-theme')))
            ->getForm() ;
        
        $request = $this->get('request');
        $formConge->handleRequest($request);
        
        if($request->getSession()->get('profil') != 'artisan'){
            return $this->redirectToRoute('page_de_connexion');
        }
        
        if($formConge->isValid()){
            
            if($formConge['dateDebut']->getData() != null){
                $conges->setDatedebut($formConge['dateDebut']->getData());
            }
            if($formConge['dateFin']->getData() != null){
                $conges->setDatefin($formConge['dateFin']->getData());
            }
            
            $em->persist($conges);
            $em->flush();
            
            return $this->redirectToRoute('page_gestion_conge');
            
        }
        
        return $this->render('mehbatiInterimBundle:Artisan:VueMajConge.html.twig', array('congeDisabled' => $formCongeDisabled->createView(), 'conge' => $formConge->createView()));
        
    }
}
