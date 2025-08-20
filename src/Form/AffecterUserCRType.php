<?php

namespace App\Form;

use App\Entity\AffecterUser;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffecterUserCRType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAffection', DateType::class, $this->getConfiguration('Date d\'affectation du dossier', 'Saissez la date d\'affectation du dossier ',
                [
                    'widget' => 'single_text',
                ]))
//            ->add('destinataire', EntityType::class, $this->getConfiguration('Sélectionner le destinataire', 'Selectionner le destinataire',
//                ['required' => true,
//                    'class' => User::class,
//                    'multiple' => false,
//                    'choice_label' => 'UserInformations',
//                    'placeholder' => 'Sélectionner le destinataire ',
//                    'query_builder'=>function(EntityRepository $er) {
//                        return $er->createQueryBuilder('u')
//                            ->where('u.titre IN (:str)')
//                            ->setParameter('str',["GREFFIER"])
//                            ;
//                    }
//
//                ]
//            ))


            ->add('motif', TextareaType::class, $this->getConfiguration('Motif d\'affectation', 'Saissez le motif  d\'affectation du dossier '))

           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AffecterUser::class,
        ]);
    }
}
