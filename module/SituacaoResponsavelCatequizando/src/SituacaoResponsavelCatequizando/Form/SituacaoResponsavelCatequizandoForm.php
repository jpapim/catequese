<?php

namespace SituacaoResponsavelCatequizando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoResponsavelCatequizandoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('situacaoresponsavelcatequizandoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('situacaoresponsavelcatequizandoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_situacao_responsavel", '\SituacaoResponsavel\Service\SituacaoResponsavelService', 'id', 'ds_situacao_responsavel')->required(true)->label("Descriacao Responsavel");
        $objForm->combo("id_catequizando", '\Catequizando\Service\CatequizandoService', 'id', 'nm_catequizando')->required(true)->label("Catequizando");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}