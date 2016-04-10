<?php

namespace InscricoesEvento\Service;

use \InscricoesEvento\Entity\InscricoesEventoEntity as Entity;

class InscricoesEventoService extends Entity{

    public function getInscricoesEventoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('inscricoes_evento')
            ->where([
                'inscricoes_evento.id_inscricao_evento = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchAllEventos($params) {

        $resultSet = NULL;

        if (isset($params['id_evento']) && $params['id_evento']) {

            $resultSet = $this->select(
                [
                    'inscricoes_evento.id_evento = ? ' => $params['id_evento']
                ]
            );
        }
        return $resultSet;
    }

    public function checarSeAtletaEstaInscritoNoEvento($id_atleta, $id_evento) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('inscricoes_evento')
            ->where([
                'inscricoes_evento.id_atleta = ?' => $id_atleta,
                'inscricoes_evento.id_evento = ?' => $id_evento,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}