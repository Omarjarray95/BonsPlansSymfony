<?php

namespace MailBundle\Controller;
use MailBundle\Entity\Mail;
use MailBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function indexAction(Request $request)
    {
        $mail = new Mail();
        $form= $this->createForm(MailType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom('bonsplans.esprit@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:email.html.twig',
                        array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);



            $message2 = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom($mail->getEmail())
                ->setTo('bonsplans.esprit@gmail.com')
                ->setBody(
                    $this->renderView(
                        'MailBundle:Mail:email2.html.twig',
                        array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom(),'text'=>$mail->getText())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message2);



            return $this->redirect($this->generateUrl('mail_accuse'));
        }
        return $this->render('MainBundle:Default:Contact.html.twig',
            array('form'=>$form->createView()));
    }
    public function successAction(){

        return $this->redirectToRoute('succes');
    }


}