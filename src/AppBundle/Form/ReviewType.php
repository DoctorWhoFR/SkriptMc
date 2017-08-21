<?php

namespace AppBundle\Form;

use AppBundle\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array('label' => 'Votre Review'))
            ->add('note', TextType::class, array('label' => 'Votre Note'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Review::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_review_type';
    }
}