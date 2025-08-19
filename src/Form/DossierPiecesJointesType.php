<?php

namespace App\Form;

use App\Entity\DossierPiecesJointes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierPiecesJointesType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,$this->getConfiguration('Nom de la piece jointe','Saissez le mon de la piece jointe'),['require'=>false])
            ->add('document',FileType::class,[
                'label' => 'Sélectionner une piece à ajouter au dossier',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DossierPiecesJointes::class,
        ]);
    }
}
