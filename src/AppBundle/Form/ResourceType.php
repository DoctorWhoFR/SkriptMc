<?php

namespace AppBundle\Form;

use AppBundle\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom de la ressource'))
            ->add('image', TextType::class, array('label' => 'Logo de votre Ressource'))
            ->add('description', TextareaType::class, array('label' => 'Description'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Resource::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_resource_type';
    }
}
