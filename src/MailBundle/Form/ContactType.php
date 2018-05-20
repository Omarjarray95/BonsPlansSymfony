<?php

namespace MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MailBundle\Entity\Contact'
        ));
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


           $builder->add('text', TextareaType::class, array('attr'=>array('class'=>'wysihtml5 form-control B AB','rows'=>'7')));
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mailbundle_contact';
    }


}
