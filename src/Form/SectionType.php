<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeSection',TextType::class,$this->getConfiguration('Code de la section:','Entrez le code de la section'))
            ->add('name',TextType::class,$this->getConfiguration('Nom de la section:','Entrez le nom de la section'))
            ->add('structure',EntityType::class,[
                'class' => Structure::class,
                'choice_label' =>'name',
                'placeholder'=>'Sélectionner la structure parente',
                'required'=>true,
                'multiple'=>false,
                'expanded'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
        ]);
    }
}
