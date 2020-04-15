<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating', IntegerType::class, $this->getConfig("Donnez votre note :", "Tapez votre note de 0 a 5",[
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                    'step'=> 1
                ]
            ]))
            ->add('content', TextareaType::class, $this->getConfig("Votre commentaire :", "Tapez votre commentaire ici..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
