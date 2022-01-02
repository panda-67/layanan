<?php

namespace App\Form;

use App\Entity\Layanan;
use App\Config\Kategori;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LayananType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr' => ['class' => 'mb-3'],
                'attr' => ['class' => 'form-control'],
                'help_html' => true,
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'Mapping' => 'Mapping',
                    'Statistic' => 'Statistic',
                ],
                'choice_attr' => [
                    'Mapping' => ['value' => 'Mapping'],
                    'Statistic' => ['value' => 'Statistic'],
                ],
                'placeholder' => 'Please Choose',
                'row_attr' => ['class' => 'mb-3'],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'row_attr' => ['class' => 'mb-3'],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Cover',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '512k',
                        'mimeTypes' => ['image/*'],
                        'mimeTypesMessage' => 'Please upload a valid Image File!',
                    ]),
                ],
                'help' => 'Max size 512kb',
                'attr' => ['class' => 'form-control'],
                'help_attr' => ['class' => 'text-secondary fs-6 fst-italic'],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'required' => true,
                'divisor' => 1,
                'grouping' => true,                
                'currency' => 'IDR',
                'scale' => 0,
                'help' => 'Tanpa menambahkan titik/koma',
                'row_attr' => ['class' => 'mb-3'],
                'attr' => ['class' => 'form-control'],
                'help_attr' => ['class' => 'text-secondary fs-6 fst-italic'],
                'help_html' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Layanan::class,
        ]);
    }
}
