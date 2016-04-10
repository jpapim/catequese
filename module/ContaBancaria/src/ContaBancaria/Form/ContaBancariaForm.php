<?php

namespace ContaBancaria\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ContaBancariaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('contabancariaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('contabancariaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nr_agencia")->required(false)->label("Agência");  
        $objForm->text("nr_conta")->required(false)->label("Conta");  
        $objForm->combo("id_situacao", '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(true)->label("id situacao");  
        $objForm->combo("id_usuario", '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(true)->label("id usuario");  
        $objForm->combo("id_banco", '\Banco\Service\BancoService', 'id', 'nm_banco')->required(true)->label("id banco");  
        $objForm->combo("id_tipo_conta", '\TipoConta\Service\TipoContaService', 'id', 'nm_tipo_conta')->required(true)->label("id tipo conta");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}