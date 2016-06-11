<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:19
 */

namespace DetalhePeriodoLetivo\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class DetalhePeriodoLetivoForm  extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('detalheperiodoletivoform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalheperiodoletivoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->text("id_periodo_letivo")
            ->setAttribute('disabled','disabled')
            ->required(false)
            ->label("ID PERIODO LETIVO");
        $objForm->date('dt_encontro')->required(true)
            ->setAttribute('class', 'data')
            ->label("Data de encontro");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 