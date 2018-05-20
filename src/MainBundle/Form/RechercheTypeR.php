<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 27/02/2018
 * Time: 15:58
 */

namespace MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RechercheTypeR extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $builder->add('nom',TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('Recherche',SubmitType::class)
            ->setMethod('GET');
    }

}