<?php

namespace Paroquia\Service;

use Paroquia\Entity\ParoquiaEntity as Entity;
use Paroquia\Table\ParoquiaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ParoquiaService extends Entity
{

    public function getParoquiaToArray($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('paroquias')
            ->where([
                'paroquias.id_paroquia = ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarParoquiaPorNomeToArray($nm_paroquia)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('paroquias')
            ->columns(array('nm_paroquia', 'id_cidade'))#Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "paroquias.nm_paroquia LIKE ?" => '%' . $nm_paroquia . '%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdParoquiaPorNomeToArray($nm_paroquia)
    {
        $arNomeParoquia = explode('(', $nm_paroquia);
        $nm_paroquia = $arNomeParoquia[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('paroquias')
            ->columns(array('id_paroquia', 'id_cidade'))
            ->where([
                "paroquias.nm_paroquia LIKE ?" => '%' . $nm_paroquia . '%',
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_paroquia ASC', $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('paroquia')->order($ordem);
        if (isset($like)) {
            $select
                ->where
                ->like('id_paroquia', "%{$like}%")
                ->or
                ->like('nm_paroquia', "%{$like}%");
        }
        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Paroquia\Entity\ParoquiaEntity());
        // criar um objeto adapter paginator
        $paginatorAdapter = new DbSelect(
        // nosso objeto select
            $select,
            // nosso adapter da tabela
            $this->getAdapter(),
            // nosso objeto base para ser populado
            $resultSet
        );
        # var_dump($paginatorAdapter);
        #die;
        // resultado da paginação
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getParoquiaPaginator($filter = NULL, $camposFilter = NULL)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('paroquia')->columns([
            'id_paroquia',
            'nm_paroquia',
        ])
            ->join('cidade', 'cidade.id_cidade = paroquia.id_cidade', [
                'nm_cidade'
            ]);

        $where = [
        ];
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($value) {
                    if (isset($camposFilter[$key]['mascara'])) {
                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }
                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';
                }
            }
        }
        $select->where($where)->order(['nm_paroquia DESC']);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }
}
