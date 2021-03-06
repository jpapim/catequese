<?php

namespace Sacramento\Service;

use Sacramento\Entity\SacramentoEntity as Entity;
use Sacramento\Table\SacramentoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class SacramentoService extends Entity{
    //buscando id do sacramento
      public function getSacramentoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento')
                ->where([
            'sacramento.id_sacramento = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    //buscando nome do sacramento
     public function getIdSacramentoPorNomeToArray($nm_sacramento) {

        $arNomeSacramento = explode('(', $nm_sacramento);
        $nm_sacramento = $arNomeSacramento[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('sacramento')
                ->columns(array('id_sacramento'))
                ->where([
            'sacramento.nm_sacramento = ?' => $filter->filter($nm_sacramento),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_sacramento ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('sacramento')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_sacramento', "%{$like}%")
                    ->or
                    ->like('nm_sacramento', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Sacramento\Entity\SacramentoEntity());

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

  
    public function getSacramentoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('sacramento')->columns([
                    'id_sacramento',
                    'nm_sacramento',
                    
               
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

        $select->where($where)->order(['nm_sacramento DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    
