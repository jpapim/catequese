<?php

namespace TurmaCatequisando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class TurmaCatequisandoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('turmacatequisandoform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('turmacatequisandoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_turma", '\Turma\Service\TurmaService', 'id', 'nm_turma')->required(false)->label("Turma");
        #TODO: MODULO CATEQUISANDO AINDA NAO IMPLEMENTADO ->
        # TODO: $objForm->combo("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(false)->label("catequisando");
        #$objForm->hidden("id_catequisando")->required(false)->label("Catequisando");
        $objForm->text("id_catequisando")->required(true)->label("Catequisando");

        $objForm->hidden("id_usuario")->required(false)->label("Identificacao do Usuario");
        $objForm->combo("id_periodo_letivo", '\PeriodoLetivo\Service\PeriodoLetivoService', 'id', 'dt_ano_letivo')->required(false)->label("Periodo Letivo");

        //#########################################################################################
        $objForm->textareaHtml("tx_observacoes")->required(true)->label("Observações");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
