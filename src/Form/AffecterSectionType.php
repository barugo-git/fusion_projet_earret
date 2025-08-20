<?php

namespace App\Form;

use App\Entity\AffecterSection;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffecterSectionType  extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAffectation', DateType::class, $this->getConfiguration('Date d\'affectation du dossier', 'saisissez la date d\'affectation du dossier ',
                [
                    'widget' => 'single_text',
                ]))
            ->add('section', EntityType::class, $this->getConfiguration('Section d\'affectation', 'Selectionner la section d\'affectation ',
                ['required' => true,
                    'class' => Section::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionner la section'

                ]
            ))
            ->add('delaiTraitement', NumberType::class, $this->getConfiguration('Delai de traitement du dossier', 'saisissez le delai du traitement (nombre de jour)',
                ))
            ->add('Motif', TextareaType::class, $this->getConfiguration('Motif d\'affectation', 'saisissez le motif  d\'affectation du dossier '))
//            ->add('dossier')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffecterSection::class,
        ]);
    }
}
