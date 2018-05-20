<?php

namespace MainBundle\Controller;

use MainBundle\Entity\EvaluationEtablissement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EvaluationEtablissementController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function AimeCoolJsonAction($idetab,$iduser)
    {
        $ev = new EvaluationEtablissement();
        $ev->getId();
        $ev->setAime("oui");
        $ev->setPasAime("");
        $ev->setCool("oui");
        $ev->setNulle("");
        $em=$this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($idetab);
        $user = $em->getRepository("MainBundle:User")->find($iduser);
        $ev->setEtablissement($etablissement);
        $ev->setUser($user);
        $em->persist($ev);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($ev);
        return new JsonResponse($formatted);
    }

    public function AimeNulleJsonAction($idetab,$iduser)
    {
        $ev = new EvaluationEtablissement();
        $ev->getId();
        $ev->setAime("oui");
        $ev->setPasAime("");
        $ev->setCool("");
        $ev->setNulle("oui");
        $em=$this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($idetab);
        $user = $em->getRepository("MainBundle:User")->find($iduser);
        $ev->setEtablissement($etablissement);
        $ev->setUser($user);
        $em->persist($ev);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($ev);
        return new JsonResponse($formatted);
    }

    public function PasAimeCoolJsonAction($idetab,$iduser)
    {
        $ev = new EvaluationEtablissement();
        $ev->setAime("");
        $ev->setPasAime("oui");
        $ev->setCool("oui");
        $ev->setNulle("");
        $em=$this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($idetab);
        $user = $em->getRepository("MainBundle:User")->find($iduser);
        $ev->setEtablissement($etablissement);
        $ev->setUser($user);
        $em->persist($ev);
        $em->flush();

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($ev);
        return new JsonResponse($formatted);
    }

    public function PasAimeNulleJsonAction($idetab,$iduser)
    {
        $ev = new EvaluationEtablissement();
        $ev->setAime("");
        $ev->setPasAime("oui");
        $ev->setCool("");
        $ev->setNulle("non");
        $em=$this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($idetab);
        $user = $em->getRepository("MainBundle:User")->find($iduser);
        $ev->setEtablissement($etablissement);
        $ev->setUser($user);
        $em->persist($ev);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($ev);
        return new JsonResponse($formatted);
    }
}
