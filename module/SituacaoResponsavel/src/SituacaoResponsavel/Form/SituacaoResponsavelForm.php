<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 12:57
 */

namespace SituacaoResponsavel\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SituacaoResponsavelForm  extends  AbstractForm{


    public function __construct()
    {
        parent::__construct('situacaoresponsavelform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('situacaoresponsavelform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("ds_situacao_responsavel")->required(true)->label("Descrição Situação Responsável");
        $objForm->select("cs_pai_mae",array('P'=>'Pai','M'=>'Mãe'))
            #->setAttribute('style',' text-transform: uppercase')
            ->required(true)->label("Responsável");

        $this->formObject = $objForm;
    }
    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 