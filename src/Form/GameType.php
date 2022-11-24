<?php

namespace App\Form;

use App\Entity\Gamee;
use App\Entity\Playerr;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('blueForward', EntityType::class, [
                'class' => Playerr::class,
                'placeholder' => 'Del.azul',

            ])
            ->add('blueDefense', EntityType::class, [
                'class' => Playerr::class,
                'placeholder' => 'Def.azul',

            ])
            ->add('blueGols', IntegerType::class, array('attr'=> array('min' => 0, 'max' => 7) ))
            ->add('redForward', EntityType::class, [
                'class' => Playerr::class,
                'placeholder' => 'Del.rojo',

            ])
            ->add('redDefense', EntityType::class, [
                'class' => Playerr::class,
                'placeholder' => 'Def.rojo',

            ])
            ->add('redGols', IntegerType::class, array('attr'=> array('min' => 0, 'max' => 7) ) )
            ->add('file', FileType::class, [
                'label' => 'File',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '100000024k',
                        'mimeTypes' => [
                            'video/x-msvideo',
                            'video/mpeg',
                            'video/webm',
                            'video/3gpp',
                            'video/3gpp2',
                            'video/mp4'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Video',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gamee::class,
            'csrf_protection' => false
        ]);
    }
}
