<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Dossier;
use App\Entity\DossierPiecesJointes;
use App\Entity\Objet;
use App\Entity\Provenance;
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

class DossierSpecialType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referenceEnregistrement',TextType::class,$this->getConfiguration('Référence d\'enregistrement du dossier','Saisser la référence d\'enregistrement du dossier du registre'))

            ->add('dateEnregistrement',DateType::class,$this->getConfiguration('Date d\'enregistrement:','Saissez le téléphone du réquerant',
            [
            'widget' => 'single_text',
                ]))
          //  ->add('typeDossier',)
            ->add('typeDossier', ChoiceType::class, $this->getConfiguration("Type de dossier", "Selectioonez le genre ",
            ['choices' => [
                'Ordinaire' => 'ordinaire',
                'Autre' => 'autre',
            ]]    )
        )
          ->add('referenceDossier',TextType::class,$this->getConfiguration('Référence du dossier','Saisser la référence du dossier'))
         //   ->add('intituleObjet')
            ->add('intituleObjet', TextType::class,$this->getConfiguration("Intitule de l'objet", "Saissez l'intitulé de l'objet", ['required' => true]))
     //       ->add('referenceDossierComplet')
//            ->add('etatDossier')
            ->add('objet', EntityType::class, [
                'class' => Objet::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner l\'objet',
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ])
            ->add('provenance', EntityType::class, [
                'class' => Provenance::class,
                'choice_label' => 'name',
                'label'=>'Provenance du dossier',
                'placeholder' => 'Sélectionner la provenance du dossier',
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ])
//            ->add('localite', EntityType::class, [
//                'class' => Arrondissement::class,
//                'choice_label' => 'libArrond',
//                'placeholder' => 'Sélectionner l arrondissement',
//                'required' => true,
//                'multiple' => false,
//                'expanded' => false
//            ])
            ->add('requerant', RequerantType::class,[
                'label'=>false
            ])
            ->add('defendeur', DefendeurType::class,[
                'label'=>false
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
          /*  ->add('structure', EntityType::class, $this->getConfiguration('Structure d\'affectation', 'Selectionner la strucutre d\'affectation ',
                ['required' => true,
                    'class' => Structure::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionner la structure d\'affectation',
                    'query_builder'=>function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.id IN (:str)')
                            ->setParameter('str',[2,5])
                            ;
                    }

                ]
            ))*/
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
