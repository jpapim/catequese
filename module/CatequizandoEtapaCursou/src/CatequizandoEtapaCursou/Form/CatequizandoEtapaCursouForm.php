<?php

namespace CatequisandoEtapaCursou\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequisandoEtapaCursouForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('catequisandoetapacursouform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('catequisandoetapacursouform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_etapa", '\Etapa\Service\EtapaService', 'id', 'nm_etapa')->required(false)->label("Etapa");              
        $objForm->combo("id_catequisando", '\Catequisando\Service\CatequisandoService', 'id', 'nm_catequisando')->required(false)->label("Catequisando");
        $objForm->date('dt_cadastro',time('d-m-y'))->required(false)->label("Id");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
