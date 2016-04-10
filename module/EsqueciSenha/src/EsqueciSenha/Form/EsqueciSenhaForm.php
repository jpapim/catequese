
<?php

namespace EsqueciSenha\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EsqueciSenhaForm extends AbstractForm {

    public function __construct($options = []) {

        parent::__construct('esquecisenhaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('esquecisenhaform', $this, $this->inputFilter);

        $objForm->hidden('id')->required(false)->label('Id');
        $objForm->combo('id_usuario', '\Usuario\Service\UsuarioService', 'id', 'nm_usuario')->required(true)->label('Usuário');
        $objForm->text('tx_identificacao')->required(false)->label('Código de Identificação');
        $objForm->combo('id_situacao', '\Situacao\Service\SituacaoService', 'id', 'nm_situacao')->required(true)->label('Situação');
        $objForm->date('dt_solicitacao')->required(true)->label('Data de Solicitação');
        $objForm->date('dt_alteracao')->required(true)->label('Data de Alteração');

        $this->formObject = $objForm;
    }

    public function getInputFilter() {
        return $this->inputFilter;
    }

}
