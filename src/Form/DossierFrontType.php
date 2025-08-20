<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Dossier;
use App\Entity\DossierPiecesJointes;
use App\Entity\Objet;
use App\Entity\Structure;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DossierFrontType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         //   ->add('referenceDossier')
         //   ->add('intituleObjet')
            ->add('arreteAttaquee', TextType::class,$this->getConfiguration("Arrêt attaqué", "l’arrêt attaqué", ['required' => false]))
     //       ->add('referenceDossierComplet')
//            ->add('etatDossier')
            ->add('objet', EntityType::class, [
                'class' => Objet::class,
                'choice_label' => 'name',
                'placeholder' => "Sélectionner l’objet",
                'required' => false,
                'multiple' => false,
                'expanded' => false
            ])
            ->add('pieces', CollectionType::class, [
                'entry_type' => DossierPiecesJointesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => false,
                'by_reference' => false,
                'disabled' => false,

            ])
            ->add('structure', EntityType::class, $this->getConfiguration('Chambre destinataire', 'Selectionner la chambres saissie ',
                ['required' => false,
                    'class' => Structure::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionner la chambre saissie',
                    'query_builder'=>function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.codeStructure IN (:str)')
                            ->setParameter('str',['CA','CJ'])
                            ;
                    }

                ]
            ))
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'dossier';
    }
}
