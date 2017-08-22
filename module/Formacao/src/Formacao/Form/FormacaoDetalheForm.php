<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:55
 */


namespace Formacao\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class PeriodoLetivoDetalheForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('formacaodetalheform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('formacaodetalheform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_formacao")->required(false)->label("ID FORMAÇÃO");

        $objForm->text("ds_detalhe_formacao")->required(true)->label("Detalhe Formação");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 