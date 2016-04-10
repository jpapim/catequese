<?php

namespace Banco\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class BancoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('bancoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('bancoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_banco")->required(false)->label("Banco");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}