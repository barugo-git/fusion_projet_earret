<?php

namespace App\Form;

use App\Entity\ReponseMesuresInstructions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseMesureType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateMiseDirective',DateType::class,$this->getConfiguration('Date d\'execution de la mesure:','Saissez le téléphone du réquerant',
                [
                    'widget' => 'single_text',
                ]))
            ->add('reponse',TextareaType::class,$this->getConfiguration('Actions menées','Saisisser les différentes actions menées dans le cadre de l\'execution  de la mesure',['required'=>false]))

            ->add('DateNotification',DateType::class,$this->getConfiguration('Date de notification:','Saissez le téléphone du réquerant',
                [
                    'widget' => 'single_text',
                    'required'=>false
                ]))
            ->add('reponsePartie',CheckboxType::class,$this->getConfiguration('La partie concernée a-t-elle repondu favorablement a l\'instruction:','Saissez le téléphone du réquerant'
                ,['required'=>false]))
            ->add('termine',CheckboxType::class,$this->getConfiguration('Fin de la mesure d\'instruction??','mesure'))
            ->add('pieces', CollectionType::class, [
                'entry_type' => DossierPiecesJointesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => false,
                'by_reference' => false,
                'disabled' => false,
                'mapped'=>false

            ])
//            ->add('mesure')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseMesuresInstructions::class,
        ]);
    }
}
