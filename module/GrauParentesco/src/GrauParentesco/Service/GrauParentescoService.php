<?php

namespace GrauParentesco\Service;

use GrauParentesco\Entity\GrauParentescoEntity as Entity;
use GrauParentesco\Table\GrauParentescoTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class GrauParentescoService extends Entity{
    //buscando id do grau
      public function getGrauParentescoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('grau_parentesco')
                ->where([
            'grau_parentesco.id_grau_parentesco = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    //buscando nome do grau
     public function getIdGrauParentescoPorNomeToArray($nm_grau_parentesco) {

        $arNomeGrau_parentesco = explode('(', $nm_grau_parentesco);
        $nm_grau_parentesco = $arNomeGrau_parentesco[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('grau_parentesco')
                ->columns(array('id_grau_parentesco'))
                ->where([
            'grau_parentesco.nm_grau_parentesco = ?' => $filter->filter($nm_grau_parentesco),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_grau_parentesco ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('grau_parentesco')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_grau_parentesco', "%{$like}%")
                    ->or
                    ->like('nm_grau_parentesco', "%{$like}%");
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \GrauParentesco\Entity\GrauParentescoEntity());

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

  
    public function getGrauParentescoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('grau_parentesco')->columns([
                    'id_grau_parentesco',
                    'nm_grau_parentesco',       
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

        $select->where($where)->order(['nm_grau_parentesco DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    
