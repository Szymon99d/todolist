<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label'=>'Nazwa użytkownika',
                'attr'=>['placeholder'=>'Nazwa użytkownika','class'=>'form-control form-control-lg'],
            ])
            ->add('email',EmailType::class,[
                'label'=>'E-mail',
                'attr'=>['placeholder'=>'Adres email','class'=>'form-control form-control-lg'],
            ])
            ->add('password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_name'=>'pass',
                'second_name'=>'repeatPass',
                'first_options'=>['label'=>'Podaj hasło','attr'=>['placeholder'=>'Podaj hasło','class'=>'form-control form-control-lg']],
                'second_options'=>['label'=>'Powtórz hasło','attr'=>['placeholder'=>'Powtórz hasło','class'=>'form-control form-control-lg']],
            ])
            ->add('register',SubmitType::class,[
                'label'=>'Zarejestruj się',
                'attr'=>['class'=>'btn btn-lg form-btn'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
