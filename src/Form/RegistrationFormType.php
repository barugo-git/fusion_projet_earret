<?php

namespace App\Form;

use App\Entity\Section;
use App\Entity\Structure;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom:',
                'attr' => ['placeholder' => 'Entrez le nom'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer votre nom']),
                ]
            ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prénom(s):',
                'attr' => ['placeholder' => 'Entrez les prénoms'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer vos prénoms']),
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone:',
                'attr' => ['placeholder' => 'Entrez le numéro de téléphone'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer un numéro de téléphone']),
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'attr' => ['placeholder' => 'Entrez le mail'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer un email']),
                    new Assert\Email(['message' => 'Veuillez entrer un email valide']),
                ]
            ])
            ->add('titre', ChoiceType::class, [
                'choices' => [
                    'CONSEILLER' => 'CONSEILLER',
                    'AUDITEUR' => 'AUDITEUR',
                    'GREFFIER EN CHEF' => 'GREFFIER EN CHEF',
                    'GREFFIER' => 'GREFFIER',
                    'PRESIDENT DE LA COUR' => 'PRESIDENT DE LA COUR',
                    'PRESIDENT DE STRUCTURE' => 'PRESIDENT DE STRUCTURE',
                    'PRESIDENT DE SECTION' => 'PRESIDENT DE SECTION',
                    'AVOCAT GENERAL' => 'AVOCAT GENERAL',
                    'PROCUREUR GENERAL' => 'PROCUREUR GENERAL',
                    'AUTRES AGENTS' => 'AUTRES AGENTS',
                ],
                'label' => 'Titre de l\'utilisateur',
                'placeholder' => 'Choisissez un titre',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => ['placeholder' => 'Entrez le mot de passe']
                ],
                'second_options' => [
                    'label' => 'Confirmez le mot de passe',
                    'attr' => ['placeholder' => 'Confirmez le mot de passe']
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer un mot de passe']),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'label' => 'Structure :',
                'placeholder' => 'Choisissez la structure',
                'attr' => [
                    'class' => 'linked-select',
                    'data-target' => "#registration_form_sections",
                    'data-source' => "/ajax/localite/structure/id"
                ]
            ])
            ->add('sections', EntityType::class, [
                'class' => Section::class,
                'label' => 'Section :',
                'placeholder' => 'Choisissez la section',
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'ROLE_CONSEILLER' => 'ROLE_CONSEILLER',
                    'ROLE_BUREAU_ORIENTATION' => 'ROLE_BUREAU_ORIENTATION',
                    'ROLE_GREFFIER' => 'ROLE_GREFFIER',
                    'ROLE_GREFFIER_EN_CHEF' => 'ROLE_GREFFIER_EN_CHEF',
                    'ROLE_PCA' => 'ROLE_PCA',
                    'ROLE_PCJ' => 'ROLE_PCJ',
                    'ROLE_PCS' => 'ROLE_PCS',
                    'ROLE_PROCUREUR_GENERAL' => 'ROLE_PROCUREUR_GENERAL',
                    'ROLE_AVOCAT_GENERAL' => 'ROLE_AVOCAT_GENERAL',
                    'ROLE_PRESIDENT_DE_STRUCTURE' => 'ROLE_PRESIDENT_DE_STRUCTURE',
                    'ROLE_PRESIDENT_DE_SECTION' => 'ROLE_PRESIDENT_DE_SECTION',
                ],
                'label' => 'Rôle de l\'utilisateur',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
