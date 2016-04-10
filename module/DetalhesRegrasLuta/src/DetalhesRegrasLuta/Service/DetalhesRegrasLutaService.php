<?php

namespace DetalhesRegrasLuta\Service;

use \DetalhesRegrasLuta\Entity\DetalhesRegrasLutaEntity as Entity;

class DetalhesRegrasLutaService extends Entity{

    public function getDetalhesRegrasLutaToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('detalhes_regras_luta')
            ->where([
                'detalhes_regras_luta.id_detalhe_regra_luta = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * @param $id
     * @return array
     */
    public function pegarRegrasDeGraduacaoModalToArray($id) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('vw_regras_lutas')
            ->where([
                'vw_regras_lutas.id_regra_luta = ?' => $id,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($result);
        $arrayResultado = $resultSet->toArray();
        return $arrayResultado;
    }

    public function pegarRegrasDeGraduacaoModal($id) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('vw_regras_lutas')
            ->where([
                'vw_regras_lutas.id_regra_luta = ?' => $id,
            ]);

        $result = $sql->prepareStatementForSqlObject($select)->execute();
        $resultSet = new \Zend\Db\ResultSet\ResultSet();

        return $resultSet->initialize($result);
    }

}