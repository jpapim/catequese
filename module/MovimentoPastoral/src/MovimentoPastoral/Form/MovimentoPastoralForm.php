<?php

namespace MovimentoPastoral\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class MovimentoPastoralForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('movimentopastoralform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('movimentopastoralform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_movimento_pastoral")->required(true)->label("Movimentos Pastorais");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}