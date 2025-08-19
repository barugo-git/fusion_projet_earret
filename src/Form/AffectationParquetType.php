<?php

namespace App\Form;

use App\Entity\Dossier;
use App\Entity\User;
use App\Entity\UserDossier;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationParquetType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'UserInformations',
                'placeholder' => "Sélectionner l'avocat général",
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'query_builder'=>function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.titre IN (:str)')
                        ->setParameter('str',["AVOCAT GENERAL"])
                        ;
                },
                'label'=>"Selectionner l'avocat général"
            ])
           ->add('mesure',MesuresInstructionsPAGType::class,[
               'mapped'=>false,
           ])
        //->add('delai',NumberType::class,$this->getConfiguration('Délai','Saisir le nombre de jour'))
        //->add('instructions',TextareaType::class,$this->getConfiguration('Instructions:','Saisir l\'instruction'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDossier::class,
        ]);
    }
}
