<?php

namespace Estado\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EstadoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('estadoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('estadoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_estado")->required(false)->label("Estado");  
        $objForm->text("sg_estado")->required(false)->label("Sigla");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}