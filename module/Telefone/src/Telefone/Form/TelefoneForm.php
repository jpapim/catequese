<?php

namespace Telefone\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TelefoneForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('telefoneform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('telefoneform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nr_ddd_telefone")->required(false)->label("ddd");  
        $objForm->text("nr_telefone")->required(false)->label("Telefone");  
        $objForm->combo("id_tipo_telefone", '\TipoTelefone\Service\TipoTelefoneService', 'id', 'nm_tipo_telefone')->required(true)->label("TipoTelefone");  
        $objForm->combo("id_situacao", '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(true)->label("Situacao");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}