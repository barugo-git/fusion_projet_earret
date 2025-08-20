<?php

namespace App\Form;

use App\Entity\Dossier;
use App\Entity\Mouvement;
use App\Entity\Statut;
use App\Entity\User;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MouvementType extends AbstractType
{
    private $statutRepository;

    public function __construct(StatutRepository $statutRepository)
    {
        $this->statutRepository = $statutRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dossier = $options['dossier']; // On récupère le dossier passé en option


        $builder

//            ->add('user', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'id',
//            ])
//            ->add('Dossier', EntityType::class, [
//                'class' => Dossier::class,
//                'choice_label' => 'id',
//            ])
            ->add('statut', EntityType::class, [
                'class' => Statut::class,
                'choice_label' => 'libelle',  // Affiche le libellé du statut
                'label' => 'Statut',
                'choices' => $this->statutRepository->findStatutsNonAffectesAuDossier($dossier),

            ])


            ->add('dateMouvement', null, [
                'widget' => 'single_text',
                'data' => new \DateTime(),  // Par défaut, la date actuelle
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mouvement::class,
            'dossier' => null, // Ajouter l'option 'dossier'
        ]);
    }
}
