<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class MemoireAmpliatifDossierType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('document', FileType::class, [
            'label' => 'Télécharger le mémoire ampliatif',
            'mapped' => false,
            'required' => true, // ce champ devient obligatoire
            'constraints' => [
                new NotNull(['message' => 'Vous devez uploader un fichier.']),
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Veuillez uploader un fichier PDF valide.',
                ])
            ],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
