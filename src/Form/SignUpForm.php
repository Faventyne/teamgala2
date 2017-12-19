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
use Symfony\Component\Validator\Constraints as Assert;

class SignUpForm extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options){
      $builder->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'required' => true,
                    'first_options' => [
                        'label' => 'Password'
                    ],
                    'second_options' => [
                        'label' => 'Repeat password'
                    ],
                    'constraints' => [
                        new Assert\NotBlank()
                    ]
                ]
            );

        if ($options['standalone']) {
            $builder->add('submit', SubmitType::class);
        }
    }
    public function configureOptions(OptionsResolver $resolver)
      {
          $resolver->setDefault('data_class', User::class);
          $resolver->setDefault('standalone', false);

          $resolver->addAllowedTypes('standalone', 'bool');
      }
}
