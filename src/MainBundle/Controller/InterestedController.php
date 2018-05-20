<?php

namespace MainBundle\Controller;

use MainBundle\Entity\InterestEvent;
use MainBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class InterestedController extends Controller
{
    public function checkInterestAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $eventId = $request->get('id');
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository("MainBundle:Evenement")->find($eventId);
            $favourite = $em->getRepository("MainBundle:InterestEvent")->isInterested($event, $user);
            $response = array('interested' => true);
            if (count($favourite) == 0) {
                $response = array('interested' => false);
            }


            return new JsonResponse($response);
        }

        return new JsonResponse();
    }


    public function deleteInterestAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("MainBundle:Evenement")->find($id);
        $exist_interet = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        if ($exist_interet == 1) {
            $intrest = $em->getRepository("MainBundle:InterestEvent")->findOneBy(array('event' => $event, 'user' => $user));
            $em->remove($intrest);
            $event->setInteresses($event->getInteresses() - 1);
            $em->persist($event);
            $em->flush();
        }
        return $this->redirectToRoute('profile_event_user', array('id_event' => $id));
    }

    public function deleteInterestedJsonAction($id_user,$id_event)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $event = $em->getRepository("MainBundle:Evenement")->find($id_event);
        //$exist_interet = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        //if ($exist_interet == 1) {
            $intrest = $em->getRepository("MainBundle:InterestEvent")->findOneBy(array('event' => $event, 'user' => $user));
            $em->remove($intrest);
            $event->setInteresses($event->getInteresses() - 1);
            $em->persist($event);
            $em->flush();
        //}

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }


    public function addInterestedJsonAction($id_user,$id_event)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $event = $em->getRepository("MainBundle:Evenement")->find($id_event);
       // $exist = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
       // $exist_going = $em->getRepository("MainBundle:GoingEvent")->countGoingEvent($event, $user);
       // if ($exist_going ==1) {
       //     $going = $em->getRepository("MainBundle:GoingEvent")->findOneBy(array('user'=>$user,'event'=>$event));
        //    $em->remove($going);
         //   $event->setNbrPersonnes($event->getNbrPersonnes() - 1);
         //   $em->flush();
       // }
       // if ($exist == 0) {
            $interest = new InterestEvent();
            $interest->setUser($user);
            $interest->setEvent($event);
            $event->setInteresses($event->getInteresses() + 1);
            $em->persist($interest);
            $em->persist($event);
            $em->flush();
        //}

        $response = array('interested' => true);


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }
    public function addInterestedAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();
        $id_user = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("MainBundle:Evenement")->find($id);
        $exist = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        $exist_going = $em->getRepository("MainBundle:GoingEvent")->countGoingEvent($event, $user);
        if ($exist_going ==1) {
            $going = $em->getRepository("MainBundle:GoingEvent")->findOneBy(array('user'=>$user,'event'=>$event));
            $em->remove($going);
            $event->setNbrPersonnes($event->getNbrPersonnes() - 1);
            $em->flush();
        }
        if ($exist == 0) {
            $interest = new InterestEvent();
            $interest->setUser($user);
            $interest->setEvent($event);
            $event->setInteresses($event->getInteresses() + 1);
            $em->persist($interest);
            $em->persist($event);
            $em->flush();
        }

        $response = array('interested' => true);


        return $this->redirectToRoute('profile_event_user', array('id_event' => $id));
    }


    public function RemoveInterestedEventUserAction($id_event)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository("MainBundle:Evenement")->find($id_event);
        $exist_interet = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        if ($exist_interet == 1) {
            $intrest = $em->getRepository("MainBundle:InterestEvent")->findOneBy(array('event' => $event, 'user' => $user));
            $em->remove($intrest);
            $event->setInteresses($event->getInteresses() - 1);
            $em->persist($event);
            $em->flush();
        }
        return $this->redirectToRoute('fos_user_profile_show');
    }
    public function AfficheInterestEventAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $interestedEvents = $em->getRepository("MainBundle:InterestEvent")->findBy(array('user' => $user));

        return $this->render('MainBundle:Profile:show_content_5.html.twig',
            array(
                'interest' => $interestedEvents
            ));
    }
    public function AfficheInterestedEventJsonAction($id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $interestedEvents = $em->getRepository("MainBundle:InterestEvent")->findBy(array('user' => $user));

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($interestedEvents);
        return new JsonResponse($formatted);
    }
    public function checkJsonAction($id_event,$id_user)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $event = $em->getRepository("MainBundle:Evenement")->find($id_event);
        $exist = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        $test=new Test();

        $test->setId(0);
        $test->setValeur($exist);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);

    }


}
