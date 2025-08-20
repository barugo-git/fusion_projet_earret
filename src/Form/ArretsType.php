<?php

namespace App\Form;

use App\Entity\Arrets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArretsType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numArret', TextType::class, $this->getConfiguration('Le numéro de l\'arrêt:', 'Entrez le munero de l\'arrêt'))

            ->add('dateArret', DateType::class, $this->getConfiguration('Date de l\'arrêt:', 'Saissez la date d\'arrêt',
                [
                    'widget' => 'single_text',
                ]))
            ->add('type', ChoiceType::class, $this->getConfiguration("La nature de l'arrêt:", "Séléctioonez la nature de l'arrets ",
                ['choices' => [
                    'Affaire classée' => 'physique',
                    'Arrêt d\'incompétence' => 'moral',
                    'Arrêt d\'irrécevabilité' => 'moral',
                    'Arrêt de cassation' => 'moral',
                    'Arrêt de décheance' => 'moral',
                    'Arrêt de désistement' => 'moral',
                    'Arret en rectification' => 'moral',
                    'Arret forclusion' => 'moral',
                    'Arret sans objet' => 'moral',
                    'Arret de  annulation' => 'moral',
                    'Arret de condamnation' => 'moral',
                    'Arret de de mise en demeure' => 'moral',
                    'Arret de plein contentieux' => 'moral',
                    'Arret de rejet' => 'moral',
                    'Contentieux  Électoral' => 'moral',
                    'Cours incompétente' => 'moral',
                    'Ordonnance PCA' => 'moral',
                    'Ordonnances PCJ' => 'moral',
                    'Ordonnances PCS' => 'moral',
                    'Reclassement' => 'moral',
                    'Recours à condamnation' => 'moral',
                    'Recours en Annulation' => 'moral',
                    'Recours en reconstitution' => 'moral',


                ],
                    'placeholder'=>'Choisissez la nature l\'arrêt'
                ]))

            ->add('titrage')
            ->add('resume', TextareaType::class, $this->getConfiguration("Résume de l'arrêt", "Saissez le résumé de l'arrêt", ['required' => true]))
            ->add('commentaire', TextareaType::class, $this->getConfiguration("Commentaires sur l'arrêt", "Saissez un commentaire sur l'arrets", ['required' => false]))
           ->add('arret_file', FileType::class, [
                'label' => 'Charger l\'arrêt',
                'multiple' => false,
                'mapped' => false,
                'required' => false

            ])
            ->add('forclusion_file', FileType::class, [
                'label' => 'Charger la forclusion',
                'multiple' => false,
                'mapped' => false,
                'required' => false

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arrets::class,
        ]);
    }
}
