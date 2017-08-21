<?php

namespace AppBundle\Form;

use AppBundle\Entity\Version;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Version', TextType::class, array('label' => 'Version'))
            ->add('Changelog', TextType::class, array('label' => 'Changelog'))
            ->add('File', FileType::class, array('label' => 'File'));
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
