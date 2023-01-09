<?php

namespace App\Form;

use App\Entity\Article;

use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=> 'titre',
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'veuillez rensegnier un putin de titre '
                    ]),
                    new Length([
                        'min'=>2,
                        'minMessage'=>'votre titre doit conptenir au moins {{ limit }} caractères',
                        'max'=>150,
                        'maxMessage'=> 'votre titre doit conptenir au maximum {{ limit }} caractères',
                    ]),

                ],
            ])
            ->add('content', TextareaType::class,[
                'label'=> 'content',
                'constraints'=>[
                    new NotBlank([
                        'message'=> 'vous devez mettre un contenu'
                    ]),
                    new Length([
                        'min'=>2,
                        'minMessage'=>'votre titre doit comptenir au moins {{ limit }} caractères',
                        'max'=>100000,
                        'maxMessage'=> 'votre titre doit comptenir au maximum {{ limit }} caractères',
                    ]),
                ],
                'attr' =>[
                    'rows'=> '8',
                ],
            ])
            ->add('save', SubmitType::class, [ // Ajout d'un champ de type bouton de validation
                'label' => 'Créer article',
                'attr' => ['class' => 'btn btn-outline-primary w-100',
                ],

            ])   // Texte du bouton
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
