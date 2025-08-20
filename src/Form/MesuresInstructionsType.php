<?php

namespace App\Form;

use App\Entity\Instructions;
use App\Entity\MesuresInstructions;
use App\Repository\InstructionsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MesuresInstructionsType extends ApplicationType
{
    public function __construct(private readonly InstructionsRepository $instructionsRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instruction', EntityType::class, [
                'class' => Instructions::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Sélectionnez une mesure',
                'required' => false,
                'label' => 'Instruction',
                'attr' => [
                    'class' => 'instruction-select'
                ]
            ])
            ->add('partiesConcernes', ChoiceType::class, $this->getConfiguration("Parties concernées", "Sélectionnez les parties concernées par la mesure",
                ['choices' => [
                    'Requérant' => 'Requérant',
                    'Défendeur' => 'Défendeur',
                    'Aux deux Parties' => 'Aux deux parties'
                ]]
            ))
            ->add('observations', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisissez vos observations ici...',
                    'rows' => 4
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesuresInstructions::class,
        ]);
    }
}
