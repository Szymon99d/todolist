<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CreateCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName',TextType::class,[
                'attr'=>['placeholder'=>'Nazwa kategorii','maxlength'=>'25','class'=>'form-control form-control-lg'],
                
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Dodaj kategorię',
                'attr'=>['class'=>'btn btn-lg form-btn'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'validation_groups'=>['Registration'],
        ]);
    }
}
