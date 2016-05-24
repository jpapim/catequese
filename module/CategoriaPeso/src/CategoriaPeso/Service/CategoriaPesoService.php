<?php

namespace CategoriaPeso\Service;

use \CategoriaPeso\Entity\CategoriaPesoEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CategoriaPesoService extends Entity{

    public function getCategoriaPesoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('categoria_peso')
            ->where([
                'categoria_peso.id_categoria_peso = ?' => $id,
            ]);
        #print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
    public function fetchCategoriaPeso($params) {

        $resultSet = NULL;

        if (isset($params['id_categoria_peso']) && $params['id_categoria_peso']) {

            $resultSet = $this->select(
                    [
                        'categoria_peso.id_categoria_peso = ? ' => $params['id_categoria_peso']
                    ]
            );
        }
        return $resultSet;
    }
    
    public function getIdCategPesoPorNomeToArray($nm_catPeso) {

        $arNomeCategPeso = explode('(', $nm_catPeso);
        $nm_catPeso = $arNomeCategPeso[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('categoria_peso')
                ->columns(array('id_categoria_peso'))
                ->where([
            'categoria_peso.nm_categoria_peso = ?' => $filter->filter($nm_catPeso),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    
    public function getFiltrarCatPesoPorNomeToArray($nm_catPesoFilter ) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('categoria_peso')
                ->columns(array('nm_categoria_peso')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
                ->where([
            "categoria_peso.nm_categoria_peso LIKE ?" => '%' . $nm_catPesoFilter . '%',
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }
    
      public function fetchPaginator($pagina = 1, $itensPagina =5, $ordem = 'nm_categoria_peso ASC', $like = null, $itensPaginacao = 10) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('categoria_peso')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_categoria_peso', "%{$like}%")
                    ->or
                    ->like('nm_categoria_peso', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \CategoriaPeso\Entity\CategoriaPesoEntity());

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
    
    public function getCatPesoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('categoria_peso')->columns([
                    'id_categoria_peso',
                    'nm_categoria_peso',
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

        $select->where($where)->order(['nm_categoria_peso DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}