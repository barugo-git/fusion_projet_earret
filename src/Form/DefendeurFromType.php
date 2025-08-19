<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Defendeur;
use App\Entity\Departement;
use App\Entity\Partie;
use App\Form\EventSubscriber\RepresantantSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefendeurFromType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('communeD',HiddenType::class,[
                'mapped'=>false
            ])
            ->add('type', ChoiceType::class, $this->getConfiguration("Type du défendeur :", "Séléctioonez le genre ",
                ['choices' => [
                    'Personne physique' => 'physique',
                    'Personne morale' => 'moral',


                ],
                'placeholder'=>'Choissez la nature du défendeur'
                ]))

            ->add('intitule',TextType::class,$this->getConfiguration('intitulé du réquerant :','Saissez l\'intitule du defendeur',['required'=>false]))

            ->add('telephone',TextType::class,$this->getConfiguration('Téléphone','Saissez le téléphone du defendeur',['required'=>false]))
            ->add('nom',TextType::class,$this->getConfiguration('Nom du defendeur','Saissez le mon du defendeur',['required'=>false]))
            ->add('prenoms',TextType::class,$this->getConfiguration('Prénoms du defendeur','Saissez les prénoms du defendeur',['required'=>false]))
            ->add('sexe', ChoiceType::class, $this->getConfiguration("Sexe contact", "Selectioonez le sexe ",
                ['choices' => [
                    'Masculin' => 'm',
                    'Féminin' => 'f',
                ]]    )
            )
//            ->add('sexe',TextType::class,$this->getConfiguration('Sexe du defendeur','Saissez le mon du defendeur'))
            ->add('email',TextType::class,$this->getConfiguration('Email du defendeur','Saissez le mail du defendeur',['required'=>false]))
            ->add('adresse',TextType::class,$this->getConfiguration('Adresse du defendeur','Saissez l adresse du defendeur',['required'=>false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partie::class,
        ]);
    }
}
