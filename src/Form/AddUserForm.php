<?php
/**
 * Created by IntelliJ IDEA.
 * User: Etudiant
 * Date: 07/12/2017
 * Time: 09:35
 */
namespace Form;
use Model\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class,
            [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => "/[a-zA-Z]/",
                        'message' => '*Firstname is invalid, please use only letters a-z, A-Z in this field.'
                    ])
                ],
                'label' => 'Firstname'
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => "/[a-zA-Z]/",
                        'message' => '*Lastname is invalid, please use only letters a-z, A-Z in this field.'
                    ])
                ],
                'label' => 'Lastname',

            ])
            ->add('email', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Regex([
                        'pattern' => "/^[a-zA-Z0-9_.]+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",
                        'message' => '*Email is invalid, please enter a valid email adress in this field (example : some@thing.com).'
                    ])
                ]

            ])
            ->add('rolId', ChoiceType::class,
                [
                    'choices' =>
                    [
                        1 => 1,
                        2 => 2,
                        3 => 3,
                    ],
                    'choices_as_values' => true,
                    'choice_label' => function ($value, $key, $index) {
                        if ($key == 1) {
                            return "HR";
                        } elseif ($key == 2) {
                            return "Activity Manager";
                        } elseif ($key == 3) {
                            return "Collaborator";
                        }
                    },
                    'placeholder' => 3,
                    'label' => 'Role',
                    'expanded' => true,
                    'multiple' => false,
                    'data' => true
                ])
            ->add('positionName', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => "/[a-zA-Z0-9]/",
                    'message' => '*The position field is currently invalid, please do not use special characters.'
                ])
            ],
        'label' => 'Position'
        ])
        ->add('weightIni', NumberType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => 'Weight'
            ]);

        if ($options['standalone']){
            $builder->add('submit', SubmitType::class,[
                'label' => 'Soumettre'
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class',User::class);
        $resolver->setDefault('standalone', false);
        $resolver->addAllowedTypes('standalone', 'bool');
    }

}
