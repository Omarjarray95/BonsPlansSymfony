<?php
/**
 * Created by PhpStorm.
 * User: Maissa
 * Date: 27/02/2018
 * Time: 6:14 PM
 */

namespace MainBundle\Form;


use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RatingTypes extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rating', RatingType::class, [
            'label' => 'Rating'
        ]);
    }
}