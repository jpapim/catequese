<?php

namespace FrequenciaTurma\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FrequenciaTurmaForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('frequenciaturmaform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('frequenciaturmaform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_turma_catequisando", '\TurmaCatequisando\Service\TurmaCatequisandoService', 'id')->required(false)->label("Id Turma Catequisando");
        $objForm->combo("id_detalhe_periodo_letivo", '\DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService', 'id')->required(false)->label("Id Detalhe do Período Letivo");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
