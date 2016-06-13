<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:56
 */

namespace PeriodoLetivo\Service;

use PeriodoLetivo\Entity\PeriodoLetivoEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;


class PeriodoLetivoService extends Entity
{

    // Obtendo o Periodo  Letivo pelo id
    public function getPeriodoLetivoToArray($id)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('periodo_letivo')
            ->where([
                'periodo_letivo.id_periodo_letivo= ?' => $id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    // Buscar o periodo Letivo de acordo com os parametros passados
    public function buscarPeriodoLetivo($params)
    {
        $resultSet = null;
        if (isset($params['id_periodo_letivo']) && $params['id_periodo_letivo']) {
            $resultSet = $this->select(['periodo_letivo.id_periodo_letivo = ?'
            => $params['id_periodo_letivo']]);
        }
        return $resultSet;
    }

    // faz uma busca baseada na data de  inicio
    public function getFilterPeriodoPorDataInicio($dt_inicio)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('periodo_letivo')
            ->columns(array('dt_inicio'))
            ->where(['periodo_letivo.dt_inicio LIKE ?' => '%' . $dt_inicio . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    //faz uma busca baseada na data final
    public function getFilterPeriodoPorDataFim($dt_fim)
    {
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('periodo_letivo')
            ->columns(array('dt_fim'))
            ->where(['periodo_letivo.dt_fim LIKE ?' => '%' . $dt_fim . '%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'dt_inicio ASC', $like = null, $itensPaginacao = 10)
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('periodo_letivo')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_periodo_letivo', "%{$like}%");
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

    public function getPeriodoLetivoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('periodo_letivo')->columns([
            'id_periodo_letivo',
            'dt_inicio',
            'dt_fim',
            'dt_ano_letivo',
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
        $select->where($where)->order(['dt_inicio  DESC']);
        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }

    public function getPeriodoLetivoDetalhePaginator($id_periodo_letivo, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('detalhe_periodo_letivo')->columns([
            'id_detalhe_periodo_letivo',
            'dt_encontro',
        ]);

        $where = [
            'id_periodo_letivo'=>$id_periodo_letivo,
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

        $select->where($where)->order(['dt_encontro DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}