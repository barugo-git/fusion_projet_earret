<?php

// src/Form/ProfilePhotoUpdateType.php
namespace App\Form;

use App\Model\ProfilePhotoUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePhotoUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPhoto', FileType::class, [
                'label' => 'Nouvelle photo de profil',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfilePhotoUpdate::class,
        ]);
    }
}