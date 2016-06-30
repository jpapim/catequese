<?php

namespace Cidade\Service;

use \Cidade\Entity\CidadeEntity as Entity;
use Atleta\Table\CidadeTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CidadeService extends Entity {

    public function fetchAllEstado($params) {

        $resultSet = NULL;

        if (isset($params['id_estado']) && $params['id_estado']) {

            $resultSet = $this->select(
                [
                    'cidade.id_estado = ? ' => $params['id_estado']
                ]
            );
        }
        return $resultSet;
    }

    public function getCidadeToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        #die($id);
        $select = $sql->select('cidade')
            ->where([
                'cidade.id_cidade = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarCidadePorNomeToArray($nm_cidade) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('cidade')
            ->columns(array('nm_cidade', 'id_estado') ) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "cidade.nm_cidade LIKE ?" => '%'.$nm_cidade.'%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getIdCidadePorNomeToArray($nm_cidade) {

        $arNomeDaCidade = explode('(', $nm_cidade);
        $nm_cidade = $arNomeDaCidade[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('cidade')
            ->columns(array('id_cidade') )
            ->where([
                'cidade.nm_cidade = ?' => $filter->filter($nm_cidade),
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_cidade ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('cidade')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('nm_estado', "%{$like}%")
                ->or
                ->like('id_cidade', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Cidade\Entity\CidadeEntity());

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

    public function getAtletasPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('cidade')->columns([
            'id_estado',
            'id_cidade',
            'nm_cidade',



        ])
            ->join('estado', 'estado.id_estado = cidade.id_estado', [
                'nm_estado'
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

        $select->where($where)->order(['nm_cidade ASC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


}
