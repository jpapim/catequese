<?php
/**
 * Created by PhpStorm.
 * User: GORILLA
 * Date: 07/11/2016
 * Time: 16:29
 */

namespace TurmaCatequizando\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TurmaCatequizandoAprovacaoForm extends  AbstractForm
{
    public  function __construct($options =[])
    {
        parent::__construct('turmacatequizandoaprovacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('turmacatequizandoaprovacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo('etapa','\Etapa\Service\EtapaService','id','nm_etapa')->required(false)->label('Etapa:');
        $objForm->combo('turma','\Turma\Service\TurmaService','id','nm_turma')->required(false)->label('Turma:');
        $objForm->text('id_catequizando')->label('Catequizando');
        $objForm->text('id_turm_catequizando')->label('Turma Catequizando');
        $objForm->text('cs_aprovado')->label('cs_aprovado');
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}