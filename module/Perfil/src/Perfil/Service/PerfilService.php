<?php

namespace Perfil\Service;

use Perfil\Entity\PerfilEntity as Entity;
use Perfil\Table\PerfilTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PerfilService extends Entity{
    //buscando id do perfil
      public function getPerfilToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('perfil')
                ->where([
            'perfil.id_perfil = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    //buscando nome do perfil
     public function getIdPerfilPorNomeToArray($nm_perfil) {

        $arNomePerfil = explode('(', $nm_perfil);
        $nm_perfil = $arNomePerfil[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('perfil')
                ->columns(array('id_perfil'))
                ->where([
            'perfil.nm_perfil = ?' => $filter->filter($nm_perfil),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_perfil ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('perfil')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_perfil', "%{$like}%")
                    ->or
                    ->like('nm_perfil', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Perfil\Entity\PerfilEntity());

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

    /**
     * 
     * @param type $dtInicio
     * @param type $dtFim
     * @return type
     */
    public function getPerfilPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('perfil')->columns([
                    'id_perfil',
                    'nm_perfil',
                    
               
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

        $select->where($where)->order(['nm_perfil DESC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

    
