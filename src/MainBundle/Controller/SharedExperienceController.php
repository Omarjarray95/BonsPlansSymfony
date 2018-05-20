<?php

namespace MainBundle\Controller;

use MainBundle\Entity\SharedExperience;
use MainBundle\Form\ReservationHotel;
use MainBundle\Form\SharedExperienceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SharedExperienceController extends Controller
{
    public function AjoutAction(Request $request, $id1, $id2)
    {
        $shExperience = new SharedExperience();
        $Form = $this->createForm(SharedExperienceType::class,$shExperience);
        $Form->handleRequest($request);
        if ($Form->isValid() && $Form->isSubmitted()){
            $em= $this->getDoctrine()->getManager();
            $etab=$em->getRepository("MainBundle:Etablissement")->find($id1);
            $user=$em->getRepository("MainBundle:User")->find($id2);
            $shExperience->setEtablissement($etab);
            $shExperience->setUser($user);
            $em->persist($shExperience);
            $em->flush();
            return $this->redirectToRoute('affiche_experience');
        }
        return $this->render('MainBundle:SharedExperience:ajout.html.twig', array('Form'=>$Form->createView()));
    }

    public function DeleteAction($id1, $id2)
    {
        $em=$this->getDoctrine()->getManager();
        $shExperience=$em->getRepository("MainBundle:SharedExperience")->find($id1);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id2);
        $em->remove($shExperience);
        $em->flush();
        return $this->redirectToRoute('affiche_experience');
    }

    public function UpdateAction(Request $request ,$id1, $id2)
    {
        $em = $this->getDoctrine()->getManager();
        $shExperience=$em->getRepository("MainBundle:SharedExperience")->find($id1);
        $Form = $this->createForm(SharedExperienceType::class, $shExperience);
        $Form->handleRequest($request);
        if ($Form->isValid()) {

            $em->persist($shExperience);

            $em->flush();
            return $this->redirectToRoute('affiche_experience');
        }
        return $this->render('MainBundle:SharedExperience:ajout.html.twig', array('Form'=>$Form->createView()));

    }

    public function AfficheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $shExperience = $em->getRepository("MainBundle:SharedExperience")->findAll();
        return $this->render('MainBundle:SharedExperience:affiche.html.twig', array('e' => $shExperience));

    }



}
