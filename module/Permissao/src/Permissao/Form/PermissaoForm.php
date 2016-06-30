<?php

namespace Permissao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PermissaoForm extends AbstractForm
{
    public function __construct($options = [])
    {
        parent::__construct('permissaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('permissaoform', $this, $this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService', 'id', 'nm_perfil')->required(false)->label("Selecionar Perfil");

        $objForm->combo("id_modulo", '\Controller\Service\ControllerService', 'id', 'nm_modulo')->required(false)->label("Selecione o Modulo");

        if (isset($options['acoes'])) {
            #Carrego Todos Os Actions existentes na Tabela de Controle por Controller e Perfil
            #$obPerfilControllerAction = new \PerfilControllerAction\Service\PerfilControllerActionService();
            #$colecaoActionsControle = $obPerfilControllerAction->retornaTodosPorControllerEPerfil($options['id_controller'], $options['id_perfil']);
            #$arrActions = [];
            #foreach ($colecaoActionsControle as $key => $ob_action_controle) {
            #    $arrActions[] = $ob_action_controle->getIdAction();
            #}

            #carrego aqui todos os Actions existentes na base de dados e marco somente as que ja possuem permissao
            $obAction = new \Action\Service\ActionService();
            $colecaoActions = $obAction->fetchAll();
            $arrTodasActions= [];
            foreach ($colecaoActions as $key => $ob_action) {
                $arrTodasActions[] = [
                    'value' => $ob_action->getId(),
                    'id' => 'id_action' . $key,
                    'label' => $ob_action->getNmAction(),
                    'selected' => in_array($ob_action->getId(), $options['acoes']) ? true : false,
                ];
            }
            $objForm->multicheckbox('id_action', $arrTodasActions)->required(false)->label('Marque as açoes disponiveis ao Pefil e Módulo:');
        }
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}