<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 12:57
 */

namespace SituacaoResponsavel\Service;


use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use SituacaoResponsavel\Entity\SituacaoResponsavelEntity as Entity;


class SituacaoResponsavelService  extends  Entity{


    public function getSituacaoResponsavelPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_responsavel')->columns([
            'id_situacao_responsavel',
            'ds_situacao_responsavel',
            'cs_pai_mae'
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

        $select->where($where)->order(['id_situacao_responsavel DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_situacao_responsavel ASC' , $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('situacao_responsavel')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_situacao_responsavel', "%{$like}%")
                ->or
                ->like('ds_situacao_responsavel', "%{$like}%")
                ->or
                ->like('cs_pai_mae',"%{$like}%");
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

    public function getSituacaoResponsavelToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_responsavel')
            ->where([
                'situacao_responsavel.id_situacao_responsavel'=> $id
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }


} 