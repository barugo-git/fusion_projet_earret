<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class MemoireAmpliatifDossierType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateMemoireAmpliatif',DateType::class,$this->getConfiguration('Date de production du memoire:','Saisissez la date de production du memoire',
                [
                    'widget' => 'single_text',
                ]))
            ->add('document',FileType::class,[
                'label' => 'Télécharger le memoire ampliatif',
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
