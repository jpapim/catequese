<?php

namespace Sexo\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SexoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('sexoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('sexoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_sexo")->required(true)->label("Sexo");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}