<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    public function AjoutAction(Request $request,$id)
    {
        $tag = new Tag();
        $em=$this->getDoctrine()->getManager();
        if ($request->isMethod('POST'))
        {
            $nom = $request->get('tag');
            $tag1 = $em->getRepository("MainBundle:Tag")->findOneBy(array('name'=>$nom));
            if ($tag1!=null)
            {
                $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
                $etablissement->addTag($tag1);
                $em->flush();
            }
            else
            {
                $tag->setName($nom);
                $em->persist($tag);
                $em->flush();
                $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id);
                $etablissement->addTag($tag);
                $em->flush();
            }
        }
        return $this->redirectToRoute('Afficher_Etablissement_Client', array('id' => $id));
    }

    public function SuppAction($id,$id1)
    {
        $em=$this->getDoctrine()->getManager();
        $tag=$em->getRepository("MainBundle:Tag")->find($id);
        $etablissement=$em->getRepository("MainBundle:Etablissement")->find($id1);
        $etablissement->removeTag($tag);
        $em->flush();
        return $this->redirectToRoute('Afficher_Etablissement_Client',array('id'=>$id1));
    }


}
