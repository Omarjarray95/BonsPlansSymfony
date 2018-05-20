<?php
/**
 * Created by PhpStorm.
 * User: Maissa
 * Date: 20/02/2018
 * Time: 8:42 PM
 */

namespace MainBundle\Controller;


use MainBundle\Entity\Commentaire;
use MainBundle\Entity\Etablissement;
use MainBundle\Entity\TableIndications;
use MainBundle\Form\CommentaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Commentaire1Controller extends Controller
{

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function AjouutAction(Request $request, Etablissement $etablissement)
    {
        $commentaire = new Commentaire();
        $user = $this->getUser();
        if ($request->isMethod('POST')) {
            $commentaire->setComment($request->get('commentaire'));
            $commentaire->setUser($user);
            $commentaire->setEtablissement($etablissement);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $etablissement->getId()));
        }
    }


    public function DeleteAction(Request $request, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MainBundle:Commentaire")->find($id);
        $etablissement = $commentaire->getEtablissement()->getid();
        if ($commentaire->getUser() == $user and $request->isXmlHttpRequest()) {
            $em->remove($commentaire);
            $em->flush();
            return new JsonResponse();
        }
        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $etablissement));

    }

    public function UpdateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MainBundle:Commentaire")->find($id);

        $user = $this->getUser();

        $Form = $this->createForm(CommentaireType::class, $commentaire);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $commentaire->setUpdatedAt(new \DateTime());
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $commentaire->getEtablissement()->getId()));
        }

        return $this->render('MainBundle:Commentaire:Update.html.twig', array('form' => $Form->createView()));
    }

    public function SignalerAction(Request $request, $id)
    {
        $ti = new TableIndications();
        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $commentaire = $em->getRepository("MainBundle:Commentaire")->find($id);
            if($this->nbIndicationParUserAction($id) == 1){
                $this->addFlash('error', 'Vous avez deja signalé ce commentaire');
                return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $commentaire->getEtablissement()->getId()));

            }

            if ($this->nbIndicationsAction($id) < 4) {
                $ti->setIndication($request->get('contact'));
                $ti->setIdCommentaire($commentaire->getId());
                $ti->setUser($this->getUser());
                $em->persist($ti);
                $em->flush();
                return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $commentaire->getEtablissement()->getId()));
            }
            $em->remove($commentaire);
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $commentaire->getEtablissement()->getId()));

        }

        return $this->render('MainBundle:Commentaire:Signaler.html.twig');
    }

    public function nbIndicationsAction($idComment)
    {
        $em = $this->getDoctrine()->getManager();
        $nbIndications = $em->getRepository('MainBundle:TableIndications')->findBy(array(
            'idCommentaire' => $idComment
        ));

        return count($nbIndications);
    }

    public function nbIndicationParUserAction($idComment)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $nbIndicationsParUser = $em->getRepository('MainBundle:TableIndications')->findBy(array(
            'idCommentaire' => $idComment, 'user'=>$user
        ));

        return count($nbIndicationsParUser);
    }
    public function AffichageCommentaireWebServiceAction($idetab)
    {
        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository("MainBundle:Commentaire")->findBy(array('etablissement' => $idetab));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($commentaire);
        return new JsonResponse($formatted);
    }

    public function AddCommentaireJsonAction($comment,$idetab,$iduser)
    {
        $commentaire = new Commentaire();
        $commentaire->setComment($comment);
        $em=$this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($idetab);
        $user = $em->getRepository("MainBundle:User")->find($iduser);
        $commentaire->setEtablissement($etablissement);
        $commentaire->setUser($user);
        $em->persist($commentaire);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($commentaire);
        return new JsonResponse($formatted);
    }

    public function  SuppCommentaireJsonAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MainBundle:Commentaire")->find($id);
        $em->remove($commentaire);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($commentaire);
        return new JsonResponse($formatted);

    }

    public function  ModifCommentaireJsonAction($id,$comment)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("MainBundle:Commentaire")->find($id);

        // $user = $this->getUser();

        // $Form = $this->createForm(CommentaireType::class, $commentaire);
        // $Form->handleRequest($request);
        //if ($Form->isValid()) {
        $commentaire->setUpdatedAt(new \DateTime());
        $commentaire->setComment($comment);
        $em->persist($commentaire);
        $em->flush();
        //}
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($commentaire);
        return new JsonResponse($formatted);
    }
}