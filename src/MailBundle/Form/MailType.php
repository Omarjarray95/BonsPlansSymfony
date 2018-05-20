<?php

namespace MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MailType extends AbstractType
{
/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MailBundle\Entity\Mail'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mailbundle_mail';
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('attr'=>array('class'=>'B AB')))
            ->add('prenom', TextType::class, array('attr'=>array('class'=>'B AB')))
            ->add('tel', IntegerType::class, array('attr'=>array('class'=>'B AB')))
            ->add('email', EmailType::class, array('attr'=>array('class'=>'B AB')))
            ->add('text', TextareaType::class, array('attr'=>array('class'=>'B AB')))
            ->add('Envoyer', SubmitType::class, array('attr'=>array('class'=>'B AB'))) ;
    }
    public function getName()
    {
        return 'Mail';
    }

}
