<?php

namespace Evento\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EventoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('eventoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('eventoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_tipo_evento", '\TipoEvento\Service\TipoEventoService', 'id', 'nm_tipo_evento')->required(false)->label("Tipo de Evento");
        $objForm->text("id_cidade")->required(false)->label("Cidade");
        $objForm->combo("id_regra_luta", '\RegrasLutas\Service\RegrasLutasService', 'id', 'nm_regra_luta')->required(false)->label("Regra de Luta");
        $objForm->text("nm_evento")->required(false)->label("Evento");
        $objForm->date("dt_evento")->required(true)->label("Data do Evento");
        $objForm->money("vl_inscricao_colorida")->required(true)->label("Valor Colorida");
        $objForm->money("vl_inscricao_preta")->required(true)->label("Valor Faixa Preta");

        $arrOpcoes[]=array('value'=>true, 'label'=>'Ativo');
        $arrOpcoes[]=array('value'=>false, 'label'=>'Inativo');

        $objForm->checkbox('bo_inativo', $arrOpcoes )->required(false)->label("Evento Inativo");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}