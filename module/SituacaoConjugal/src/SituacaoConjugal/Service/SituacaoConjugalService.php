<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 12:39
 */

namespace SituacaoConjugal\Service;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use SituacaoConjugal\Entity\SituacaoConjugalEntity as Entity;



class SituacaoConjugalService  extends  Entity{


    public function getSituacaoConjugalPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_conjugal')->columns([
            'id_situacao_conjugal',
            'ds_situacao_conjugal'
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

        $select->where($where)->order(['id_situacao_conjugal DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_situacao_conjugal ASC' , $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('situacao_conjugal')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_situacao_conjugal', "%{$like}%")
                ->or
                ->like('ds_situacao_conjugal', "%{$like}%");
        }

        $resultSet = new HydratingResultSet(new Reflection(), new Entity());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->getAdapter(),
            $resultSet
        );

        return (new Paginator($paginatorAdapter))
            ->setCurrentPageNumber((int)$pagina)
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getSituacaoConjugalToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_conjugal')
            ->where([
                'situacao_conjugal.id_situacao_conjugal'=> $id
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

} 