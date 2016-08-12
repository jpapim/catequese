<?php

namespace SacramentoResponsavel\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SacramentoResponsavelForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('sacramentoresponsavelform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('sacramentoresponsavelform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->combo("id_sacramento", '\Sacramento\Service\SacramentoService', 'id', 'nm_sacramento')->required(true)->label("Sacramento");
        $objForm->combo("id_responsavel", '\Responsavel\Service\ResponsavelService', 'id', 'nm_responsavel')->required(true)->label("Responsavel");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}