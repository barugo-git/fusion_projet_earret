<?php

namespace App\Form;

use App\Entity\Audience;
use App\Entity\Dossier;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class AudienceType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer l'utilisateur connecté depuis les options du formulaire
        /** @var UserInterface|null $user */
        $user = $options['user'];
       // dd($user);
        $builder
            ->add('dateAudience',DateType::class,$this->getConfiguration('Date de programmation de l\'audience:','Saissez la date programmation de l\'audience',
                [
                    'widget' => 'single_text',
                ]))
            ->add('heureAudience',TimeType::class,$this->getConfiguration('Heure de programmation de l\'audience:','Saissez la date programmation de l\'audience',
                [
                    'input'  => 'datetime',
                    'widget' => 'choice',

                ]))
            ->add('dossiers', EntityType::class, [
                'class' => Dossier::class,
                'choice_label' =>'referenceDossier',
                'placeholder' => 'Sélectionner les dossiers à soumettre lors de l\'audience',
                'label' => 'Dossiers à soumettre lors de l\'audience',
                'query_builder' => function (EntityRepository $er) use ($user) {
                    if ($user) {
                        return $er->createQueryBuilder('d')
                            ->innerJoin('d.userDossiers', 'ud')
                            ->where('d.etatDossier = :etat')
                            ->andWhere('ud.user = :userId')
                            ->setParameter('etat', 'PRET POUR AUDIENCE')
                            ->setParameter('userId', $user->getId());
                    } else {
                        // Gérer le cas où l'utilisateur est null (peut-être une authentification requise)
                        return $er->createQueryBuilder('d')
                            ->where('1 = 0'); // Retourner une requête qui ne correspond à rien
                    }
                },
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('avisAudience',TextareaType::class,$this->getConfiguration('Avis d\'audience :','Saissez l\'avis de l\'audience',['required'=>false]))
            ->add('commentaire',TextareaType::class,$this->getConfiguration('Commentaire :','Saissez un commentaire sur l\audience',['required'=>false]))
//            ->add('dossiers',EntityType::class,[
//                'class' => Dossier::class,
//                'choice_label' =>'intituleObjet',
//                'placeholder'=>'Sélectionner la catégorie parente',
//                'required'=>false,
//                'multiple'=>true,
//                'expanded'=>true
//            ])
//            ->add('date')
//
//            ->add('dateDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audience::class,
            // Ajouter l'option 'user' pour passer l'utilisateur connecté
            'user' => null,
        ]);
    }
}
