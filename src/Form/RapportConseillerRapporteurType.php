<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class RapportConseillerRapporteurType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rapportDescriptionCR',TextareaType::class, [
                'label' => 'Résumé ou description du rapport de conseiller'
                ])
            ->add('document',FileType::class,[
                'label' => 'Televerser le rapport',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])

            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
