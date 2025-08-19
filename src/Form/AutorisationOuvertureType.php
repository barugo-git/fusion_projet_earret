<?php

namespace App\Form;

use App\Entity\AffecterSection;
use App\Entity\Dossier;
use App\Entity\Section;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutorisationOuvertureType  extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('dateAutorisation', DateType::class, $this->getConfiguration('Date d\'affectation du dossier', 'saisissez la date d\'autorisation d\'ouverture  du dossier ',
                [
                    'widget' => 'single_text',
                ]))
//            ->add('section', EntityType::class, $this->getConfiguration('Section d\'affectation', 'Selectionner la section d\'affectation ',
//                ['required' => true,
//                    'class' => Section::class,
//                    'choice_label' => 'name',
//                    'placeholder' => 'Sélectionner la section',
//                    'query_builder' => function(EntityRepository $er) use ($structure) {
//                        return $er->createQueryBuilder('s')
//                            ->where('s.structure = :structure')
//                            ->setParameter('structure', $structure->getId()->toBinary());
//                    },
//
//
//
//                ]
//            ))
//            ->add('conseillerRapporteur', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'UserInformations',
//                'placeholder' => 'Choissisez le conseil rapporteur',
//                'required' => true,
//                'multiple' => false,
//                'expanded' => false,
//                'query_builder'=>function(EntityRepository $er) {
//                    return $er->createQueryBuilder('u')
//                        ->where('u.titre IN (:str)')
//                        ->setParameter('str',["CONSEILLER"])
//                        ;
//                },
//
//                'label'=>'Selectionner un conseiller rapporteur'
//            ])
//            ->add('greffier', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'UserInformations',
//                'placeholder' => 'Choissisez le greffier',
//                'required' => true,
//                'multiple' => false,
//                'query_builder'=>function(EntityRepository $er) {
//                    return $er->createQueryBuilder('u')
//                        ->where('u.titre IN (:str)')
//                        ->setParameter('str',["GREFFIER"])
//                        ;
//                },
//                'expanded' => false,
//                'label'=>'Selectioner un le greffier'
//            ])
//            ->add('delaiTraitement', NumberType::class, $this->getConfiguration('Delai de traitement du dossier', 'saisissez le delai du traitement (nombre de jour)',
//                ))
            ->add('annotation', TextareaType::class, $this->getConfiguration('Annotation ', 'saisissez le motif  d\'annotation '))
//           ->add('dossier')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,

        ]);

    }
}
