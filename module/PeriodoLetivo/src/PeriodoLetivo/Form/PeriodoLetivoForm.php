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

class PeriodoLetivoForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('periodoletivoform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('periodoletivoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->date('dt_inicio')->required(true)
            ->setAttribute('class', 'data')
            ->label("Data de Inicio");
        $objForm->date("dt_fim")->required(true)->setAttribute('class', 'data')->label("Data de Termino");
        $objForm->text("dt_ano_letivo")->required(false)->label("Ano Letivo");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 