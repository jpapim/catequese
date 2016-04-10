<?php

namespace Config\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ConfigForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('configform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('configform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_config")->required(false)->label("Nome da Configuração");  
        $objForm->text("nm_valor")->required(false)->label("Valor");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}