<?php


namespace App\Form;


use App\Entity\User;
use App\Entity\UserDossier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('profil', ChoiceType::class, $this->getConfiguration("Rôle sur le dossier", "Selectioonez le sexe ",
                ['choices' => [
                    'Président' => 'president',
                    'Conseiller' => 'conseiller',
                    'Avocat général' => 'avocat general',
                    'Greffier' => 'greffier',
                    'Auditeur' => 'auditeur',
                ]]))
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner le membre',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'label'=>'Membre'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDossier::class,
        ]);
    }
}