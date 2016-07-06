<?php

namespace GrauParentesco\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class GrauParentescoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('grauparentescoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('grauparentescoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_grau_parentesco")->required(true)->label("Grau de parentesco");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}