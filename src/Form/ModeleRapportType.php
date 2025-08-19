<?php
namespace App\Form;

use App\Entity\ModeleRapport;
use App\Entity\Structure;
use App\Entity\Section;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File; 

class ModeleRapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomFichier', TextType::class, [
                'label' => 'Nom du fichier',
                'attr' => ['class' => 'form-control']
            ])
            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une structure',
                'mapped' => true,
                'attr' => ['id' => 'structure-select', 'class' => 'form-select']
            ])
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une section',
                'mapped' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'attr' => ['id' => 'section-select', 'class' => 'form-select']
            ])
            ->add('fichier', FileType::class, [
                'label' => 'Fichier (PDF ou DOCX)',
                'mapped' => false, // Permet de gérer l'upload sans setter automatique dans l'entité
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k', // Limite la taille du fichier à 1 Mo
                        'mimeTypes' => [ // Limite les types de fichiers acceptés
                            'application/pdf', // PDF
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF ou DOCX valide.', // Message d'erreur personnalisé
                    ])
                ],
            ])
            ->add('typeRapport', ChoiceType::class, [
                'label' => 'Type de rapport',
                'choices' => [
                    'Déchéance' => 'Déchéance',
                    'Forclusion' => 'Forclusion',
                    'Fond' => 'Fond',
                ],
                'placeholder' => 'Sélectionnez un type de rapport',
                'expanded' => false, 
                'multiple' => false, 
                'attr' => ['class' => 'form-select']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModeleRapport::class,
        ]);
    }
}
