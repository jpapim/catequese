<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 30/06/2016
 * Time: 21:59
 */

namespace Formacao\Service;

use Formacao\Entity\FormacaoEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;

class FormacaoService extends Entity {

    public function getFormacaoToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('formacao')
            ->where([
                'formacao.id_formacao= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function buscarFormacao($params)
    {
        $resultSet = null;
        if (isset($params['id_formacao']) && $params['id_formacao']) {
            $resultSet = $this->select(['formacao.id_formacao = ?'
            => $params['id_formacao']]);
        }
        return $resultSet;
    }

    public function getFilterFormacaoPorNome($nm_formacao)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('formacao')
            ->columns(array('nm_formacao'))
            ->where(['formacao.nm_formacao LIKE ?' => '%' . $nm_formacao . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_formacao ASC', $like = null, $itensPaginacao = 10)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('formacao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_formacao', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new Entity());

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
        // resultado da pagina��o
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getFormacaoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('formacao')->columns([
            'id_formacao',
            'nm_formacao',

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
        $select->where($where)->order(['nm_formacao  DESC']);
        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }

    public function getFormacaoDetalhePaginator($id_formacao, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('detalhe_formacao')->columns([
            'id_detalhe_formacao',
            'ds_detalhe_formacao',
        ]);

        $where = [
            'id_formacao'=>$id_formacao,
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

        $select->where($where)->order(['ds_detalhe_formacao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }




} 