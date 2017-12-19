<?php
/**
 * Created by IntelliJ IDEA.
 * User: Etudiant
 * Date: 13/12/2017
 * Time: 17:31
 */

namespace Form;

use Model\Criterion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;

class AddActivityCriteriaForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name', TextType::class,
            [
                'label' => 'Activity name',
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('visibility', ChoiceType::class,
                [   'choices' => [
                        'Public (within the organization)' => true,
                        'Private' => false
                    ],
                    'label' => 'Visibility',
                    'expanded' => true,
                    'multiple' => false,
                    'choices_as_values' => true,
                    'data' => true
                ])

            ->add('deadline', DateTimeType::class, [
                //'format' => 'dd/MM/yyyy',
                //'placeholder' => 'dd/mm/yyyy',
                'label' => 'Grading deadline (dd/mm/yyyy)',

                'constraints' => [
                    new Assert\NotBlank(),
                    //new Assert\DateTime(['format' => 'd/m/Y'])
                ]
            ])

            ->add('gradetype', ChoiceType::class,
                [
                    'label' => 'Grading Method',
                    'choices' => [
                        'Absolute' => true,
                        'Relative' => false
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'choices_as_values' => true,
                    'data' => true

                    
                ])
            ->add('lowerbound', NumberType::class,
                [
                    'constraints' => [
                        new Assert\GreaterThanOrEqual(0)
                    ],
                    'scale' => 1,
                    'label' => 'Lowerbound'
                ])
            ->add('upperbound', NumberType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\GreaterThan('lowerbound')
                    ],
                    'scale' => 1,
                    'label' => 'Upperbound'
                ])
            ->add('step', NumberType::class,
                [
                    'constraints' => [
                        new Assert\GreaterThan(0)
                    ],
                    'scale' => 1,
                    'label' => '(Optional) Min increment'
                ])

            ->add('objectives', TextareaType::class,
                [

                    'label' => 'Activity remarks and objectives'
                ])

            ->add('weight', TextType::class,
                [
                    'disabled' => true,
                    'data' => '100%'
                ])

        ;

        if ($options['standalone']){
            $builder->add('submit', SubmitType::class,[
                'label' => 'Ajouter participants'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class',Criterion::class);
        $resolver->setDefault('standalone', false);
        $resolver->addAllowedTypes('standalone', 'bool');
    }
}