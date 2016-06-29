<?php

namespace Etapa\Service;

use Etapa\Entity\EtapaEntity as Entity;
use Etapa\Table\EtapaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class EtapaService extends Entity{
    //buscando id da etapa
      public function getEtapaToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('etapa')
                ->where([
            'etapa.id_etapa = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    //buscando nome da etapa
     public function getIdEtapaPorNomeToArray($nm_etapa) {

        $arNomeEtapa = explode('(', $nm_etapa);
        $nm_etapa = $arNomeEtapa[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('etapa')
                ->columns(array('id_etapa'))
                ->where([
            'etapa.nm_etapa = ?' => $filter->filter($nm_etapa),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_etapa ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('etapa')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_etapa', "%{$like}%")
                    ->or
                    ->like('nm_etapa', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Etapa\Entity\EtapaEntity());

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

  
    public function getEtapaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('etapa')->columns([
                    'id_etapa',
                    'nm_etapa',
                    
               
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

        $select->where($where)->order(['nm_etapa DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    
