<?php

namespace SacramentoCatequizando\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class SacramentoCatequizandoForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('sacramentocatequizandoform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('sacramentocatequizandoform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_catequizando", '\Catequizando\Service\CatequizandoService', 'id', 'nm_catequizando')->required(false)->label("Catequizando");
        $objForm->combo("id_sacramento", '\Sacramento\Service\SacramentoService', 'id', 'nm_sacramento')->required(false)->label("Sacramento");
        $objForm->combo("id_paroquia", '\Paroquia\Service\ParoquiaService', 'id', 'nm_paroquia')->required(false)->label("Paróquia");

        $arrOpcoes[] = array('value' => '', 'label' => 'Selecione...');
        $arrOpcoes[] = array('value' => 'S', 'label' => 'Sim');
        $arrOpcoes[] = array('value' => 'N', 'label' => 'Nao');
        $objForm->select("cs_comprovante_batismo", $arrOpcoes)->required(false)->label("Comprovante de Batismo");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}
