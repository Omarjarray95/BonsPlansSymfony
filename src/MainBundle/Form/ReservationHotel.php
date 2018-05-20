<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 25/02/2018
 * Time: 19:42
 */

namespace MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReservationHotel extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('prenom',TextType::class, array('attr'=>array('style'=>'width:300px','class'=>'B AB')))
            ->add('numtel',NumberType::class, array('label'=>'Numéro De Téléphone ','attr'=>array('style'=>'width:200px','class'=>'B AB')))
            ->add('nbreChambres', NumberType::class, array('label'=>'Nombre de chambres','attr'=>array('style'=>'width:100px','class'=>'B AB')))
            ->add('nbreAdultes', NumberType::class, array('label'=>'Nombre Adultes','attr'=>array('style'=>'width:100px','class'=>'B AB')))
            ->add('nbreEnfants', NumberType::class, array('label'=>'Nombre Enfants','attr'=>array('style'=>'width:100px','class'=>'B AB')))
            ->add('arrivee', DateType::class, array('label'=>'Date Arrivée'))
            ->add('depart', DateType::class, array('label'=>'Date de départ'))
            ->add('Reserver',SubmitType::class)
            ->setMethod('GET');
    }

}