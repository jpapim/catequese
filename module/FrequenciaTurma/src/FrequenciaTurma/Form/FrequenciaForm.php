<?php
/**
 * Created by PhpStorm.
 * User: GORILLA
 * Date: 07/11/2016
 * Time: 16:29
 */

namespace FrequenciaTurma\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FrequenciaForm extends  AbstractForm
{
    public  function __construct($options =[])
    {
        parent::__construct('frequenciaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('frequenciaform',$this,$this->inputFilter);

        $objForm->combo('etapa','\Etapa\Service\EtapaService','id','nm_etapa')->required(false)->label('Etapa:');
        $objForm->select('turma',[''=>'Selecione uma turma'])->required(false)->label('Turma:');

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}