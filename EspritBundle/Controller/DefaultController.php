<?php

namespace EspritBundle\Controller;
use EspritBundle\Entity\jardin;
use EspritBundle\Entity\adresse;
use EspritBundle\Repository\jardinRepository;

use EspritBundle\Form\jardinType;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Esprit/Default/index.html.twig');
    }



    public function addAction(request $request)
    {
        $jardin = new jardin();
        $form = $this->createForm(jardinType::class, $jardin);
        $form = $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($jardin);
            $em->flush();
        }
        return $this->render("@Esprit/Default/add.html.twig",array('form' => $form->createView()));
    }


    //affichage des clubs depuis la base de donnéées
    public function listAction()
    {
        $jardin = $this->getDoctrine()->getRepository(jardin::class)->findAll();
        return $this->render("@Esprit/Default/list.html.twig" , array("jardin"=>$jardin));    }
        //ajout de club dans la base de données
    public function ajoutAction (Request  $request){



        $jardin = new jardin();
        $form = $this->createForm(jardinType::class, $jardin);
        $form = $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($jardin);
            $em->flush();
        }
        return $this->render("@Esprit/Default/list.html.twig",array('form' => $form->createView()));

    }
    //supprimer
    public function deleteAction ($id){
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository(jardin::class)->find($id);
        $em->remove($modele);
        $em->flush();
        return $this->redirectToRoute("list");
    }
    //modifier
    public function updateAction($id , Request $request){
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository(jardin::class)->find($id);
        $form = $this->createForm(jardinType::class, $modele);
        $form = $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render("@Esprit/Default/update.html.twig",array('form' => $form->createView()));
    }


}
