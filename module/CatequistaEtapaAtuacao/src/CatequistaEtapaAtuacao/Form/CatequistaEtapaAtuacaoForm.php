<?php

namespace CatequistaEtapaAtuacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;


class CatequistaEtapaAtuacaoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('catequistaetapaatuacaoform');

        $this->inputFilter = new InputFilter();


        $objForm = new FormObject('catequistaetapaatuacaoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_etapa", '\Etapa\Service\EtapaService', 'id', 'nm_etapa')->required(false)->label("Etapa");              
        $objForm->combo("id_catequista", '\Catequista\Service\CatequistaService', 'id', 'nm_catequista')->required(false)->label("Catequista");
        $objForm->date('dt_cadastro',time())->required(false)->label("data");
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
