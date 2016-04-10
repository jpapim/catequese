<?php

namespace Evento\Service;

use \Evento\Entity\EventoEntity as Entity;

class EventoService extends Entity{

    public function getEventoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('eventos')
            ->where([
                'eventos.id_evento = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchAllEventosAtivosToArray() {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('eventos')
            ->where([
                'eventos.bo_inativo = ?' => false,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($result);
        $arrayResultado = $resultSet->toArray();
        return $arrayResultado;
    }

    public function fetchAllEventosAtivos() {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('eventos')
            ->where([
                'eventos.bo_inativo = ?' => false,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();

        return $resultSet->initialize($result);
    }
}



