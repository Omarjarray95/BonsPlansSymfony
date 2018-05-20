<?php

namespace MainBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Time;

class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('prenom',TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('numtel',NumberType::class, array('label'=>'Numéro De Téléphone ','attr'=>array('style'=>'width:200px','class'=>'B AB')))
            ->add('nbrePersonnes', NumberType::class, array('label'=>'Nombre de personnes','attr'=>array('style'=>'width:100px','class'=>'B AB')))
            ->add('datedereservation', DateType::class, array('label'=>'Date de réservation'))
            ->add('heuredereservation', TimeType::class, array('label'=>'Heure de réservation'))
            ->add('Reserver',SubmitType::class, array('attr'=>array('class'=>'default_btn')))
            ->setMethod('GET');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_reservation';
    }


}
