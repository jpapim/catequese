<?php

namespace Estado\Service;

use \Estado\Entity\EstadoEntity as Entity;

class EstadoService extends Entity {

    public function getEstadoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('estado')
            ->where([
                'estado.id_estado = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
}
