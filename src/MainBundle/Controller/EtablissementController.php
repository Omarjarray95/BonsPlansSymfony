<?php

namespace MainBundle\Controller;

use MainBundle\Entity\DemandeAjout;
use MainBundle\Form\EtablissementType;
use MainBundle\Form\ModifEtablissementType;
use MainBundle\Form\ModifPhotoEtablissementType;
use MainBundle\Form\RatingTypes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Etablissement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EtablissementController extends Controller
{

    public function AccepterAdminAction($id){
        $etablissement=new Etablissement();
        $em=$this->getDoctrine()->getManager();
        $demande=$em->getRepository("MainBundle:DemandeAjout")->find($id);
        $etablissement->setNom($demande->getNom());
        $etablissement->setAdresse($demande->getAdresse());
        $etablissement->setBudgetmoyen($demande->getBudgetmoyen());
        $etablissement->setDescription($demande->getDescription());
        $etablissement->setHoraireFermeture($demande->getHoraireFermeture());
        $etablissement->setHoraireOuverture($demande->getHoraireOuverture());
        $etablissement->setImagePrincipale($demande->getImagePrincipale());
        $etablissement->setNumTel($demande->getNumTel());
        $etablissement->setTypeLoisirs($demande->getTypeLoisirs());
        $etablissement->setType($demande->getType());
        $etablissement->setURL($demande->getURL());
        $etablissement->setRepresentant($demande->getIdUser());
        $etablissement->setPartenaire(0);
        $em->persist($etablissement);
        $em->remove($demande);
        $em->flush();
        return $this->render('MainBundle:Admin:Afficher_Etablissement_ParId.html.twig',
            array('etab'=>$etablissement));

    }


    public function AjoutAction(Request $request)
    {
        $etablissement=new Etablissement();
        $form=$this->createForm(EtablissementType::class,$etablissement);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            /** @var UploadedFile $image */
            $image=$etablissement->getImagePrincipale();
            $imageName = $this->generateUniqueFileName().'.'.$image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $etablissement->setImagePrincipale($imageName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Admin');
        }

        return $this->render('MainBundle:Admin:Ajouter_Etablissement.html.twig',
            array('e' => $form->createView()));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
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

    public function AfficheAction()
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->findAll();
        return $this->render('MainBundle:Admin:Afficher_Etablissement.html.twig',
            array('eta'=>$etablissement));
    }

    public function AfficheIdAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
        return $this->render('MainBundle:Admin:Afficher_Etablissement_ParId.html.twig',
            array('etab'=>$etablissement));
    }

    public function ModifAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($id);
        $etablissement->setImagePrincipale
        (new File($this->getParameter('brochures_directory').'/'.$etablissement->getImagePrincipale()));

        $form = $this->createForm(ModifEtablissementType::class, $etablissement);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {
            $image=$etablissement->getImagePrincipale();
            $imageName = $this->generateUniqueFileName().'.'.$image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $etablissement->setImagePrincipale($imageName);
            $em->persist($etablissement);
            $em->flush();
            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification("Modification D'Etablissements");
            $notif->setMessage('Vos Modifications De '.$etablissement->getNom().' Ont été Enregistrées');
            $notif->setLink('');
            $manager->addNotification(array($this->getUser()), $notif, true);
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
        }
        return $this->render('MainBundle:Representant:Modifier_Etablissement_Representant.html.twig',
            array('et' => $form->createView(),'nom'=>$etablissement->getNom()));
    }

    public function ModifPhotoAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissement = $em->getRepository("MainBundle:Etablissement")->find($id);
        $etablissement->setImagePrincipale
        (new File($this->getParameter('brochures_directory').'/'.$etablissement->getImagePrincipale()));
        $form = $this->createForm(ModifPhotoEtablissementType::class, $etablissement);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {
            $image=$etablissement->getImagePrincipale();
            $imageName = $this->generateUniqueFileName().'.'.$image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $etablissement->setImagePrincipale($imageName);
            $em->persist($etablissement);
            $em->flush();
            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification("Modification Du Photo D'Etablissement");
            $notif->setMessage('Le Photo De '.$etablissement->getNom().' A été Modifié');
            $notif->setLink('');
            $manager->addNotification(array($this->getUser()), $notif, true);
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
        }
        return $this->render('MainBundle:Representant:Modifier_Etablissement_Photo.html.twig',
            array('etabl' => $form->createView(),'nom'=>$etablissement->getNom()));
    }

    public function SuppAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
        $visited=$em->getRepository('MainBundle:Visited')->findBy(array('favoris'=>$etablissement));
        $events=$em->getRepository('MainBundle:Evenement')->findBy(array('etablissement'=>$etablissement));
        $offres=$em->getRepository('MainBundle:Offre')->findBy(array('etablissement'=>$etablissement));
        $partenariat=$em->getRepository('MainBundle:Partenariat')->findBy(array('favoris'=>$etablissement));
        $demandesPartner=$em->getRepository('MainBundle:DemandePartenariat')->findBy(array('favoris'=>$etablissement));
        foreach ($visited as $in){
            $em->remove($in);
            $em->flush();
        }
        foreach ($partenariat as $in){
            $em->remove($in);
            $em->flush();
        }
        foreach ($demandesPartner as $in){
            $em->remove($in);
            $em->flush();
        }
        foreach ($events as $in){
            $interested=$em->getRepository('MainBundle:InterestEvent')->findBy(array('event'=>$in));
            foreach ($interested as $a){
                $em->remove($a);
                $em->flush();
            }
            $going=$em->getRepository('MainBundle:GoingEvent')->findBy(array('event'=>$in));
            foreach ($going as $b){
                $em->remove($b);
                $em->flush();
            }
            $visitedEvent=$em->getRepository('MainBundle:VisitedEvent')->findBy(array('event'=>$in));
            foreach ($visitedEvent as $c){
                $em->remove($c);
                $em->flush();
            }
            $em->remove($in);
            $em->flush();
        }
        foreach ($offres as $in){
            $em->remove($in);
            $em->flush();
        }
        $wishs=$em->getRepository('MainBundle:Wishliste')->findBy(array('favoris'=>$etablissement));
        foreach ($wishs as $in){
            $em->remove($in);
            $em->flush();
        }
        $em->remove($etablissement);
        $em->flush();
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification("Modification D'Etablissements");
        $notif->setMessage($etablissement->getNom().' A été Supprimé');
        $notif->setLink('');
        $manager->addNotification(array($this->getUser()), $notif, true);
        return $this->redirectToRoute('Afficher_Etablissement_Admin');
    }

    public function FiltreAction($critere)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissements=$em->getRepository("MainBundle:Etablissement")->FiltrerDQL($critere);
        return $this->render("MainBundle:Admin:Afficher_Etablissement.html.twig", array('eta'=>$etablissements));
    }

    public function TriAction($critere)
    {
        $em=$this->getDoctrine()->getManager();
        if ($critere=='HOA')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy([],array('horaireOuverture'=>'ASC'));
        }
        elseif ($critere=='HFD')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy([],array('horaireFermeture'=>'DESC'));
        }
        elseif ($critere=='BMA')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy([],array('budgetmoyen'=>'ASC'));
        }
        elseif ($critere=='BMD')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy([],array('budgetmoyen'=>'DESC'));
        }
        else
        {
            $etablissements=$em->getRepository("MainBundle:Etablissement")->findAll();
        }
        return $this->render("MainBundle:Admin:Afficher_Etablissement.html.twig", array('eta'=>$etablissements));
    }

    public function RechercheAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        if ($request->isMethod('POST'))
        {
            $nom = $request->get('abc');
            $etablissements=$em->getRepository("MainBundle:Etablissement")->RechercherDQL($nom);
            return $this->render("MainBundle:Admin:Afficher_Etablissement.html.twig", array('eta'=>$etablissements));
        }
    }

    public function AjoutCAction(Request $request)
    {
        $etablissement=new Etablissement();
        $form=$this->createForm(EtablissementType::class,$etablissement);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            /** @var UploadedFile $image */
            $image=$etablissement->getImagePrincipale();
            $imageName = $this->generateUniqueFileName().'.'.$image->guessExtension();
            $image->move($this->getParameter('brochures_directory'), $imageName);
            $etablissement->setImagePrincipale($imageName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($etablissement);
            $em->flush();
            return $this->redirectToRoute('main_homepage');
        }

        return $this->render('MainBundle:Etablissement:ajouter.html.twig',
            array('e' => $form->createView()));
    }

    public function AfficheAccueilAction()
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->findAll();
        $etablissementr=$em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>'Resto_Café'));
        return $this->render('MainBundle::LayoutFront.html.twig',
            array('eta'=>$etablissement,'eta1'=>$etablissementr));
    }

    public function AfficheCAction($id,Request $request)
    {
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
        $tags=$em->getRepository("MainBundle:Tag")->RechercherTagDQL($id);
        $exist_v = $em->getRepository("MainBundle:Visited")->countVisited($etablissement, $user);
        $exist_w = $em->getRepository("MainBundle:Wishliste")->countWishliste($etablissement, $user);
        $Likes=$em->getRepository('MainBundle:Wishliste')->findBy(array('favoris'=>$etablissement));
        $nbrLikes=count($Likes);
        $Visits=$em->getRepository('MainBundle:Visited')->findBy(array('favoris'=>$etablissement));
        $nbrVisits=count($Visits);
        $query = $em->getRepository('MainBundle:Commentaire')->findBy(array(
            'etablissement'=>$etablissement), array('id'=>'desc'));

        $paginator  = $this->get('knp_paginator');
        $comments = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/);
        return $this->render('MainBundle:Etablissement:afficher.html.twig',
            array('user'=>$user,'etab'=>$etablissement,'t'=>$tags,'exist_v' => $exist_v == 0,'exist_w'=>$exist_w==0,'likes'=>$nbrLikes,'visits'=>$nbrVisits,'comments'=>$comments));
    }

    public function RechercherCAction($critere)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissements=$em->getRepository("MainBundle:Etablissement")->FiltrerDQL($critere);
        return $this->render("MainBundle:Etablissement:Rechercher_Etablissement_Client.html.twig", array('eta'=>$etablissements,'critere'=>$critere));
    }

    public function TriCAction($critere1,$critere2)
    {
        $em=$this->getDoctrine()->getManager();
        if ($critere1=='HOA')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>$critere2),array('horaireOuverture'=>'ASC'));
        }
        elseif ($critere1=='HFD')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>$critere2),array('horaireFermeture'=>'DESC'));
        }
        elseif ($critere1=='BMA')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>$critere2),array('budgetmoyen'=>'ASC'));
        }
        elseif ($critere1=='BMD')
        {
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findBy(array('type'=>$critere2),array('budgetmoyen'=>'DESC'));
        }
        else
        {
            $etablissements=$em->getRepository("MainBundle:Etablissement")->findAll();
        }
        return $this->render("MainBundle:Etablissement:Rechercher_Etablissement_Client.html.twig", array('eta'=>$etablissements,'critere'=>$critere2));
    }

    public function RechercheCNAction(Request $request,$critere2)
    {
        $em=$this->getDoctrine()->getManager();
        if ($request->isMethod('POST'))
        {
            $nom = $request->get('abc');
            $etablissements=$em->getRepository("MainBundle:Etablissement")->RechercherCNDQL($nom,$critere2);
            return $this->render("MainBundle:Etablissement:Rechercher_Etablissement_Client.html.twig", array('eta'=>$etablissements,'critere'=>$critere2));
        }
    }

    public function RechercheTAction($tag)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->RechercherT($tag);
        return $this->render("MainBundle:Etablissement:Rechercher_Etablissement_Tag.html.twig", array('eta'=>$etablissement));
    }

    public function RechercheNomAction($nom,$critere)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissements = $em->getRepository("MainBundle:Etablissement")->RechercherCNDQL($nom,$critere);
        $s=new Serializer(array(new ObjectNormalizer()));
        $e = $s->normalize($etablissements,'json');
        $response = new JsonResponse();
        return $response->setData(array('et'=>$e));
    }

    public function FiltrerCAction($critere)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissements=$em->getRepository("MainBundle:Etablissement")->FiltrerDQL($critere);
        $s=new Serializer(array(new ObjectNormalizer()));
        $e = $s->normalize($etablissements,'json');
        $response = new JsonResponse();
        return $response->setData(array('et'=>$e));
    }

    public function ratingAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MainBundle:Etablissement")->find($id);
        $r=$prod->getNbrrating();
        $form = $this->createForm(RatingTypes::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $prod->setNbruser($prod->getNbruser()+1);
            $prod->setNbrrating($prod->getRating()+$r);
            $a=($form['rating']->getData()+$r)/$prod->getNbruser();
            $prod->setRating($a);
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
        }
        return $this->render('MainBundle:Etablissement:Rating.html.twig', array('form' => $form->createView()));
    }
    public function getMineAction(){

        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $mine=$em->getRepository("MainBundle:Etablissement")->findBy(array('representant'=>$user));
        return $this->render('MainBundle:Profile:show_content_6.html.twig', array('mine' => $mine));
    }

    public function AffichageParTypeWebServiceAction($critere)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissements=$em->getRepository("MainBundle:Etablissement")->FiltrerDQL($critere);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etablissements);
        return new JsonResponse($formatted);
    }


    public function ModificationEtablissementWebServiceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Etablissement = $em->getRepository("MainBundle:Etablissement")->find($request->get('id'));
        $Etablissement->setNom($request->get('nom'));
        $Etablissement->setType($request->get('type'));
        $Etablissement->setAdresse($request->get('adresse'));
        $Etablissement->setDescription($request->get('description'));
        $Etablissement->setHoraireOuverture($request->get('horaireouverture'));
        $Etablissement->setHoraireFermeture($request->get('horairefermeture'));
        $Etablissement->setNumTel($request->get('numero'));
        $Etablissement->setImagePrincipale($request->get('image'));
        $Etablissement->setURL($request->get('url'));
        $Etablissement->setBudgetmoyen($request->get('budgetmoyen'));
        if ($Etablissement->getType() == "Restaurants/Cafés")
        {
            $Etablissement->setTypeResto($request->get('type1'));
        }
        if ($Etablissement->getType() == "Boutiques")
        {
            $Etablissement->setTypeShops($request->get('type1'));
        }
        if ($Etablissement->getType() == "Autres Etablissements")
        {
            $Etablissement->setTypeLoisirs($request->get('type1'));
        }
        if ($Etablissement->getType() == "Hotels")
        {
            $Etablissement->setNbrStars($request->get('type1'));
        }
        $em->persist($Etablissement);
        $em->flush();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($Etablissement);
        return new JsonResponse($formatted);
    }

    public function SuppressionEtablissementWebServiceAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
        $visited=$em->getRepository('MainBundle:Visited')->findBy(array('favoris'=>$etablissement));
        foreach ($visited as $in)
        {
            $em->remove($in);
            $em->flush();
        }
        $wishs=$em->getRepository('MainBundle:Wishliste')->findBy(array('favoris'=>$etablissement));
        foreach ($wishs as $in)
        {
            $em->remove($in);
            $em->flush();
        }
        $em->remove($etablissement);
        $em->flush();
        return new JsonResponse(true);
    }
    public function getMineJsonAction($id_user){

        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id_user);
        $mine=$em->getRepository("MainBundle:Etablissement")->findBy(array('representant'=>$user));

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($mine);
        return new JsonResponse($formatted);
    }

    public function EtabsWebServiceAction()
    {
        $em=$this->getDoctrine()->getManager();
        $etablissement=$em->getRepository("MainBundle:Etablissement")->findAll();
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etablissement);
        return new JsonResponse($formatted);
    }

    public function EtabNomWebServiceAction($nom)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:Etablissement")->findBy(array_filter(array(
            'nom' => $nom)));
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

}