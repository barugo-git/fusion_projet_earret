<?php


namespace App\Form;


use App\Entity\User;
use App\Entity\UserDossier;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'UserInformations',
                'placeholder' => 'Sélectionner le greffier',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.titre IN (:str)')
                        ->setParameter('str',["GREFFIER"])
                        ;
                },
                'label'=>'Selectionner le greffier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDossier::class,
        ]);
    }
}