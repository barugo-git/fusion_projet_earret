<?php

namespace App\Form;

use App\Entity\Dossier;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendrierType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('dossiers', EntityType::class, [
                'class' => Dossier::class,
                'choice_label' =>'intitule',
                'placeholder' => 'Sélectionnez les dossiers au rôle',
                'label' => 'Sélectionnez les dossiers au rôle',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    if ($user) {
                        return $er->createQueryBuilder('d')
                            ->innerJoin('d.affecterSection','u')
                            ->andWhere('d.statut  = :etat')
                            ->andWhere('d.calendrier is null')
                            ->andWhere('u.greffier = :greffer')
                            ->setParameter('greffer', $user->getId()->toBinary())
                            ->setParameter('etat',"Dossier au Rôle")
                            ;
                    } else {
                        // Gérer le cas où l'utilisateur est null (peut-être une authentification requise)
                        return $er->createQueryBuilder('d')
                            ->where('1 = 0'); // Retourner une requête qui ne correspond à rien
                    }
                },
                'required' => true,
                'multiple' => true,
                'expanded' => false
            ])
            ->add('calendrier', FileType::class, [
                'label' => 'Chargez le Rôle',
                'multiple' => false,
                'mapped' => false,
                'required' => false

            ])
            ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {


        $resolver->setDefaults([
            'data_class' =>null,
            'user' => null,

        ]);

    }
}
