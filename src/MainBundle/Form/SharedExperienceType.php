<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SharedExperienceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('checkInDate', DateType::class, array('label'=>'Date de visite'))
            ->add('impression',TextareaType::class,array('label' =>
        'Votre Impression','attr'=>array('style'=>'width:500px','class'=>'wysihtml5 form-control B AB','rows'=>'7')))
            ->add('sharedExperienceFile',FileType::class)
        ->add('Soumettre',SubmitType::class, array('attr'=>array('class'=>'default_btn')))
            ->setMethod('GET');;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\SharedExperience'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_sharedexperience';
    }


}
