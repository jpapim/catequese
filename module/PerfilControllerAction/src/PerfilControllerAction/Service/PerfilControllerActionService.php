<?php

namespace PerfilControllerAction\Service;

use \PerfilControllerAction\Entity\PerfilControllerActionEntity as Entity;

class PerfilControllerActionService extends Entity{

    public function retornaTodosPorControllerEPerfil($id_controller, $id_perfil) {

        $resultSet = NULL;

        if (( isset($id_controller) && $id_controller) && (isset($id_perfil) && $id_perfil)) {

            $resultSet = $this->select(
                [
                    'perfil_controller_action.id_controller = ? ' => $id_controller,
                    'perfil_controller_action.id_perfil = ? ' => $id_perfil
                ]
            );
        }
        return $resultSet;
    }

    //Metodo executado antes de realizar o salvamento nas tabelas.
    function preSave(){
        #$this->excluir(array('id_perfil'=> $this->getIdPerfil(),'id_controller'=>$this->getIdController()));
    }
}