<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Reservation;
use MainBundle\Form\RechercheTypeR;
use MainBundle\Form\ReservationHotel;
use MainBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReservationController extends Controller
{
    public function AjoutAction(Request $request, $id1, $id2)
    {
        $reservation = new Reservation();
        $now = new \DateTime('now');
        if($id2=='hotels')
        {
            $Form1 = $this->createForm(ReservationHotel::class,$reservation);
            $Form1->handleRequest($request);
            if ($Form1->isValid() && $reservation->getArrivee()>$now) {
                $em = $this->getDoctrine()->getManager();
                $etab = $em->getRepository("MainBundle:Etablissement")->find($id1);
                $user = $this->getUser();
                $reservation->setEtablissement($etab);
                $reservation->setUser($user);
                $em->persist($reservation);
                $em->flush();
               return $this->redirectToRoute('main_homepage');
            }
            return $this->render('MainBundle:Reservation:ajout1.html.twig', array('Form' => $Form1->createView()));
        }
        else
        {
            $Form = $this->createForm(ReservationType::class, $reservation);
            $Form->handleRequest($request);
            if ($Form->isValid() && $reservation->getDatedereservation()>$now ) {
                $em = $this->getDoctrine()->getManager();
                $etab = $em->getRepository("MainBundle:Etablissement")->find($id1);
                $user = $this->getUser();
                $reservation->setEtablissement($etab);
                $reservation->setUser($user);
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('main_homepage');
            }
            return $this->render('MainBundle:Reservation:ajout.html.twig', array('Form' => $Form->createView()));
        }

    }


    public function AfficheAction($id1)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->Affichage($id1);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id1);


        return $this->render('MainBundle:Reservation:affiche.html.twig', array('r' => $reservation,'etab'=>$etab));
    }

    public function AfficheCAction($id1)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->Affich1($id1);
        return $this->render('MainBundle:Reservation:affiche.html.twig', array('r' => $reservation));
    }

    public function DeleteAction($id1, $id2)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->find($id1);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id2);
        $e=$etab->getId();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('main_homepage');

    }

    public function UpdateAction(Request $request, $id1, $id2)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->find($id1);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id2);
        $Form = $this->createForm(ReservationType::class, $reservation);
        $Form->handleRequest($request);
        if ($Form->isValid()) {

            $em->persist($reservation);
            $em->persist($etab);
            $em->flush();
            return $this->redirectToRoute('main_homepage');
        }
        return $this->render('MainBundle:Reservation:ajout.html.twig', array('Form' => $Form->createView()));
    }

    public function RechercheNAction(Request $request)
    {
        $reservation = new Reservation();
        $em = $this->getDoctrine()->getManager();
        $Form = $this->createForm(RechercheTypeR::class, $reservation);
        $Form->handleRequest($request);
        if ($Form->isValid()) {

            $reservation = $em->getRepository("MainBundle:Reservation")->findBy(array('nom' => $Form["nom"]->getData()));

        } else {
            $reservation = $em->getRepository("MainBundle:Reservation")->findAll();
        }


        return $this->render("MainBundle:Reservation:RechercheR.html.twig", array('form' => $Form->createView(), 'r' => $reservation));
    }
    public function allAction(){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->findAll();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);

    }




    public function findAction($id){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->find($id);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }

    public function findMotAction($mot,$id_etab){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->chercher($mot,$id_etab);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }

    public function findReservEtabJsonAction($id_etab){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->FiltreEtab($id_etab);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }

    public function findReservUserJsonAction($id_user){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->FiltreUser($id_user);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }
    public function findNomJsonAction($nom){
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository("MainBundle:Reservation")->FiltreNom($nom);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }
    public function AjoutAutreJsonAction($id_etab,$id_user,$nom,$prenom,$numtel,$nbrper,$date)
    {
        $reservation = new Reservation();
        $em = $this->getDoctrine()->getManager();
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $reservation->setEtablissement($etab);
        $reservation->setUser($user);
        $value1 = new \DateTime($date);
        //$value2 = new \DateTime($heure);
        $reservation->setDatedereservation($value1);
        //$reservation->setHeuredereservation($value2);
        $reservation->setNom($nom);
        $reservation->setPrenom($prenom);
        $reservation->setNumtel($numtel);
        $reservation->setNbrePersonnes($nbrper);
        $em->persist($reservation);
        $em->flush();

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);
    }

    public function ModificationReservationJsonAction($id,$id_etab,$id_user,$nom,$prenom,$numtel,$nbrper,$date){



        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("MainBundle:Reservation")->find($id);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $reservation->setEtablissement($etab);
        $reservation->setUser($user);
        $value1 = new \DateTime($date);
        //$value2 = new \DateTime($heure);
        $reservation->setDatedereservation($value1);
        //$reservation->setHeuredereservation($value2);
        $reservation->setNom($nom);
        $reservation->setPrenom($prenom);
        $reservation->setNumtel($numtel);
        $reservation->setNbrePersonnes($nbrper);
        $em->persist($reservation);
        $em->flush();

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);

    }

    public function SuppressionReservationJsonAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reservation=$em->getRepository("MainBundle:Reservation")->find($id);

        $em->remove($reservation);
        $em->flush();
        return new JsonResponse(true);
    }



}


