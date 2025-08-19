<?php

namespace App\Form;

use App\Entity\Structure;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateUserFormType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,$this->getConfiguration('Nom:','Entrez le nom'))
            ->add('prenoms',TextType::class,$this->getConfiguration('Prénom(s):','Entrez les prenoms'))
            ->add('telephone',TextType::class,$this->getConfiguration('Téléphone:','Entrez le numéro de téléphone'))
            ->add('email',TextType::class,$this->getConfiguration('Email:','Entrez le mail'))
            ->add('titre',TextType::class,$this->getConfiguration('Titre:','Entrez le titre'))
            ->add('structure', EntityType::class,[
                'class'=>Structure::class,
                'label'=>"Structure :",
                'placeholder'=>"Choisissez la struture"
            ])
            ->add('roles',ChoiceType::class,[
                'multiple' => true,
                'choices' => [
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_CONSEILLER' => 'ROLE_CONSEILLER',
                    'ROLE_SUPERVISEUR' => 'ROLE_SUPERVISEUR',
                    'ROLE_BUREAU_ORIENTATION' => 'ROLE_BUREAU_ORIENTATION',
                    'ROLE_GREFFIER' => 'ROLE_GREFFIER',
                    'ROLE_GREFFIER_EN_CHEF' => 'ROLE_GREFFIER_EN_CHEF',
                    'ROLE_PCA'=>'ROLE_PCA',
                    'ROLE_PCJ'=>'ROLE_PCJ',
                    'ROLE_PCS'=>'ROLE_PCS',
                    'ROLE_PROCUREUR_GENERAL'=>'ROLE_PROCUREUR_GENERAL',
                    'ROLE_AVOCAT_GENERAL'=>'ROLE_AVOCAT_GENERAL',
                    'ROLE_PRESIDENT_DE_STRUCTURE'=>'ROLE_PRESIDENT_DE_STRUCTURE',
                    'ROLE_PRESIDENT_DE_SECTION'=>'ROLE_PRESIDENT_DE_SECTION',






                ],
                'label'=>'Rôle de l\'utilisateur'
            ])

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
//                'mapped' => false,
//                'attr' => ['autocomplete' => 'new-password'],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'Please enter a password',
//                    ]),
//                    new Length([
//                        'min' => 6,
//                        'minMessage' => 'Your password should be at least {{ limit }} characters',
//                        // max length allowed by Symfony for security reasons
//                        'max' => 4096,
//                    ]),
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
