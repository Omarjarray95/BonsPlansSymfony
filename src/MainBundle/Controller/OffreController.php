<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Offre;
use MainBundle\Form\OffreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swift_Message;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class OffreController extends Controller
{

    public function AjoutAction(Request $request,$id){
        $Offre=new Offre();
        $Form=$this->createForm(OffreType::class,$Offre);
        $Form->handleRequest($request);
        $now=new \DateTime('now');
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id);

        if ($Form->isValid() && $Offre->getDateDebut()>=$now && $Offre->getDateFin()>=$Offre->getDateDebut()){

            $Offre->setEtablissement($etab);
            if ($etab->getPartenaire()==0){

                $Offre->setPourcentage(0);
                $Offre->setCodePromo("");
            }
            $em->persist($Offre);
            $em->flush();
            $id_offre=$Offre->getId();
            return $this->redirectToRoute('profile_offre_user',array('id'=>$id_offre));
        }
        return $this->render('MainBundle:Offre:ajout.html.twig',array(
            'form'=>$Form->createView(),'etab'=>$etab
        ));

    }
    public function AjoutAdminAction(Request $request,$id){
        $Offre=new Offre();
        $now=new \DateTime('now');
        $Form=$this->createForm(OffreType::class,$Offre);
        $Form->handleRequest($request);
        if ($Form->isValid()&& $Offre->getDateDebut()>=$now && $Offre->getDateFin()>=$Offre->getDateDebut()){
            $em=$this->getDoctrine()->getManager();
            $etab=$em->getRepository("MainBundle:Etablissement")->find($id);
            $Offre->setEtablissement($etab);
            $em->persist($Offre);
            $em->flush();
            $id_offre=$Offre->getId();
            return $this->redirectToRoute('Afficher_Etablissement_ParId_Admin',array('id'=>$id));
        }
        return $this->render('MainBundle:Admin:Ajouter_Offre.html.twig',array(
            'form'=>$Form->createView()
        ));

    }

    public function RemoveAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $Offre=$em->getRepository("MainBundle:Offre")->find($id);
        $id_etab=$em->getRepository("MainBundle:Etablissement")->find($Offre->getEtablissement());
        $em->remove($Offre);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_Client',array('id'=>$id_etab->getId()));
    }
    public function RemoveAdminAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id);
        $etab=$em->getRepository('MainBundle:Etablissement')->find($offre->getEtablissement());
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_ParId_Admin',array('id'=>$etab->getId()));
    }
    public function AfficheAllAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $offres=$em->getRepository("MainBundle:Offre")->findAll();
        return $this->render('MainBundle:Admin:Affiche_Offre.html.twig',
            array('offre'=>$offres));
    }

    public function AfficheAllUserAction()
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->findRecent();
        return $this->render('MainBundle:Offre:Liste.html.twig',
            array(
                'offre'=>$offre
            ));
    }
    public function AfficheOffresAdminIdEtabAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offre=$em->getRepository("MainBundle:Offre")->findBy(array('etablissement'=>$etab));
        return $this->render('MainBundle:Admin:Affiche_Offre_Id_etab.html.twig',
            array(
                'offre'=>$offre
            ));
    }
    public function AfficheOffresUserIdEtabAction($id_etab)
    {
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offre=$em->getRepository("MainBundle:Offre")->findBy(array('etablissement'=>$etab));
        return $this->render('MainBundle:Offre:Liste_etab.html.twig',
            array(
                'offre'=>$offre,'etab'=>$etab
            ));
    }
    public function AfficheIdOffreAdminAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id);
        return $this->render('MainBundle:Admin:Affiche_Offre_Id.html.twig',
            array('offre'=>$offre));
    }

    public function AfficheIdOffreUserAction($id)
    {
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id);
        $etab=$offre->getEtablissement();
        return $this->render('MainBundle:Offre:afficher.html.twig',
            array(
                'offre'=>$offre,'user'=>$user,'etab'=>$etab
            ));
    }

    public function UpdateAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        $Offre=$em->getRepository("MainBundle:Offre")->find($id);
        $Form=$this->createForm(OffreType::class,$Offre);
        $Form->handleRequest($request);
        if ($Form->isValid() && $Form->isSubmitted()){
            $em->persist($Offre);
            $em->flush();
            return $this->redirectToRoute('profile_offre_user',array('id'=>$id));
        }
        return $this->render("MainBundle:Offre:update.html.twig",
            array('form'=>$Form->createView()));

    }

    public function AfficheAllOffresJsonAction()
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
    public function findOffreByIdJsonAction($id_offre)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id_offre);
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);
    }
    public function AfficheEtabOffresJsonAction($id_etab)
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
    public function AddOffreAvecPromoJsonAction($id_etab,$deb,$fin,$name,$des,$code,$pour){
        $offre=new Offre();
        $offre->setDescription($des);
        $value1 = new \DateTime($deb);
        $value2 = new \DateTime($fin);
        $offre->setDateDebut($value1);
        $offre->setDateFin($value2);
        $offre->setOffre($name);
        $offre->setCodePromo($code);
        $offre->setPourcentage($pour);
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offre->setEtablissement($etab);
        $em->persist($offre);
        $em->flush();


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);

    }
    public function AddOffreSansPromoJsonAction($id_etab,$deb,$fin,$name,$des){
        $offre=new Offre();
        $offre->setDescription($des);
        $value1 = new \DateTime($deb);
        $value2 = new \DateTime($fin);
        $offre->setDateDebut($value1);
        $offre->setDateFin($value2);
        $offre->setOffre($name);
        $offre->setCodePromo("");
        $offre->setPourcentage(0);
        $em=$this->getDoctrine()->getManager();
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $offre->setEtablissement($etab);
        $em->persist($offre);
        $em->flush();


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);

    }
    public function updateOffreSansPromoJsonAction($id_offre,$deb,$fin,$name,$des){
    $em=$this->getDoctrine()->getManager();
    $offre=$em->getRepository("MainBundle:Offre")->find($id_offre);
    $offre->setDescription($des);
    $value1 = new \DateTime($deb);
    $value2 = new \DateTime($fin);
    $offre->setDateDebut($value1);
    $offre->setDateFin($value2);
    $offre->setOffre($name);

    $em->persist($offre);
    $em->flush();


    $e = new ObjectNormalizer();
    $serializer = new Serializer([$e]);
    $formatted = $serializer->normalize($offre);
    return new JsonResponse($formatted);

}
    public function updateOffreAvecPromoJsonAction($id_offre,$deb,$fin,$name,$des,$code,$pour){
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository("MainBundle:Offre")->find($id_offre);
        $offre->setDescription($des);
        $value1 = new \DateTime($deb);
        $value2 = new \DateTime($fin);
        $offre->setDateDebut($value1);
        $offre->setDateFin($value2);
        $offre->setOffre($name);
        $offre->setCodePromo($code);
        $offre->setPourcentage($pour);
        $em->persist($offre);
        $em->flush();


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($offre);
        return new JsonResponse($formatted);

    }
    public function ChercherOffreAction($mot)
    {
        $em=$this->getDoctrine()->getManager();

        $event=$em->getRepository("MainBundle:Offre")->chercher($mot);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }

    public function deleteOffreJsonAction($id_offre)
    {
        $em=$this->getDoctrine()->getManager();
        $Offre=$em->getRepository("MainBundle:Offre")->find($id_offre);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($Offre->getEtablissement()->getId());
        $em->remove($Offre);
        $em->flush();
        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }
}
