<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType{
    
/**
     * permet d'avoir une configuration d'un champ
     *
     * @param String $label
     * @param String $placeholder
     * @param array $options
     * @return array
     */
    protected function getConfig($label, $placeholder, $options = []){
        return array_merge_recursive([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
    
}
?>