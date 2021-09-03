<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CreateTaskType extends AbstractType
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('goal',TextareaType::class,[
            'attr'=>['placeholder'=>'Co muszę zrobić...','class'=>'form-control form-control-lg']
            ])
            // ->add('category',EntityType::class,[
            //     'class'=>Category::class,
            //     'label'=>false,
            //     'query_builder'=> function(EntityRepository $er)
            //     {  
            //         return $er->createQueryBuilder('c')
            //         ->innerJoin('c.user','u')
            //         ->addSelect('u')
            //         ->andWhere('u.id = :uid ')
            //         ->setParameter('uid',$this->security->getUser());
            //     },
            //     'attr'=>['class'=>'form-control form-control-lg']
            // ])
            ->add('submit',SubmitType::class,[
                'label'=>'Dodaj zadanie',
                'attr'=>['class'=>'btn btn-lg form-btn mb-3'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
