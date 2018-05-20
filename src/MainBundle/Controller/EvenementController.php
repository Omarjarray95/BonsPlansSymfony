<?php

namespace MainBundle\Controller;
use MainBundle\Entity\Wishliste;
use MainBundle\Entity\Evenement;
use MainBundle\Form\EvenementType;
use MailBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class EvenementController extends Controller
{
    public function AddAction(Request $request,$id){
        $event=new Evenement();
        $event->setNbrPersonnes(0);
        $event->setInteresses(0);
        $Form=$this->createForm(EvenementType::class,$event);
        $Form->handleRequest($request);
        $now=new \DateTime('now');
        if ($Form->isValid() && $event->getDate()>$now){
            $em=$this->getDoctrine()->getManager();
            $etab=$em->getRepository("MainBundle:Etablissement")->find($id);
            $event->setEtablissement($etab);
            $em->persist($event);
            $em->flush();
            $id_event=$event->getId();

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
                ->setSubject('Un nouvel évenement')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailEvent.html.twig',
                        array('nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'date'=>$event->getDate(),'adresse'=>$event->getEtablissement()->getAdresse())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
}
            return $this->redirectToRoute('profile_event_user',array('id_event'=>$id_event));
        }
        return $this->render('MainBundle:Evenement:ajout.html.twig',array(
            'form'=>$Form->createView()
        ));


    }
    public function AddAdminAction(Request $request,$id){
        $event=new Evenement();
        $event->setNbrPersonnes(0);
        $event->setInteresses(0);
        $now=new \DateTime('now');
        $Form=$this->createForm(EvenementType::class,$event);
        $Form->handleRequest($request);
        if ($Form->isValid()&& $event->getDate()>$now){
            $em=$this->getDoctrine()->getManager();
            $etab=$em->getRepository("MainBundle:Etablissement")->find($id);
            $event->setEtablissement($etab);
            $em->persist($event);
            $em->flush();
            $id_event=$event->getId();
            return $this->redirectToRoute('Afficher_Etablissement_ParId_Admin',array('id'=>$id));
        }
        return $this->render('MainBundle:Evenement:ajoutAdmin.html.twig',array(
            'form'=>$Form->createView()
        ));


    }


    public function RemoveAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id);
        $id_etab=$em->getRepository("MainBundle:Etablissement")->find($event->getEtablissement()->getId());
        $interested=$em->getRepository('MainBundle:InterestEvent')->findBy(array('event'=>$event));
        $etab=$event->getEtablissement();
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
                ->setSubject('Evenement annulé')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailEventAnnule.html.twig',
                        array('event'=>$event->getNom(),'nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'date'=>$event->getDate(),'adresse'=>$event->getEtablissement()->getAdresse())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }
        foreach ($interested as $in){
            $em->remove($in);
            $em->flush();
        }
        $going=$em->getRepository('MainBundle:GoingEvent')->findBy(array('event'=>$event));
        foreach ($going as $in){
            $em->remove($in);
            $em->flush();
        }
        $visitedEvent=$em->getRepository('MainBundle:VisitedEvent')->findBy(array('event'=>$event));
        foreach ($visitedEvent as $in){
            $em->remove($in);
            $em->flush();
        }
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_Client',array('id'=>$id_etab->getId()));
    }
    public function RemoveAdminAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id);
        $etab=$em->getRepository('MainBundle:Etablissement')->find($event->getEtablissement());
        $interested=$em->getRepository('MainBundle:InterestEvent')->findBy(array('event'=>$event));
        $etab=$event->getEtablissement();
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
                ->setSubject('Evenement annulé')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailEventAnnule.html.twig',
                        array('event'=>$event->getNom(),'nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'date'=>$event->getDate(),'adresse'=>$event->getEtablissement()->getAdresse())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }
        foreach ($interested as $in){
            $em->remove($in);
            $em->flush();
        }
        $going=$em->getRepository('MainBundle:GoingEvent')->findBy(array('event'=>$event));
        foreach ($going as $in){
            $em->remove($in);
            $em->flush();
        }
        $visitedEvent=$em->getRepository('MainBundle:VisitedEvent')->findBy(array('event'=>$event));
        foreach ($visitedEvent as $in){
            $em->remove($in);
            $em->flush();
        }
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('all_events_Admin');
    }
    public function RemoveEtabAdminAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id);
        $interested=$em->getRepository('MainBundle:InterestEvent')->findBy(array('event'=>$event));
        foreach ($interested as $in){
            $em->remove($in);
            $em->flush();
        }
        $going=$em->getRepository('MainBundle:GoingEvent')->findBy(array('event'=>$event));
        foreach ($going as $in){
            $em->remove($in);
            $em->flush();
        }
        $visitedEvent=$em->getRepository('MainBundle:VisitedEvent')->findBy(array('event'=>$event));
        foreach ($visitedEvent as $in){
            $em->remove($in);
            $em->flush();
        }
        $etab=$event->getEtablissement();
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
                ->setSubject('Evenement annulé')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailEventAnnule.html.twig',
                        array('event'=>$event->getNom(),'nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'date'=>$event->getDate(),'adresse'=>$event->getEtablissement()->getAdresse())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
        }
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_ParId_Admin',array('id'=>$etab->getId()));
    }
    public function AfficheAllAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("MainBundle:Evenement")->findAll();
        return $this->render('MainBundle:Admin:Affiche_Evenement.html.twig',
            array('even'=>$evenement));
    }


    public function AfficheAllUserAction()
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->findRecent();
        return $this->render('MainBundle:Evenement:Liste.html.twig',
            array(
                'e'=>$event
            ));
    }
    public function AfficheAllUserJsonAction()
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




    public function AfficheEventsAdminIdEtabAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $event=$em->getRepository("MainBundle:Evenement")->findBy(array('etablissement'=>$etab));
        return $this->render('MainBundle:Admin:Affiche_Evenement_Id_etab.html.twig',
            array(
                'even'=>$event
            ));
    }
    public function AfficheEventsUserIdEtabAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $event=$em->getRepository("MainBundle:Evenement")->findBy(array('etablissement'=>$etab));
        return $this->render('MainBundle:Evenement:Liste_etab.html.twig',
            array(
                'e'=>$event,'etab'=>$etab
            ));
    }
    public function AfficheIdEventAdminAction($id_event)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("MainBundle:Evenement")->find($id_event);
        return $this->render('MainBundle:Admin:Affiche_Evenement_Id.html.twig',
            array('even'=>$evenement));
    }

    public function AfficheIdEventUserAction($id_event)
    {
        $user=$this->getUser();
        $id_user=$user->getId();
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id_event);
        $exist_interet = $em->getRepository("MainBundle:InterestEvent")->countInterestEvent($event, $user);
        $etab=$event->getEtablissement();
        $exist_going = $em->getRepository("MainBundle:GoingEvent")->countGoingEvent($event, $user);
        return $this->render('MainBundle:Evenement:afficher.html.twig',
            array(
                'user'=>$user,'e'=>$event,'exist_interet'=>$exist_interet==0,'exist_going'=>$exist_going==0,'etab'=>$etab
            ));
    }



    public function UpdateAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
            $event=$em->getRepository("MainBundle:Evenement")->find($id);
        $Form=$this->createForm(EvenementType::class,$event);
        $Form->handleRequest($request);
        if ($Form->isValid() && $Form->isSubmitted()){
            $em->persist($event);
            $em->flush();
            $etab=$event->getEtablissement();
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
                    ->setSubject('Evenement modifié')
                    ->setFrom('bonsplans.esprit@gmail.com')
                    ->setTo($mail->getEmail())
                    ->setBody(
                        $this->renderView(
                            'MailBundle:Mail:emailEventModifie.html.twig',
                            array('event'=>$event->getNom(),'nom' => $mail->getNom(), 'bonplan'=>$etab->getNom(),'date'=>$event->getDate(),'adresse'=>$event->getEtablissement()->getAdresse())
                        ),
                        'text/html'
                    );
                $this->get('mailer')->send($message);
            }
            return $this->redirectToRoute('profile_event_user',array('id_event'=>$id));
        }
        return $this->render("MainBundle:Evenement:update.html.twig",
            array('form'=>$Form->createView()));
    }
    public function AfficheAllEventsJsonAction()
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

    public function findEventByIdJsonAction($id_event)
    {
        $em=$this->getDoctrine()->getManager();
        $evenement=$em->getRepository("MainBundle:Evenement")->find($id_event);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($evenement);
        return new JsonResponse($formatted);
    }
    public function AfficheEtabEventsJsonAction($id_etab)
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
    public function ChercherEventAction($mot)
    {
        $em=$this->getDoctrine()->getManager();

        $event=$em->getRepository("MainBundle:Evenement")->chercher($mot);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }
    public function AddEventJsonAction($id_etab,$date,$nom,$description){
        $event=new Evenement();
        $event->setNbrPersonnes(0);
        $event->setInteresses(0);
        $event->setDescription($description);
        $event->setNom($nom);
        $value = new \DateTime($date);
        $event->setDate($value);
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $event->setEtablissement($etab);
        $em->persist($event);
        $em->flush();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function updateEventJsonAction($id_event,$date,$nom,$description){



        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id_event);
        $event->setDescription($description);
        $event->setNom($nom);
        $value = new \DateTime($date);
        $event->setDate($value);

        $em->persist($event);
        $em->flush();

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }
    public function deleteEventJsonAction($id_event)
    {
        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("MainBundle:Evenement")->find($id_event);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($event->getEtablissement()->getId());
        $em->remove($event);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }

}
