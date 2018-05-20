<?php

namespace MainBundle\Controller;

use MainBundle\Entity\GoingEvent;
use MainBundle\Entity\InterestEvent;
use MainBundle\Entity\Test;
use MainBundle\Entity\Visited;
use MainBundle\Entity\VisitedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VisitedController extends Controller
{

    public function checkVisitedAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $etabId = $request->get('id');
            $user = $this->getUser();


            $em = $this->getDoctrine()->getManager();
            $etab = $em->getRepository("MainBundle:Etablissement")->find($etabId);
            $favourite = $em->getRepository("MainBundle:Visited")->isVisited($etab, $user);
            $response = array('alreadyVisited' => true);
            if (count($favourite) == 0) {
                $response = array('alreadyVisited' => false);
            }


            return new JsonResponse($response);
        }

        return new JsonResponse();
    }


    public function deleteVisitAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $visit = $em->getRepository("MainBundle:Visited")->findOneBy(['user' => $user , 'favoris' => $id]);
        $em->remove($visit);
        $em->flush();

        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }
    public function deleteVJsonAction($id_etab,$id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $visit = $em->getRepository("MainBundle:Visited")->findOneBy(['user' => $user , 'favoris' => $etab]);
        $em->remove($visit);
        $em->flush();

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }


    public function addVisitedAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id);
        $exist = $em->getRepository("MainBundle:Visited")->countVisited($etab, $user);
        if ($exist == 0) {
            $visited = new Visited();
            $visited->setUser($user);
            $visited->setFavoris($etab);
            $em->persist($visited);
            $em->flush();
        }

        $response = array('alreadyVisited' => true);


        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }
    public function addVJsonAction($id_etab,$id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $exist = $em->getRepository("MainBundle:Visited")->countVisited($etab, $user);

            $visited = new Visited();
            $visited->setUser($user);
            $visited->setFavoris($etab);
            $em->persist($visited);
            $em->flush();


        $response = array('alreadyVisited' => true);


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }
    public function checkVJsonAction($id_etab,$id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $exist = $em->getRepository("MainBundle:Visited")->countVisited($etab, $user);
        $test=new Test();
        $test->setValeur($exist);
        $test->setId(0);
        $response = array('alreadyVisited' => true);


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }


    public function RemoveVisitedUserAction($id_etablissement)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $etab = $em->getRepository('MainBundle:Etablissement')->find($id_etablissement);
        $visited = $em->getRepository("MainBundle:Visited")->findBy(array('etablissement' => $etab));
        $etabs=$em->getRepository('MainBundle:Etablissement')->findAll();
        $em->remove($visited);
        $em->flush();
        return $this->render('MainBundle:Profile:show_content.html.twig',
            array('etabs_visited' => $etabs));
    }


    public function AfficheVisitedAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $visited = $em->getRepository("MainBundle:Visited")->findBy(array('user' => $user));
        return $this->render('MainBundle:Profile:show_content_2.html.twig',
            array(
                'visited' => $visited
            ));
    }

    public function AfficheVisitedJsonAction($id_user)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id_user);
        $visited = $em->getRepository("MainBundle:Visited")->findBy(array('user' => $user));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($visited);
        return new JsonResponse($formatted);

    }
    public function AfficheVisitsJsonAction($id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $wishes = $em->getRepository("MainBundle:Visited")->findBy(array('user' => $user));

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($wishes);
        return new JsonResponse($formatted);
    }
    public function countJsonAction($id_etab)
    {


        $em = $this->getDoctrine()->getManager();
        $wishes = $em->getRepository("MainBundle:Visited")->findBy(array('favoris' => $id_etab));
        $nb=count($wishes);
        $e = new ObjectNormalizer();
        $test=new Test();
        $test->setValeur($nb);
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }


}
