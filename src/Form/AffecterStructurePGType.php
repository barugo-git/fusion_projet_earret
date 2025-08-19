<?php

namespace App\Form;

use App\Entity\AffecterStructure;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffecterStructurePGType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('structure', EntityType::class, $this->getConfiguration('Structure d\'affectation', 'Selectionner la strucutre d\'affectation ',
//                ['required' => true,
//                    'class' => Structure::class,
//                    'choice_label' => 'name',
//                    'placeholder' => 'Sélectionner la structure '
//
//                ]
//            ))
            ->add('dateAffection', DateType::class, $this->getConfiguration('Date d\'affectation du dossier', 'Saissez la date d\'affectation du dossier ',
                [
                    'widget' => 'single_text',
                ]))

//            ->add('delaiTraitement', DateType::class, $this->getConfiguration('Date limite de traitement du dossier', 'Saissez la date limite de traitement du dossier',
//                [
//                    'widget' => 'single_text',
//                ]))
            ->add('motif', TextareaType::class, $this->getConfiguration('Motif d\'affectation', 'Saissez le motif  d\'affectation du dossier '))
//            ->add('dossier', EntityType::class, $this->getConfiguration('Dossier', 'Saissez la date d\'affectation du dossier ',
//                ['required' => true,
//                    'class' => Dossier::class,
//                    'choice_label' => 'referenceDossier',
//                    'placeholder' => 'Sélectionner le dossier a affecter',
//                    "query_builder" => function (EntityRepository $er) {
//                        return $er->createQueryBuilder('c')
//                            ->where('c.etatDossier = :val')
//                            ->setParameter('val', 'OUVERT');
//                    },
//                ]
//            ))
//            ->add('structure', EntityType::class, $this->getConfiguration('Structure d\'affectation', 'Selectionner la strucutre d\'affectation ',
//                ['required' => true,
//                    'class' => Structure::class,
//                    'choice_label' => 'name',
//                    'placeholder' => 'Sélectionner la structure '
//
//                ]
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffecterStructure::class,
        ]);
    }
}
