<?php

namespace App\Form;

use App\Entity\PaiementConsignation;
use Symfony\Component\Form\AbstractType;
use App\Repository\UserDossierRepositoryRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PaiementConsignationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePaiement', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('montant', MoneyType::class, [
                'currency' => 'XOF',
                'required' => true,
            ])
            ->add('consignation', CheckboxType::class, [
                'label' => 'Consignation payée',
                'required' => false,
            ])
            ->add('modePaiement', TextType::class, [
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaiementConsignation::class,
        ]);
    }
}