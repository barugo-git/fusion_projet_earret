<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class ConsignationDossierType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateConsignation',DateType::class,$this->getConfiguration('Date de paiement:','Saisissez la date de paiement de la consignation',
                [
                    'widget' => 'single_text',
                ]))
            ->add('document',FileType::class,[
                'label' => ' La quittance',
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
