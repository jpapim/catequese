<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 12/07/2016
 * Time: 12:39
 */

namespace Profissao\Service;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Profissao\Entity\ProfissaoEntity as Entity;



class ProfissaoService  extends  Entity{


    public function getProfissaoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('profissao')->columns([
            'id_profissao',
            'nm_profissao'
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

        $select->where($where)->order(['nm_profissao ASC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_profissao ASC' , $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('profissao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_profissao', "%{$like}%")
                ->or
                ->like('nm_profissao', "%{$like}%");
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

    public function getProfissaoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('profissao')
            ->where([
                'profissao.id_profissao'=> $id
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

} 