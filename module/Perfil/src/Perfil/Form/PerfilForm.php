<?php

namespace Perfil\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PerfilForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('perfilform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('perfilform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_perfil")->required(true)->label("Perfil");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}