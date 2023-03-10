<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //Champ photo
            ->add('photo', FileType::class, [
                'label' => 'Selectionnez une nouvelle photo',
                'attr' => [
                    'accept' =>  'image/jpeg,image/png'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez sélectionner un fichier',
                    ]),
                    new File([
                        'maxSize' => '5m',
                        'maxSizeMessage' => 'votre fichier est trop lourd! 5mo max',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                    ])
                ]
            ])

            //Bouton de validation
            ->add('save', SubmitType::class, [
                'label' => 'Changer la photo',
                'attr' => [
                    'class' => 'btn btn-outline-primary w-100'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
