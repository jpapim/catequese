<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:55
 */

namespace PeriodoLetivo\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class PeriodoLetivoDetalheForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('detalheperiodoletivoform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalheperiodoletivoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_periodo_letivo")->required(false)->label("Id");

        $objForm->date("dt_encontro")->required(true)->setAttribute('class', 'data')->label("Data do Encontro");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 