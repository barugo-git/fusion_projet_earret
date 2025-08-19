<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        // Génération d'un calcul simple
        $a = rand(1, 10);
        $b = rand(1, 10);
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom et Prénom(s)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre email',
                    ]),
                    new Email([
                        'message' => 'Veuillez entrer un email valide',
                    ]),
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Objet',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer l\'objet du message',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre message',
                    ]),
                ],
            ])
            ->add('captcha', TextType::class, [
                'mapped' => false,
                'label' => "Combien font $a + $b ?",
                'constraints' => new NotBlank(),
            ])
            ->add('captcha_result', HiddenType::class, [
                'mapped' => false,
                'data' => $a + $b,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([]);
    }

}