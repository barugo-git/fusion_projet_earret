<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Dossier;
use App\Entity\DossierPiecesJointes;
use App\Entity\Objet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class OuvertureDossierType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

           ->add('referenceDossier',TextType::class,$this->getConfiguration('Référence du dossier :','Saisissez la référence du dossier',['required'=>true]))
           ->add('referenceDossierComplet',TextType::class,$this->getConfiguration('Référence du dossier complet :','Référence du dossier complet',['required'=>false]))
            ->add('intituleObjet',TextType::class,$this->getConfiguration('Nature de la decisions attaquée :','Saissisez la nature de la decision attaquée',['required'=>false]))

            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
