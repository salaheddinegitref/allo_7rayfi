<?php

namespace App\Form;

use App\Entity\Achat;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AchatType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('quantity', IntegerType::class, $this->getConfig(false ,"Combien d'article vous voulez commandez...",[
                    'attr' => [
                        'min' => 1,
                        'max' => 10
                    ]
                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
