<?php

namespace Academia\Service;

use \Academia\Entity\AcademiaEntity as Entity;

class AcademiaService extends Entity{

    public function fetchAllCidade($params) {

        $resultSet = NULL;

        if (isset($params['id_cidade']) && $params['id_cidade']) {

            $resultSet = $this->select(
                [
                    'academias.id_cidade = ? ' => $params['id_cidade']
                ]
            );
        }
        return $resultSet;
    }

    public function getAcademiaToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('academias')
            ->where([
                'academias.id_academia = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarAcademiaPorNomeToArray($nm_academia) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('academias')
            ->columns(array('nm_academia', 'id_cidade') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "academias.nm_academia LIKE ?" => '%'.$nm_academia.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdAcademiaPorNomeToArray($nm_academia) {

        $arNomeAcademia = explode('(', $nm_academia);
        $nm_academia = $arNomeAcademia[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('academias')
            ->columns(array('id_academia') )
            ->where([
                'academias.nm_academia = ?' => $filter->filter($nm_academia),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

}