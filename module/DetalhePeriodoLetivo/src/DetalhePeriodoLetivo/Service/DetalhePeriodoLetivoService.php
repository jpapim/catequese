<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 10/06/2016
 * Time: 13:19
 */


namespace DetalhePeriodoLetivo\Service;

use DetalhePeriodoLetivo\Entity\DetalhePeriodoLetivoEntity as Entity;
use Zend\Db\Sql\Sql;
use \Zend\Paginator\Paginator;
use \Zend\Paginator\Adapter\DbSelect;


class DetalhePeriodoLetivoService extends  Entity {



    // Obtendo o Periodo  Letivo pelo id
    public function getDetalhePeriodoToArray($id){
        $sql = new Sql($this->getAdapter());

        $select =  $sql->select('detalhe_periodo_letivo')
            ->where([
               'detalhe_periodo_letivo.id_periodo_letivo= ?'=>$id,
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function buscarDetalhePeriodo($params){
        $resultSet = null;
        if(isset($params['id_detalhe_periodo_letivo']) && $params['id_detalhe_periodo_letivo']){
            $resultSet = $this->select(['periodo_letivo.id_detalhe_periodo_letivo = ?'
            =>$params['id_detalhe_periodo_letivo']]);
        }
        return $resultSet;
    }

    public function getFilterDetalhePeriodoPorDataEncontro($dt_encontro){
        $sql = new Sql($this->getAdapter());

        $select = $sql->select('detalhe_periodo_letivo')
            ->columns(array('dt_encontro'))
            ->where(['periodo_letivo.dt_encontro LIKE ?'=>'%'.$dt_encontro.'%']);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function buscaPaginator($pagina = 1, $itensPagina = 5, $ordem = 'dt_encontro DESC', $like = null, $itensPaginacao = 10) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new Sql($this->getAdapter());
        $select = $sql->select('detalhe_periodo_letivo')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_detalhe_periodo_letivo', "%{$like}%")
            ;
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
            ->setCurrentPageNumber((int) $pagina)
            // quantidade de itens na p�gina
            ->setItemCountPerPage((int) $itensPagina)
            ->setPageRange((int) $itensPaginacao);
    }

    public function getDetalhePeriodoLetivoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new Sql($this->getAdapter());

        $select = $sql->select('detalhe_periodo_letivo')->columns([
            'id_detalhe_periodo_letivo',
            'id_perido_letivo',
            'dt_encontro',

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
        $select->where($where)->order(['dt_encontro  DESC']);
        return new Paginator(new DbSelect($select, $this->getAdapter()));
    }
}

