<?php

namespace CatequizandoEtapaCursou\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequizandoEtapaCursouForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('catequizandoetapacursouform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('catequizandoetapacursouform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_etapa", '\Etapa\Service\EtapaService', 'id', 'nm_etapa')->required(false)->label("Etapa");              
        $objForm->combo("id_catequizando", '\Catequizando\Service\CatequizandoService', 'id', 'nm_catequizando')->required(false)->label("Catequizando");
        $objForm->date('dt_cadastro',time('d-m-y'))->required(false)->label("Id");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
