<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 01/07/2016
 * Time: 14:02
 */

namespace DetalheFormacao\Service;

use DetalheFormacao\Entity\DetalheFormacaoEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;


class DetalheFormacaoService extends Entity{

    public function getDetalheFormacaoToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('detalhe_formacao')
            ->where([
                'detalhe_formacao.id_detalhe_formacao= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function buscarDetalheFormacao($params)
    {
        $resultSet = null;
        if (isset($params['id_detalhe_formacao']) && $params['id_detalhe_formacao']) {
            $resultSet = $this->select(['formacao.id_detalhe_formacao = ?'
            => $params['id_detalhe_formacao']]);
        }
        return $resultSet;
    }
    public function getFilterDetalheFormacaoDsDetalheFormacao($ds_detalhe_formacao)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('detalhe_formacao')
            ->columns(array('ds_detalhe_formacao'))
            ->where(['detalhe_formacao.ds_detalhe_formacao LIKE ?' => '%' . $ds_detalhe_formacao . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_detalhe_formacao ASC', $like = null, $itensPaginacao = 10)
    {
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('detalhe_formacao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_detalhe_formacao', "%{$like}%");
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

    public function getDetalheFormacaoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('detalhe_formacao')->columns([
            'id_detalhe_formacao',
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
        $select->where($where)->order(['id_detalhe_formacao  ASC']);
        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }




} 