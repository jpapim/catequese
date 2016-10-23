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


 
    public function getSituacaoConjugalToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_conjugal')
            ->where([
                'situacao_conjugal.id_situacao_conjugal'=> $id
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
     public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'ds_situacao_conjugal ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('situacao_conjugal')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_situacao_conjugal', "%{$like}%")
                    ->or
                    ->like('ds_situacao_conjugal', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \SituacaoConjugal\Entity\SituacaoConjugalEntity());

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

  
    public function getSituacaoConjugalPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('situacao_conjugal')->columns([
                    'id_situacao_conjugal',
                    'ds_situacao_conjugal',
                    
               
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

        $select->where($where)->order(['ds_situacao_conjugal DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}