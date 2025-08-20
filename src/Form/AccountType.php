<?php

namespace App\Form;

use App\Entity\User;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('nom',TextType::class,$this->getConfiguration('Nom :','Nom'))
            ->add('prenoms',TextType::class,$this->getConfiguration('Prénoms :','Prénoms......'))
            ->add('email',EmailType::class,$this->getConfiguration('Adresse mail :','Adresse mail.....'))
            ->add('telephone',TextType::class,$this->getConfiguration('Téléphone:','Entrez le numéro de téléphone'))
           // ->add('titre',TextType::class,$this->getConfiguration('Titre:','Entrez le titre'))
            ->add('titre',ChoiceType::class,[
                'multiple' => false,
                'choices' => [
                    'CONSEILLER' => 'CONSEILLER',
                    'AUDITEUR' => 'AUDITEUR',
                    'GREFFIER EN CHEF' => 'GREFFIER EN CHEF',
                    'GREFFIER' => 'GREFFIER',
                    'PRESIDENT DE LA COUR' => 'PRESIDENT DE LA COUR',
                    'PRESIDENT DE STRUCTURE'=>'PRESIDENT DE STRUCTURE',
                    'PRESIDENT DE SECTION'=>'PRESIDENT DE SECTION',
                    'AVOCAT GENERAL'=>'AVOCAT GENERAL',
                    'PROCUREUR GENERAL'=>'PROCUREUR GENERAL',
                    'AUTRES AGENTS' => 'AUTRES AGENTS'

                ],
                'label'=>'Titre de l\'utilisateur'
            ])

            // ->add('ministere')

        ;
    }


    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
