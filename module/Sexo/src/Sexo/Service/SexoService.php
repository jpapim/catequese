<?php

namespace Sexo\Service;

use \Sexo\Entity\SexoEntity as Entity;

class SexoService extends Entity{

    public function getSexoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('sexo')
            ->where([
                'sexo.id_sexo = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}