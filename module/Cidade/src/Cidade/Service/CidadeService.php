<?php

namespace Cidade\Service;

use \Cidade\Entity\CidadeEntity as Entity;

class CidadeService extends Entity {

    public function fetchAllEstado($params) {

        $resultSet = NULL;

        if (isset($params['id_estado']) && $params['id_estado']) {

            $resultSet = $this->select(
                [
                    'cidade.id_estado = ? ' => $params['id_estado']
                ]
            );
        }
        return $resultSet;
    }

    public function getCidadeToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('cidade')
            ->where([
                'cidade.id_cidade = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarCidadePorNomeToArray($nm_cidade) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('cidade')
            ->columns(array('nm_cidade', 'id_estado') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "cidade.nm_cidade LIKE ?" => '%'.$nm_cidade.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdCidadePorNomeToArray($nm_cidade) {

        $arNomeDaCidade = explode('(', $nm_cidade);
        $nm_cidade = $arNomeDaCidade[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('cidade')
            ->columns(array('id_cidade') )
            ->where([
                'cidade.nm_cidade = ?' => $filter->filter($nm_cidade),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}
