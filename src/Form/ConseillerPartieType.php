<?php

namespace App\Form;

use App\Entity\ConseillerPartie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConseillerPartieType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCabinet',TextType::class,$this->getConfiguration('Nom du cabinet du conseil :','Saisissez du cabinet ',['required'=>false]))
            ->add('nomAvocat',TextType::class,$this->getConfiguration('Nom du conseil :','Saisissez le nom du conseil ',['required'=>false]))
            ->add('prenomAvocat',TextType::class,$this->getConfiguration('Prénom du conseil  :','Saisissez le prenom du conseil ',['required'=>false]))
            ->add('telephone',TextType::class,$this->getConfiguration('Téléphone du conseil  :','Saisissez le numéro de téléphone du conseil ',['required'=>false]))
            ->add('email',TextType::class,$this->getConfiguration('Email du conseil  :','Saisissez le prenom du conseil ',['required'=>false]))
            ->add('adresseAvocat',TextType::class,$this->getConfiguration('Adresse du conseil  :','Saisissez l\'adresse du conseil ',['required'=>false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConseillerPartie::class,
        ]);
    }
}
