<?php

namespace Turno\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TurnoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('turnoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('turnoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_turno")->required(true)->label("Turno");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}