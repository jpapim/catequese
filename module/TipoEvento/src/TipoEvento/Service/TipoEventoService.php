<?php

namespace TipoEvento\Service;

use \TipoEvento\Entity\TipoEventoEntity as Entity;

class TipoEventoService extends Entity{

    public function getTipoEventoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('tipos_eventos')
            ->where([
                'tipos_eventos.id_tipo_evento = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}