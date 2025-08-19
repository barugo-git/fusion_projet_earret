<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Defendeur;
use App\Entity\Departement;
use App\Entity\Partie;
use App\Form\EventSubscriber\RepresantantSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefendeurType extends  ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('communeD',HiddenType::class,[
                'mapped'=>false
            ])
            ->add('type', ChoiceType::class, $this->getConfiguration("Type du défendeur :", "Séléctioonez le genre ",
                ['choices' => [
                    'Personne physique' => 'physique',
                    'Personne morale' => 'moral',


                ],
                'placeholder'=>'Choissez la nature du défendeur'
                ]))

            ->add('intitule',TextType::class,$this->getConfiguration('intitulé du réquerant :','Saissez l\'intitule du defendeur',['required'=>false]))

            ->add('telephone',TextType::class,$this->getConfiguration('Téléphone','Saissez le téléphone du defendeur'))
            ->add('nom',TextType::class,$this->getConfiguration('Nom du defendeur','Saissez le mon du defendeur',['required'=>false]))
            ->add('prenoms',TextType::class,$this->getConfiguration('Prénoms du defendeur','Saissez les prénoms du defendeur',['required'=>false]))
            ->add('sexe', ChoiceType::class, $this->getConfiguration("Sexe contact", "Selectioonez le sexe ",
                ['choices' => [
                    'Masculin' => 'm',
                    'Féminin' => 'f',
                ]]    )
            )
//            ->add('sexe',TextType::class,$this->getConfiguration('Sexe du defendeur','Saissez le mon du defendeur'))
            ->add('email',TextType::class,$this->getConfiguration('Email du defendeur','Saissez le mail du defendeur'))
            ->add('adresse',TextType::class,$this->getConfiguration('Adresse du defendeur','Saissez l adresse du defendeur'))
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'libDep',
                'placeholder' => 'Sélectionner le département',
                'required' => false,
                'mapped' => false,
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'linked-select',
                    'data-target' => "#commune",
                    'data-source' => "/ajax/localite/commune/id"


                ]
            ])
           ->add('conseiller', CollectionType::class, [
               'entry_type' => ConseillerPartieType::class,
               'allow_add' => true,
               'allow_delete' => true,
               'required' => false,
               'label' => false,
               'by_reference' => false,
               'disabled' => false,

           ]);

     //   $builder->addEventSubscriber(new RepresantantSubscriber());
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

               // if (isset($data['type']) && $data['type'] === 'moral') {
                    if ($data instanceof Partie && $data->getType() === 'moral') {
                    $form->add('representants1', RepresentantType::class, [
                        'mapped' => false,
                        'label' => false,
                        'required' => false,
                    ]);
                }
            }
        );
        $type = $builder->get('type')->getData();
        $formModifier = function (FormInterface $form, $type): void {
            if ($type === 'moral') {
                $form->add('representants1', RepresentantType::class, [
                    'mapped' => false,
                    'label' => false,
                    'required' => false,

                ]);
            }
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier): void {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                if ($data === 'moral') {
                    $formModifier($event->getForm(), $data);
                }
            }
        );

        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier): void {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $sport = $event->getForm()->getData();


                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback function!
                $formModifier($event->getForm()->getParent(), $sport);
            }
        );
        $builder->setAction($options['action']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partie::class,
        ]);
    }
}
