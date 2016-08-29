<?php

namespace ResponsavelCatequizando\Service;

use ResponsavelCatequizando\Entity\ResponsavelCatequizandoEntity as Entity;

class ResponsavelCatequizandoService extends Entity
{

    public function getResponsavelCatequizandoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel_catequizando')->columns([
            'id_responsavel_catequizando',
     #----------------------
            # Aguardando implementar o Modulo Responsável,
            # Após implementado, excluir a linha abaixo ('id_responsavel',)
            'id_responsavel',
     #----------------------
        ])
            ->join(
                'catequizando', 'catequizando.id_catequizando = responsavel_catequizando.id_catequizando'
            )
     #----------------------
            # Após implementar o Modulo Responsavel retirar a linha abaixo do comentário

            //->join(
            //  'responsavel', 'responsavel.id_responsavel = responsavel_catequizando.id_responsavel'
            // )
     #----------------------

            ->join(
                'grau_parentesco', 'grau_parentesco.id_grau_parentesco = responsavel_catequizando.id_grau_parentesco'
            );

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

        $select->where($where)->order(['id_responsavel_catequizando DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_responsavel_catequizando ASC', $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('responsavel_catequizando')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_responsavel_catequizando', "%{$like}%")
                ->or
                ->like('nm_catequizando', "%{$like}%")
                ->or
                ->like('nm_responsavel', "%{$like}%")
                ->or
                ->like('nm_grau_parentesco', "%{$like}%");

        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \ResponsavelCatequizando\Entity\ResponsavelCatequizandoEntity());

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
        // resultado da paginaçãoo
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }


    public function getResponsavelCatequizandoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel_catequizando')
            ->where([
                'responsavel_catequizando.id_responsavel_catequizando = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }


}

    