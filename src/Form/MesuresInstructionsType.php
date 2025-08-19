<?php

namespace App\Form;

use App\Entity\MesuresInstructions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MesuresInstructionsType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instruction')
            ->add('partiesConcernes',ChoiceType::class, $this->getConfiguration("Partie(s)", "Selectioonez les parties concernées par la mesure ",
                ['choices' => [
                    'Requérant' => 'Requérant',
                    'Défendeur'=>'Défendeur',
                    'Aux deux Parties'=>'Aux deux parties'

                ]]    ))
            ->add('delais',NumberType::class,$this->getConfiguration('Délais',"Saisir le nombre de jours "))
//            ->add('createdAt')
//            ->add('date')
//            ->add('dossier')
//            ->add('conseillerRapporteur')
//            ->add('greffier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesuresInstructions::class,
        ]);
    }
}
