<?php

namespace MainBundle\Controller;

use MailBundle\Entity\Contact;
use MailBundle\Entity\Mail;
use MailBundle\Form\ContactType;
use MailBundle\Form\MailType;
use MainBundle\Entity\DemandePartenariat;
use MainBundle\Entity\Etablissement;
use MainBundle\Entity\Partenariat;
use MainBundle\Entity\Test;
use MainBundle\Entity\User;
use MainBundle\Form\DemandeAjoutType;
use MainBundle\Form\DemandePartenariatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DemandePartenariatController extends Controller
{
    public function AjoutDemandeAction(Request $request,$id)
    {
        $demande=new DemandePartenariat();
        $form=$this->createForm(DemandePartenariatType::class,$demande);
        $form->handleRequest($request);
        if ($form->isValid())
        {

            $em=$this->getDoctrine()->getManager();
            $etab = $em->getRepository("MainBundle:Etablissement")->find($id);
            $etab->setPartenaire(0);
            $demande->setFavoris($etab);
            $demande->setUser($this->getUser());
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
        }

        return $this->render('MainBundle:DemandeAjoutPartenariat:DemandeAjout.html.twig',
            array('demande'=>$form->createView()));
    }
    public function AjoutDemandeJsonAction($id,$des)
    {
            $demande=new DemandePartenariat();

            $em=$this->getDoctrine()->getManager();
            $etab = $em->getRepository("MainBundle:Etablissement")->find($id);
            $user = $etab->getRepresentant();
            $etab->setPartenaire(0);
            $demande->setFavoris($etab);
            $demande->setDescription($des);
            $demande->setUser($user);
            $em->persist($demande);
            $em->flush();
            $e = new ObjectNormalizer();
            $serializer = new Serializer([$e]);
            $formatted = $serializer->normalize($demande);
            return new JsonResponse($formatted);

    }
    public function AccepterAdminAction($id)
    {
            $rtenariat=new Partenariat();
            $em=$this->getDoctrine()->getManager();
            $demande = $em->getRepository("MainBundle:DemandePartenariat")->find($id);
            $etab=$demande->getFavoris();
            $etab->setPartenaire(1);
            $rtenariat->setFavoris($etab);
            $rtenariat->setUser($demande->getUser());
            $rtenariat->setDescription($demande->getDescription());
            $em->remove($demande);
            $em->persist($etab);
            $em->persist($rtenariat);
            $em->flush();
            return $this->redirectToRoute('all_demandes_partenariat_admin');

    }
    public function AnnulerDemandeAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("MainBundle:DemandePartenariat")->find($id);
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }
    public function AfficherAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $this->getUser();
        $demande = $em->getRepository("MainBundle:Wishliste")->findBy(array('user' => $user));
        return $this->render('MainBundle:DemandeAjoutPartenariat:ListeDemandes.html.twig',
            array('demandes'=>$demande));
    }
    public function AfficherAdminAction()
    {

        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("MainBundle:DemandePartenariat")->findAll();
        return $this->render('MainBundle:DemandeAjoutPartenariat:ListeAdmin.html.twig',
            array('demandes'=>$demande));
    }
    public function RefuserAdminAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("MainBundle:DemandePartenariat")->find($id);
        $em->remove($demande);
        $em->flush();
        return $this->redirectToRoute('all_demandes_partenariat_admin');
    }
    public function AfficherToutAction()
    {

        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("MainBundle:Partenariat")->findAll();
        return $this->render('MainBundle:DemandeAjoutPartenariat:ListeAdminPartenaires.html.twig',
            array('demandes'=>$demande));
    }
    public function ContacterAction(Request $request,$id)
    {
        $mail = new Contact();
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id);
        $form= $this->createForm(ContactType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {

            var_dump($user->getEmail());

            $message = \Swift_Message::newInstance()
                ->setSubject('Contact de partenariat')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:emailPartenaire.html.twig',
                        array('text' => $mail->getText())
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);

            return $this->redirectToRoute("mes_partenaires");
        }
        return $this->render('MainBundle:DemandeAjoutPartenariat:Contacter.html.twig',
            array('form'=>$form->createView()));
    }
    public function checkDJsonAction($id_etab)
    {


        $em = $this->getDoctrine()->getManager();

        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $exist = $em->getRepository("MainBundle:DemandePartenariat")->findBy(array('favoris' => $etab));
        $val=count($exist);
        $test=new Test();
        $test->setValeur($val);
        $test->setId(0);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }




}
