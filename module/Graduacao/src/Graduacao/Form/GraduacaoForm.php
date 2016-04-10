<?php

namespace Graduacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class GraduacaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('graduacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('graduacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_graduacao")->required(false)->label("Graduacao");
        $objForm->text("sg_graduacao")->required(false)->label("Sigla");

        $objForm->combo("id_estilo", '\Estilo\Service\EstiloService', 'id', 'nm_estilo')->required(false)->label("Estilo");
        $objForm->combo("id_arte_marcial", '\ArteMarcial\Service\ArteMarcialService', 'id', 'nm_arte_marcial')->required(false)->label("Arte Marcial");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}