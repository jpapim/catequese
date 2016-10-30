<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 22:12
 */

namespace Formacao\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class FormacaoForm extends  AbstractForm {

    public function __construct($options=[]){
        parent::__construct('formacaoform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('formacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("nm_formacao")->required(true)->label("Formação");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 