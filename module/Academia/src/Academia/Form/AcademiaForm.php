<?php

namespace Academia\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AcademiaForm extends AbstractForm{

    public function __construct($options=[]){
        parent::__construct('academiaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('academiaform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");
        $objForm->text("nm_academia")->required(false)->label("Academia");
        $objForm->text("id_cidade")->required(false)->label("Cidade");
        $objForm->text("tx_endereco")->required(false)->label("Endereço");
        $objForm->text("tx_complemento")->required(false)->label("Complemento");
        $objForm->cep("nr_cep")->required(false)->label("CEP");
        $objForm->combo("id_arte_marcial", '\ArteMarcial\Service\ArteMarcialService', 'id', 'nm_arte_marcial')->required(false)->label("Arte Marcial");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}