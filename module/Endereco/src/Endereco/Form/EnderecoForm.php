<?php

namespace Endereco\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EnderecoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('enderecoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('enderecoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_logradouro")->required(false)->label("Logradouro");  
        $objForm->text("nr_numero")->required(false)->label("Número");  
        $objForm->text("nm_complemento")->required(false)->label("Complemento");  
        $objForm->text("nm_bairro")->required(false)->label("Bairro");  
        $objForm->text("nr_cep")->required(false)->label("Cep");  
        $objForm->combo("id_cidade", '\Cidade\Service\CidadeService', 'id', 'nm_cidade')->required(true)->label("Cidade");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}