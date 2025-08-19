<?php

namespace App\Form;

use App\Entity\AffecterSection;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OuvertureAffecterSectionType  extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $structure= $options['structure'];

        $builder
            ->add('dateAffectation', DateType::class, $this->getConfiguration('Date d\'affectation du dossier', 'saisissez la date d\'affectation du dossier ',
                [
                    'widget' => 'single_text',
                ]))
            ->add('section', EntityType::class, $this->getConfiguration('Section d\'affectation', 'Selectionner la section d\'affectation ',
                ['required' => true,
                    'class' => Section::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionner la section',
                    'attr' => [
                        'class' => 'linked-select',
                        'data-target' => "#ouverture_affecter_section_conseillerRapporteur",
//                        'data-source' => "/ajax/localite/section/id"


                    ],
                    'query_builder' => function(EntityRepository $er) use ($structure) {
                        return $er->createQueryBuilder('s')
                            ->where('s.structure = :structure')
                            ->setParameter('structure', $structure->getId()->toBinary());
                    },



                ]
            ))
            ->add('conseillerRapporteur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'UserInformations',
                'placeholder' => 'Choissisez le conseil rapporteur',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function(EntityRepository $er) use ($structure) {
                    return $er->createQueryBuilder('u')
                        ->where('u.titre IN (:str)')
                        ->andWhere('u.structure = :structure')
                        ->setParameter('str',["CONSEILLER"])
                        ->setParameter('structure', $structure->getId()->toBinary())
                        ;
                },

                'label'=>'Selectionner un conseiller rapporteur'
            ])
            ->add('greffier', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'UserInformations',
                'placeholder' => 'Choissisez le greffier',
                'required' => true,
                'multiple' => false,
//                'choices' => [], // Pareil pour les greffiers
                'query_builder'=>function(EntityRepository $er) use ($structure) {
                    return $er->createQueryBuilder('u')
                        ->where('u.titre IN (:str)')
                        ->andWhere('u.structure = :structure')
                        ->setParameter('str',["GREFFIER"])
                        ->setParameter('structure', $structure->getId()->toBinary())
                        ;
                },
                'expanded' => false,
                'label'=>'Selectioner un greffier'
            ]);
                    // Ajouter un écouteur d'événement pour déclencher le filtrage
//        $builder->get('section')->addEventListener(
//            FormEvents::POST_SUBMIT,
//            function (FormEvent $event) {
//                $form = $event->getForm();
//                $this->addDynamicFields($form->getParent(), $form->getData());
//            }
//        );

        $builder
            ->add('delaiTraitement', NumberType::class, $this->getConfiguration('Delai de traitement du dossier', 'saisissez le delai du traitement (nombre de jour)',
                ))
            ->add('Motif', TextareaType::class, $this->getConfiguration('Annotation ', 'saisissez le motif  d\'annotation '))
//           ->add('dossier')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffecterSection::class,

        ]);
        $resolver->setRequired('structure');
    }

    private function addDynamicFields(FormInterface $form, ?Section $section)
    {
        // Récupérer les conseillers et greffiers filtrés par section
//        $conseillers = null === $section ? [] : $section->getConseillersRapporteurs();
        $greffiers = null === $section ? [] : $section->getUsers();
//        dd($greffiers->getKeys());
        // Mettre à jour le champ 'conseillerRapporteur'
//        $form->add('conseillerRapporteur', EntityType::class, [
//            'class' => User::class,
//            'choices' => $conseillers,
//            'placeholder' => 'Choisir un conseiller',
//        ]);

        // Mettre à jour le champ 'greffier'
        $form->add('greffier', EntityType::class, [
            'class' =>User::class,
            'choices' => $greffiers,
            'placeholder' => 'Choisir un greffier',
//            'query_builder'=>function(EntityRepository $er) {
//                return $er->createQueryBuilder('u')
//                    ->where('u.titre IN (:str)')
//                    ->setParameter('str',["GREFFIER"])
//                    ;
//            },
        ]);
    }

}
