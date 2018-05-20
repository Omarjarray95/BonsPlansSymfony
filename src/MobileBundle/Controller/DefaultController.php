<?php

namespace MobileBundle\Controller;
use MainBundle\Entity\Offre;
use MainBundle\Entity\Wishliste;
use MainBundle\Entity\Evenement;
use MainBundle\Form\EvenementType;
use MailBundle\Entity\Mail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MobileBundle:Default:index.html.twig');
    }
    public function AfficheAllEventsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->findRecent();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function AfficheAllOffresAction()
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Offre")->findRecent();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function findEventByIdAction($id_event)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("MainBundle:Evenement")->find($id_event);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);
    }
    public function findOffreByIdAction($id_offre)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id_offre);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);
    }
    public function AfficheEtabEventsAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $event=$em->getRepository("MainBundle:Evenement")->findBy(array('etablissement'=>$etab));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }
    public function AfficheEtabOffresAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offres=$em->getRepository("MainBundle:Offre")->findBy(array('etablissement'=>$etab));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offres);
        return new JsonResponse($formatted);
    }
    public function AddEventAction(Request $request){
        $event=new Evenement();
        $event->setNbrPersonnes(0);
        $event->setInteresses(0);
        $event->setDescription($request->get('description'));
        $event->setNom($request->get('nom'));
        $event->setDate($request->get('date'));
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($request->get('etab'));
        $event->setEtablissement($etab);
        $em->persist($event);
        $em->flush();

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function AddOffreAction(Request $request,$id_etab){
        $offre=new Offre();
        $offre->setDescription($request->get('description'));
        $offre->setDateDebut($request->get('deb'));
        $offre->setDateFin($request->get('fin'));
        $offre->setOffre($request->get('offre'));
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offre->setEtablissement($etab);
        $em->persist($offre);
        $em->flush();


        $favourites = $em->getRepository("MainBundle:Wishliste")->findBy(array('favoris'=>$etab));
        foreach ($favourites as $favourite){
            $user=$favourite->getUser();
            $mail = new Mail();
            $mail->setNom($user->getNom());
            $mail->setPrenom("");
            $mail->setTel($user->getPhone());
            $mail->setEmail($user->getEmail());
            $mail->setText("");

            $message = \Swift_Message::newInstance()
                ->setSubject('Un nouvel Offre')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailOffre.html.twig',
                        array('nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'deb'=>$offre->getDateDebut(),'fin'=>$offre->getDateFin(),'adresse'=>$offre->getEtablissement()->getAdresse())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);

    }
}
