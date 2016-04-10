<?php

namespace EstadoCivil\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EstadoCivilForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('estadocivilform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('estadocivilform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_estado_civil")->required(false)->label("Estado civil");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}