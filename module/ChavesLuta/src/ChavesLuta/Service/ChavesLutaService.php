<?php

namespace ChavesLuta\Service;

use \ChavesLuta\Entity\ChavesLutaEntity as Entity;

class ChavesLutaService extends Entity{

    public function getChavesLutaToArray($id) {

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