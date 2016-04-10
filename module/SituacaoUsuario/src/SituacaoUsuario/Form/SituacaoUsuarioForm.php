<?php

namespace SituacaoUsuario\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoUsuarioForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('situacaousuarioform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('situacaousuarioform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_situacao_usuario")->required(false)->label("Situação usuário");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}