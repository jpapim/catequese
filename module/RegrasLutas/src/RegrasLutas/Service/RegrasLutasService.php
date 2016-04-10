<?php

namespace RegrasLutas\Service;

use \RegrasLutas\Entity\RegrasLutasEntity as Entity;

class RegrasLutasService extends Entity{

    public function getRegrasLutasToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('regras_lutas')
            ->where([
                'regras_lutas.id_regra_luta = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /*
    public function getRegrasLutasPorParametroToArray($arrayParametros) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('regras_lutas')
            ->where([
                'regras_lutas.id_regra_luta = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
*/

}