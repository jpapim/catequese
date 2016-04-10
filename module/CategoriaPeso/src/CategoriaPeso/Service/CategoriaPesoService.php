<?php

namespace CategoriaPeso\Service;

use \CategoriaPeso\Entity\CategoriaPesoEntity as Entity;

class CategoriaPesoService extends Entity{

    public function getCategoriaPesoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('categoria_peso')
            ->where([
                'categoria_peso.id_categoria_peso = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}