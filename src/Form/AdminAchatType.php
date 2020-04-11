<?php

namespace App\Form;

use App\Entity\Achat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use App\Entity\Annonce;

class AdminAchatType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('buyer', EntityType::class, [
                'class' => User::class,
                'choice_label' => function($user){
                return $user->getFirstName(). " ". strtoupper($user->getLastName());
                }
            ])
           ->add('annonce', EntityType::class, [
               'class' => Annonce::class,
               'choice_label' => 'title'
           ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
