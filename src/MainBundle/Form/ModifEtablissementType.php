<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 16/02/2018
 * Time: 19:05
 */

namespace MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifEtablissementType extends AbstractType
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
            ->add('typeLoisirs', ChoiceType::class, array('choices'=>array(''=>'','Cinéma'=>'Cinema','Salle De Sport'=>'Salle_De_Sport',
                "Parc D'Attraction"=>'Attraction Parc', 'Spa'=>'spa', 'Salon De Coiffure'=>'Beauty Shop', 'Salle De Jeux'=>'Salle_De_Jeux',
                'Autre'=>'Autres')))
            ->add('typeResto', ChoiceType::class, array('choices'=>array(''=>'','Restaurant'=>'Resto','Café'=>'Cafe',
                "Fast-Food"=>'Fast_Food', 'Salon De Thé'=>'Salon_De_Thé', 'Bar'=>'Bar Lounge', 'Boite De Nuit'=>'NightClub',
                'Glaciers'=>'Glacier','Autres'=>'Autre')))
            ->add('typeShops', ChoiceType::class, array('choices'=>array(''=>'','Grandes Surfaces'=>'Grande_Surface','Parfumeries'=>'Parfumerie',
                "Boutiques"=>'Boutique', 'Librairies'=>'Librairies', 'Fleuristes'=>'Fleuriste', 'Candy Shop'=>'Chocolat & Dragées',
                'Autres'=>'Autre')))
            ->add('nbrStars',ChoiceType::class, array('choices'=>array(''=>'','One'=>1,'Two'=>2,'Three'=>3,'Four'=>4,'Five'=>5)));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MainBundle\Entity\Etablissement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mainbundle_etablissement';
    }
}