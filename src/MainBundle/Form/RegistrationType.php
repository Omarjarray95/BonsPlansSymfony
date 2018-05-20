<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 13/02/2018
 * Time: 10:29
 */

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('sexe', ChoiceType::class, array('choices'=>array('H'=>'Homme','F'=>'Femme','Autre'=>'Je Ne Veux Pas Répondre')))
            ->add('datedenaissance', DateType::class, array('years'=>range(1902,2037,1)))
            ->add('ville')
            ->add('phone', NumberType::class)
            ->add('url', UrlType::class)
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}