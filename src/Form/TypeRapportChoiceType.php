<?php
// src/Form/TypeRapportChoiceType.php
// src/Form/TypeRapportChoiceType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeRapportChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeRapport', ChoiceType::class, [
                'label' => 'Type de rapport',
                'choices' => [
                    'Cassation avec renvoi' => 'Cassation avec renvoi',
                    'Cassation sans renvoi' => 'Cassation sans renvoi', 
                    'Rejet' => 'Rejet',
                    'Non-lieu' => 'Non-lieu'
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-select']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'rapport_choice'
        ]);
    }
}