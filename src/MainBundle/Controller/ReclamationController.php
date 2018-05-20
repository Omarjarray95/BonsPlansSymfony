<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Reclamation;
use MainBundle\Form\ReclamationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReclamationController extends Controller
{
    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function AjouterReclamationAction(Request $request)
    {
        $reclamation = new Reclamation();
        if ($request->isMethod('POST')) {
            $reclamation->setSujet($request->get('sujet'));
            $reclamation->setContenuReclamation($request->get('contenu_reclamation'));
            $reclamation->setIdUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('main_homepage');
        }
        return $this->render('MainBundle:Default:Contact.html.twig',
            array());

    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function mesReclamationsAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository("MainBundle:Reclamation")->findBy(array('id_user' => $user), array('id' => 'desc'));
        return $this->render('MainBundle:Reclamation:ListeReclamations.html.twig',
            array('msg' => $messages));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function AfficherMessagesAction($id_user)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository("MainBundle:DemandeAjout")->find($id_user);
        return $this->render('MainBundle:Reclamation:ListeReclamations.html.twig',
            array('msg' => $message));
    }

    public function DeleteAdminAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $recl=$em->getRepository('MainBundle:Reclamation')->find($id);
        $em->remove($recl);
        $em->flush();
        return $this->redirectToRoute('allReclamations');
    }

    public function AfficheAllAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $recl=$em->getRepository('MainBundle:Reclamation')->findAll();
        return $this->render('MainBundle:Admin:Afficher_Reclamation.html.twig',
            array('recl'=>$recl));
    }

    public function chercherlAdminAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $q = $request->query->get('q'); // recuperier valeur du champs input ayant le nom "q" dans le formulaire de rcherche

        $paginator  = $this->get('knp_paginator'); // appler service paginator
        $query = $em->getRepository('MainBundle:Reclamation')->chercherAdmin($q);

        $recl = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('MainBundle:Admin:Afficher_Reclamation.html.twig',
            array('recl'=>$recl));
    }

    public function AffichageWebServiceAction($id)
    {
        $rec=$this->getDoctrine()->getManager();
        $reclamation=$rec->getRepository("MainBundle:Reclamation")->findBy(array_filter(array(
            'id_user' => $id)));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse($formatted);
    }


    public function AddReclamationWebSerAction($idu, $sujet, $contenu, $ide){

        $rec=new Reclamation();


        $rec->setSujet($sujet);
        $rec->setContenuReclamation($contenu);
        //$event->setNom($nom);
        //$value = new \DateTime($date);
        //$event->setDate($value);
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($idu);
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($ide);
        $rec->setIdUser($user);
        $rec->setIdEtab($etablissement);
        //$reclamation=$em->getRepository("MainBundle:Reclamation")->find($id_etab);
        //$event->setEtablissement($etab);
        $em->persist($rec);
        $em->flush();

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($rec);
        return new JsonResponse($formatted);

    }
    public function RecIdWebServiceAction($ide)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:Reclamation")->findBy(array_filter(array(
            'id_etab' => $ide)));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

}
