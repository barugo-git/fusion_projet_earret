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

class DossierType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referenceEnregistrement',TextType::class,$this->getConfiguration('N° enregistrement du recours','Saisser le n° d\'enregistrement du dossier du registre'))
            ->add('dateEnregistrement',DateType::class,$this->getConfiguration('Date d\'enregistrement:','Saissez le téléphone du réquerant',
            [
            'widget' => 'single_text',
                ]))
          //  ->add('typeDossier',)
            ->add('typeDossier', ChoiceType::class, $this->getConfiguration("Type de recours", "Selectioonez le type de recours ",
            ['choices' => [
                'Ordinaire' => 'ordinaire',
                'Extraodinaire'=>'extraodirnaire',
                'Autres' => 'autres',
            ]]    )
        )
         //   ->add('referenceDossier')
         //   ->add('intituleObjet')
            ->add('arreteAttaquee', TextType::class,$this->getConfiguration("Arrêt attaqué", "l’arrêt attaqué", ['required' => false]))
     //       ->add('referenceDossierComplet')
//            ->add('etatDossier')
            ->add('objet', EntityType::class, [
                'class' => Objet::class,
                'choice_label' => 'name',
                'placeholder' => "Sélectionner l’objet",
                'required' => true,
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
                ['required' => true,
                    'class' => Structure::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Sélectionner la chambre à saisir',
                    'query_builder'=>function(EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                            ->where('s.codeStructure IN (:str)')
                            ->setParameter('str',['CJ','CA'])
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
}
