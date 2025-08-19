<?php

namespace App\Form;

use App\Entity\Arrondissement;
use App\Entity\Departement;
use App\Entity\Partie;
use App\Entity\Requerant;
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

class RequerantType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('communeR', HiddenType::class, [
                'mapped' => false
            ])
            ->add('type', ChoiceType::class, $this->getConfiguration("Type du requérant :", "Sélectionnez le genre ",
                ['choices' => [
                    'Personne physique' => 'physique',
                    'Personne morale' => 'moral',


                ],
                    'placeholder' => 'Choisissez le type du requérant'
                ]))
            ->add('intitule', TextType::class, $this->getConfiguration('Dénomination du requérant :', 'Saisissez la Dénomination du requérant', ['required' => false]))
            ->add('Telephone', TextType::class, $this->getConfiguration('Téléphone du requérant :', 'Saisissez le téléphone du requérant'))
            ->add('nom', TextType::class, $this->getConfiguration('Nom du requérant :', 'Saisissez le téléphone du requérant', ['required' => false]))
            ->add('prenoms', TextType::class, $this->getConfiguration('Prénom(s) du requérant :', 'Saisissez le prénom du requérant', ['required' => false]))
            ->add('sexe', ChoiceType::class, $this->getConfiguration("Sexe du requérant :", "Sélectionnez le genre ",
                ['choices' => [
                    'Masculin' => 'm',
                    'féminin' => 'f',

                ]]))
            ->add('email', TextType::class, $this->getConfiguration('Le mail du requérant :', 'Saisissez le mail du requérant'))
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
            ->add('adresse', TextType::class, $this->getConfiguration('Adresse du requérant :', 'Saisissez l\'adresse du requérant'))
//            ->add('localite', EntityType::class, [
//                'class' => Arrondissement::class,
//                'choice_label' => 'libArrond',
//                'placeholder' => 'Sélectionner l arrondissement',
//                'required' => true,
//                'multiple' => false,
//                'expanded' => false
//            ])
            ->add('conseiller', CollectionType::class, [
                'entry_type' => ConseillerPartieType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => false,
                'by_reference' => false,
                'disabled' => false,

            ]);

//        $builder->get('type')->addEventListener(
//            FormEvents::PRE_SUBMIT,
//            function (FormEvent $event) {
//                $form = $event->getForm();
//                $data = $event->getData();
//
//                // Si l'option "Représentant" est sélectionnée, ajoutez le sous-formulaire
//                if ($data === 'moral') {
//                    $form->getParent()->add('representants', CollectionType::class, [
//                        'entry_type' => RepresentantType::class,
//                        'allow_add' => true,
//                        'allow_delete' => true,
//                        'by_reference' => false,
//                    ]);
//                }
//            }
//        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partie::class,
        ]);
    }
}
