<?php

namespace CategoriaPeso\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CategoriaPesoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('categoriapesoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('categoriapesoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_categoria_peso")->required(false)->label("Categoria de Peso");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}