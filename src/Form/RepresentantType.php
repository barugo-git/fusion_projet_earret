<?php

namespace App\Form;

use App\Entity\Partie;
use App\Entity\Representant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepresentantType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,$this->getConfiguration('Nom du representant: ','Saisissez du representant ',['required'=>false]))
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('adresse')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Representant::class,
        ]);
    }
}
