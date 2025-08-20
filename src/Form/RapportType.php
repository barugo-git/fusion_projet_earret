<?php
// src/Form/RapportType.php
namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $typeRapport = $options['type_rapport'] ?? null;
        $placeholders = $options['placeholders'] ?? [];
        $fieldTypes = $options['field_types'] ?? [];
        $requiredFields = $options['required_fields'] ?? [];
        $mode = $options['mode'] ?? 'new';
    
        foreach ($placeholders as $placeholder) {
            if ($placeholder === 'moyen') {
                continue;
            }
    
            $fieldOptions = [
                'label' => ucfirst(str_replace('_', ' ', $placeholder)),
                'required' => in_array($placeholder, $requiredFields),
                'attr' => [
                    'placeholder' => 'Saisissez ' . str_replace('_', ' ', $placeholder)
                ],
                'constraints' => in_array($placeholder, $requiredFields) ? [new NotBlank()] : []
            ];
    
            // Handle different field types
            if (isset($fieldTypes[$placeholder])) {
                if (is_array($fieldTypes[$placeholder])) {
                    // For select fields
                    if (isset($fieldTypes[$placeholder]['type']) && $fieldTypes[$placeholder]['type'] === 'select') {
                        $builder->add($placeholder, ChoiceType::class, array_merge($fieldOptions, [
                            'choices' => $this->flipChoices($fieldTypes[$placeholder]['options'] ?? []),
                            'placeholder' => 'Sélectionnez une option',
                            'choice_value' => function ($value) {
                                return $value; // Store the value directly (not the key)
                            },
                        ]));
                        continue;
                    }
                } else {
                    // Handle simple field type definitions
                    switch ($fieldTypes[$placeholder]) {
                        case 'date':
                            $this->addDateField($builder, $placeholder, $fieldOptions);
                            continue 2;
                        case 'textarea':
                            $builder->add($placeholder, TextareaType::class, $fieldOptions);
                            continue 2;
                        case 'number':
                            $fieldOptions['attr']['inputmode'] = 'numeric';
                            $fieldOptions['attr']['pattern'] = '[0-9]*';
                            $builder->add($placeholder, NumberType::class, $fieldOptions);
                            continue 2;
                    }
                }
            }
    
            // Default to TextType
            $builder->add($placeholder, TextType::class, $fieldOptions);
        }
    
        // Handle moyens field for Fond type reports
        if ($typeRapport === Rapport::TYPE_FOND) {
            $builder->add('moyens', CollectionType::class, [
                'entry_type' => TextareaType::class,
                'entry_options' => [
                    'attr' => [
                        'class' => 'form-control moyen-textarea',
                        'rows' => 3,
                        'placeholder' => 'Rédigez un moyen...'
                    ],
                    'label' => false,
                    'constraints' => [new NotBlank()]
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => 'Moyens invoqués',
                'attr' => [
                    'class' => 'moyens-collection'
                ],
                'prototype_name' => '__moyen_index__',
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'Vous devez ajouter au moins un moyen'
                    ])
                ],
                'error_bubbling' => false
            ]);
        }

        // Additional validation for moyens
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($typeRapport) {
            $form = $event->getForm();
            
            if ($typeRapport === Rapport::TYPE_FOND && $form->has('moyens')) {
                $moyens = $form->get('moyens')->getData();
                if (empty($moyens)) {
                    $form->get('moyens')->addError(new FormError('Au moins un moyen doit être ajouté'));
                } else {
                    // Validate each moyen
                    foreach ($moyens as $index => $moyen) {
                        if (empty(trim($moyen))) {
                            $form->get('moyens')->addError(new FormError(sprintf('Le moyen #%d ne peut pas être vide', $index + 1)));
                        }
                    }
                }
            }
        });
    }

    private function flipChoices(array $choices): array
    {
        $flipped = [];
        foreach ($choices as $key => $value) {
            $flipped[$value] = $value; // Store value as both key and value
        }
        return $flipped;
    }

    private function addDateField(FormBuilderInterface $builder, string $name, array $options)
    {
        $builder->add($name, DateType::class, array_merge($options, [
            'widget' => 'single_text',
            'html5' => true,
            'input' => 'datetime_immutable',
            'format' => 'yyyy-MM-dd',
        ]));

        $builder->get($name)->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if ($value instanceof \DateTimeInterface) {
                    return \DateTimeImmutable::createFromInterface($value);
                }
                return $value;
            },
            function ($value) {
                return $value;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'placeholders' => [],
            'field_types' => [],
            'required_fields' => [],
            'type_rapport' => null,
            'mode' => 'new'
        ]);
    }
}