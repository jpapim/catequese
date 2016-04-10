<?php

namespace CategoriaIdade\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CategoriaIdadeForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('categoriaidadeform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('categoriaidadeform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_categoria_idade")->required(false)->label("Categoria de Idade");
        $objForm->number("nr_sugestao_idade_inicial", 3)->required(false)->label("Sugestao de Idade Inicial");
        $objForm->number("nr_sugestao_idade_final", 3)->required(false)->label("Sugestao de Idade Final");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}