<?php

namespace TurmaCatequizando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class TurmaCatequizandoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('turmacatequizandoform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('turmacatequizandoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_turma", '\Turma\Service\TurmaService', 'id', 'nm_turma')->required(false)->label("Turma");
        #TODO: MODULO CATEQUIZANDO AINDA NAO IMPLEMENTADO ->
        # TODO: $objForm->combo("id_catequizando", '\Catequizando\Service\CatequizandoService', 'id', 'nm_catequizando')->required(false)->label("catequizando");
        #$objForm->hidden("id_catequizando")->required(false)->label("Catequizando");
        $objForm->text("id_catequizando")->required(true)->label("Catequizando");

        $objForm->hidden("id_usuario")->required(false)->label("Identificacao do Usuario");
        $objForm->combo("id_periodo_letivo", '\PeriodoLetivo\Service\PeriodoLetivoService', 'id', 'dt_ano_letivo')->required(false)->label("Período Letivo");

        //#########################################################################################
        $objForm->textareaHtml("tx_observacoes")->required(true)->label("Observações");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
