<?php

namespace ArteMarcial\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ArteMarcialForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('artemarcialform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('artemarcialform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_arte_marcial")->required(false)->label("Arte Marcial");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}