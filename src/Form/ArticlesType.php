<?php

namespace App\Form;

use App\Entity\Articles;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'placeholder' => "Écrivez le titre de l’article"
                ],

                'label' => false
            ])
            ->add('slug', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'placeholder' => "Écrivez le slug"
                ],

                'label' => false
            ])
            ->add('metaDescription', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'placeholder' => "Description pour le référencement"
                ],

                'label' => false
            ])
            ->add('content',CKEditorType::class, [
                'attr' => [
                    'class' => 'input',

                ],

                'label' => false
            ])
            ->add('imageEnAvant',FileType::class,[
                'attr' => [
                    'class' => 'inputfile',

                ],
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('legendePhotoEnAvant', TextType::class, [
                'attr' => [
                    'class' => 'input',
                    'placeholder' => "Description pour le référencement"
                ],

                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
