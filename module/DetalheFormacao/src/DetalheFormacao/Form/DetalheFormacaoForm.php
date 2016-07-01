<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 01/07/2016
 * Time: 14:39
 */

namespace DetalheFormacao\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class DetalheFormacaoForm extends  AbstractForm {

    public function __construct($options=[]){
        parent::__construct('detalheformacaoform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalheformacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_formcao")->required(false)->label("Id_formacao");
        $objForm->textarea("ds_detalhe_formacao")->required(false)->label("Detalhe Formacao");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 