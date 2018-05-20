<?php

namespace MainBundle\Controller;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->findAll();
        $etablissementr=$em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>'Resto_Café'));
        $etablissements=$em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>'Shops'));
        $etablissementh=$em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>'hotels'));
        $etablissementa=$em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>'Autres'));
        return $this->render('MainBundle:Default:index.html.twig',
            array('eta'=>$etablissement,'eta1'=>$etablissementr,'eta2'=>$etablissements,'eta3'=>$etablissementh
            ,'eta4'=>$etablissementa));
    }

    public function indexAdminAction()
    {
        return $this->render('baseAdmin.html.twig');
    }

    public function aproposAction()
    {
        return $this->render('MainBundle:Default:APropos.html.twig');
    }

    public function GetAdmins()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("MainBundle:User")->findAll();
        $output = array();
        foreach ($users as $user)
        {
            if ($user->hasRole('ROLE_ADMIN'))
            {
                $output[]=$user;
            }
        }
        return $output;
    }

    public function GetRepresentants()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("MainBundle:User")->findAll();
        $output = array();
        foreach ($users as $user)
        {
            if ($user->hasRole('ROLE_REPRESENTANT'))
            {
                $output[]=$user;
            }
        }
        return $output;
    }

    public function sendNotificationAction()
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        $admins = $this->GetAdmins();
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification($admins, $notif, true);
        $s=new Serializer(array(new ObjectNormalizer()));
        $e = $s->normalize($admins,'json');
        $response = new JsonResponse();
        return $response->setData(array('et'=>$e));
    }

    public function GMAction($type)
    {
        return $this->render('MainBundle:Default:GM.html.twig',array('type'=>$type));
    }
}
