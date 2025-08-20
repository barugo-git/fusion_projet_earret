<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequeteParPeriodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('datedebut', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'label' => 'Date de Début '
                    //  'years'=>range(1920, date('Y'))
                ]
            )
            ->add('datefin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Date de Fin '
                //  'years'=>range(1920, date('Y'))
            ])
            //->add('field_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
