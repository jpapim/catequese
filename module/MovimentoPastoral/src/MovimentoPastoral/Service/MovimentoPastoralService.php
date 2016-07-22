<?php

namespace MovimentoPastoral\Service;

use MovimentoPastoral\Entity\MovimentoPastoralEntity as Entity;
use MovimentoPastoral\Table\MovimentoPastoralTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class MovimentoPastoralService extends Entity{
    //buscando id do movimento
      public function getMovimentoPastoralToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('movimento_pastoral')
                ->where([
            'movimento_pastoral.id_movimento_pastoral = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    //buscando nome do movimento
     public function getIdMovimentoPastoralPorNomeToArray($nm_movimento_pastoral) {

        $arNomeMovimento_pastoral = explode('(', $nm_movimento_pastoral);
        $nm_movimento_pastoral = $arNomeMovimento_pastoral[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('movimento_pastoral')
                ->columns(array('id_movimento_pastoral'))
                ->where([
            'movimento_pastoral.nm_movimento_pastoral = ?' => $filter->filter($nm_movimento_pastoral),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_movimento_pastoral ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('movimento_pastoral')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_movimento_pastoral', "%{$like}%")
                    ->or
                    ->like('nm_movimento_pastoral', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \MovimentoPastoral\Entity\MovimentoPastoralEntity());

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

  
    public function getMovimentoPastoralPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('movimento_pastoral')->columns([
                    'id_movimento_pastoral',
                    'nm_movimento_pastoral',       
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

        $select->where($where)->order(['nm_movimento_pastoral DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    
