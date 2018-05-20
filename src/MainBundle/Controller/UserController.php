<?php

namespace MainBundle\Controller;

use MainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
{

    public function AffichageUsersWebServiceAction()
{
    $em=$this->getDoctrine()->getManager();
    $user=$em->getRepository("MainBundle:User")->findAll();
    $e = new ObjectNormalizer();
    $e->setCircularReferenceHandler(function ($object)
    {
        return $object;
    });
    $serializer = new Serializer([$e]);
    $formatted = $serializer->normalize($user);
    return new JsonResponse($formatted);
}


    public function AddUserServiceWebAction($nom,$sexe,$ville,$phone,$email,$username,$password){
        $user=new User();
        $user->setNom($nom);
        $user->setSexe($sexe);
        //$value = new \DateTime($datedenaissance);
        //$user->setDatedenaissance($value);
        $user->setVille($ville);
        $user->setPhone($phone);
        // $user->setUrl($url);
        //$user->setIntro($user);
        //$user->setConfirmationToken($user);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setUsernameCanonical($username);
        $user->setUsername($username);
        $user->setPassword($password);
        // $user->setRoles("Membre");
        $em=$this->getDoctrine()->getManager();
        //$etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        //$event->setEtablissement($etab);
        $em->persist($user);
        $em->flush();

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);

    }

    public function LoginWebServiceAction($email, $pass)
    {
        $em=$this->getDoctrine()->getManager();
        $criteria = array_filter(array(
            'email' => $email,
            'password' => $pass));
        $user=$em->getRepository("MainBundle:User")->findBy($criteria);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function DeleteUserWebServiceAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id);
        $em->remove($user);
        $em->flush();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function UserWebServiceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $user="hola";
        //$em->remove($user);
        $em->flush();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function ModificationUserWebServiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $User = $em->getRepository("MainBundle:User")->find($request->get('id'));
        $User->setNom($request->get('nom'));
        $User->setUsername($request->get('username'));
        $User->setEmail($request->get('email'));
        $User->setPhone($request->get('phone'));

        $User->setVille($request->get('ville'));

        $em->persist($User);
        $em->flush();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($User);
        return new JsonResponse($formatted);
    }
}
