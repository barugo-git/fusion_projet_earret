<?php

namespace App\Form;

use App\Entity\ReponseMesuresInstructions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseMesureAGType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateMiseDirective', DateType::class, $this->getConfiguration('Date d\'execution de la mesure:', 'Saissez le téléphone du réquerant',
                [
                    'widget' => 'single_text',
                ]))
            ->add('reponse', TextareaType::class, $this->getConfiguration('Actions menées en vue de l\'instruction', 'Saisissez les différentes actions menées dans le cadre de l\'execution  de la mesure', ['required' => false]))
            ->add('motif', TextareaType::class, $this->getConfiguration('Conclusion', 'Saisissez la conclusion du dossier ',[
                'mapped'=>false
            ]))
            ->add('document', FileType::class, [
                'label' => 'Envoyer votre rapport',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
//            ->add('DateNotification',DateType::class,$this->getConfiguration('Date de notification:','Saissez le téléphone du réquerant',
//                [
//                    'widget' => 'single_text',
//                    'required'=>false
//                ]))
//            ->add('reponsePartie',CheckboxType::class,$this->getConfiguration('La partie concernée a-t-elle repondu favorablement a l\'instruction:','Saissez le téléphone du réquerant'
//                ,['required'=>false]))
//            ->add('termine',CheckboxType::class,$this->getConfiguration('Fin de la mesure d\'instruction??','mesure'))

//            ->add('mesure')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReponseMesuresInstructions::class,
        ]);
    }
}
