<?php

namespace SituacaoResponsavelCatequisando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoResponsavelCatequisandoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('situacaoresponsavelcatequisandoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('situacaoresponsavelcatequisandoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_situacao_responsavel", '\SituacaoResponsavel\Service\SituacaoResponsavelService', 'id', 'ds_situacao_responsavel')->required(true)->label("Descriacao Responsavel");
        $objForm->combo("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(true)->label("Catequisando");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}