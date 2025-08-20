<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemoireAmpliatifDossierType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateMemoireAmpliatif', DateType::class, $this->getConfiguration(
                'Date de production du memoire:',
                'Saisissez la date de production du memoire',
                [
                    'widget' => 'single_text',
                ]
            ))
            ->add('document', FileType::class, [
                'label' => 'Télécharger le memoire ampliatif',
                'multiple' => false,
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotNull(['message' => 'Vous devez uploader un fichier.']),
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier PDF valide.',
                    ]),
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