<?php

namespace AppBundle\Form;

use AppBundle\Entity\Version;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('version', NumberType::class, array('label' => 'Version'))
            ->add('changelog', TextareaType::class, array('label' => 'Changelog'))
            ->add('file', FileType::class,
                array(
                    'label' => 'Fichier (.sk et .zip acceptés)',
                    'data_class' => null
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Version::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_version_type';
    }
}
