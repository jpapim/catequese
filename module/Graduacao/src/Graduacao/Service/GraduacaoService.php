<?php

namespace Graduacao\Service;

use \Graduacao\Entity\GraduacaoEntity as Entity;

class GraduacaoService extends Entity{

    public function fetchAllGraduacao($params) {

        $resultSet = NULL;

        if (isset($params['id_graduacao']) && $params['id_graducao']) {

            $resultSet = $this->select(
                [
                    'graduacoes.id_graduacao = ? ' => $params['id_graduacao']
                ]
            );
        }
        return $resultSet;    }

    public function getGraduacaoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('graduacoes')
            ->where([
                'graduacoes.id_graduacao = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarGraduacaoPorNomeToArray($nm_graduacao) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('graduacoes')
            ->columns(array('nm_graduacao', 'id_academia')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                "graduacoes.nm_graduacao LIKE ?" => '%' . $nm_graduacao . '%',
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_graduacao ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('graduacao')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_graduacao', "%{$like}%")
                ->or
                ->like('nm_graducao', "%{$like}%")
                #->or
                #->like('telefone_principal', "%{$like}%")
                #->or
                #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \graduacao\Entity\GraduacaoEntity());

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
            // quantidade de itens na página
            ->setItemCountPerPage((int) $itensPagina)
            ->setPageRange((int) $itensPaginacao);
    }


    public function getGraduacaoPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('graduacoes')->columns([
            'id_graduacao',
            'nm_graduacao',

        ])
            ->join('arte_marcial', 'arte_marcial.id_arte_marcial = graduacoes.id_arte_marcial', [
                'nm_arte_marcial'
            ])
            ->join('estilos', 'estilos.id_estilo = graduacoes.id_estilo', [
                'nm_estilo'
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

        $select->where($where)->order(['nm_graduacao DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    
}