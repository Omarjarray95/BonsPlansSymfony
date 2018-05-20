<?php

namespace MainBundle\Controller;
use MailBundle\Entity\Mail;
use MainBundle\Entity\Test;
use MainBundle\Entity\Wishliste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class WishlistController extends Controller
{
    public function checkWishAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $etabId = $request->get('id');
            $user = $this->getUser();


            $em = $this->getDoctrine()->getManager();
            $etab = $em->getRepository("MainBundle:Etablissement")->find($etabId);
            $favourite = $em->getRepository("MainBundle:Wishliste")->isWished($etab, $user);
            $response = array('alreadyWish' => true);
            if (count($favourite) == 0) {
                $response = array('alreadyWish' => false);
            }


            return new JsonResponse($response);
        }

        return new JsonResponse();
    }
    public function deleteWishAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $wish = $em->getRepository("MainBundle:Wishliste")->findOneBy(['user' => $user , 'favoris' => $id]);
        $em->remove($wish);
        $em->flush();

        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }
    public function deleteWishJsonAction($id_etab,$id_user)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id_user);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $wish = $em->getRepository("MainBundle:Wishliste")->findOneBy(['user' => $user , 'favoris' => $id_etab]);
        $em->remove($wish);
        $em->flush();


        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }
    public function checkWishJsonAction($id_etab,$id_user)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id_user);
        $etab=$em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $wish = $em->getRepository("MainBundle:Wishliste")->findOneBy(['user' => $user , 'favoris' => $id_etab]);
        $exist = $em->getRepository("MainBundle:Wishliste")->countWishliste($etab, $user);
        $test=new Test();
        $test->setId(0);
        $test->setValeur($exist);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }

    public function addWishAjaxAction(Request $request, $id)
    {
        $user = $this->getUser();
        $id_user = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id);
        $exist = $em->getRepository("MainBundle:Wishliste")->countWishliste($etab, $user);
        if ($exist == 0) {
            $Wishlist = new Wishliste();
            $Wishlist->setUser($user);
            $Wishlist->setFavoris($etab);
            $em->persist($Wishlist);
            $em->flush();

        }

        $response = array('alreadyVisited' => true);


        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }
    public function addWishJsonAction( $id_etab,$id_user)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository("MainBundle:User")->find($id_user);
        $etab = $em->getRepository("MainBundle:Etablissement")->find($id_etab);
        $exist = $em->getRepository("MainBundle:Wishliste")->countWishliste($etab, $user);

            $Wishlist = new Wishliste();
            $Wishlist->setUser($user);
            $Wishlist->setFavoris($etab);
            $em->persist($Wishlist);
            $em->flush();

        $response = array('alreadyVisited' => true);

        $e = new ObjectNormalizer();
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($etab);
        return new JsonResponse($formatted);
    }


    public function AfficheWishAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $wishlist = $em->getRepository("MainBundle:Wishliste")->findBy(array('user' => $user));


        return $this->render('MainBundle:Profile:show_content_3.html.twig',
            array(
                'wishes' => $wishlist
            ));
    }

    private function transform(Wishliste $wishliste)
    {
        return "True.0";
    }

    public function getWishListAction()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $wishlist = $em->getRepository("MainBundle:Wishliste")->findBy(array('user' => $user));


        return new JsonResponse($this->transform($wishlist));
    }


    public function getWishAction(Request $request)
    {

        return $this->render('@Main/Wishlist/show_whishlist.html.twig', array());
    }
    public function AfficheLikesJsonAction($id_user)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("MainBundle:User")->find($id_user);
        $wishes = $em->getRepository("MainBundle:Wishliste")->findBy(array('user' => $user));

        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($wishes);
        return new JsonResponse($formatted);
    }
    public function countJsonAction($id_etab)
    {


        $em = $this->getDoctrine()->getManager();
        $wishes = $em->getRepository("MainBundle:Wishliste")->findBy(array('favoris' => $id_etab));
        $test=new Test();
        $nb=count($wishes);
        $test->setValeur($nb);
        $test->setId(0);
        $e = new ObjectNormalizer();
        $e->setCircularReferenceHandler(function ($object)
        {
            return $object;
        });
        $serializer = new Serializer([$e]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }

}
