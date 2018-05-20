<?php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class DemandeAjoutType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('type', ChoiceType::class, array('choices'=>array('Restaurants/Cafés'=>'Resto_Café','Boutique'=>'Shops','Hotels'=>'hotels',
                'Autres Etablissements'=>'Autres'),'attr'=>array('class'=>'B AB')))
            ->add('adresse', TextType::class, array('attr'=>array('style'=>'width:500px','class'=>'B AB')))
            ->add('description', TextareaType::class, array('attr'=>array('style'=>'width:500px','class'=>'wysihtml5 form-control B AB','rows'=>'7')))
            ->add('horaire_ouverture', TimeType::class, array('label'=>'Horaire','input'=>'string', 'widget'=>'single_text','attr'=>array('class'=>'B AB')))
            ->add('horaire_fermeture', TimeType::class, array('input'=>'string', 'widget'=>'single_text'))
            ->add('num_tel',NumberType::class, array('label'=>'Numéro De Téléphone ','attr'=>array('style'=>'width:200px','class'=>'B AB')))
            ->add('url', UrlType::class, array('label'=>'Site Web/Blog','attr'=>array('style'=>'width:700px','class'=>'B AB')))
            ->add('budgetmoyen', NumberType::class, array('label'=>'Budget Moyen','attr'=>array('style'=>'width:100px','class'=>'B AB')))
            ->add('image_principale', FileType::class, array('label' => 'Image Principale','attr'=>array('class'=>'B AB')))
            ->add('typeLoisirs' , ChoiceType::class, array('choices'=>array('Cinéma'=>'Cinema','Salle De Sport'=>'Salle de sport',
                "Parc D'Attraction"=>'Parc d attraction', 'Spa'=>'Spa', 'Salon De Coiffure'=>'Centre de beaute', 'Salle De Jeux'=>'Salle de jeux',
                'Autre'=>'Autre'),'attr'=>array('class'=>'B AB')));
   }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\DemandeAjout'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_demandeajout';
    }


}
