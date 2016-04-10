<?php

namespace Estilo\Service;

use \Estilo\Entity\EstiloEntity as Entity;

class EstiloService extends Entity{

    public function getEstiloToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('estilos')
            ->where([
                'estilos.id_estilo = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
/*
    public function fetchAllEstilo($id) {

        $resultSet = NULL;

        if (isset($id) && $id) {

            $resultSet = $this->select(
                [
                    'estilos.id_estilo = ? ' => $id
                ]
            );
        }
        return $resultSet;
    }
*/

}