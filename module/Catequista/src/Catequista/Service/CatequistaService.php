<?php

namespace Catequista\Service;

use Catequista\Entity\CatequistaEntity as Entity;

class CatequistaService extends Entity {

 
    public function getCatequista($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequista')
             
               ->join(
                        'sexo', 'sexo.id_sexo = catequista.id_sexo'
                )
          
                ->join(
                        'email', 'email.id_email = catequista.id_email'
                )
       
               
                ->where([
            'catequista.id_catequista = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoCatequistaCadastro($configList) {

        //Busca os usuarios cadastrados
        $catequistaService = $this->getServiceLocator()->get('Catequista\Service\CatequistaService');
        $resultSetCatequistas = $catequistaService->filtrarObjeto();

    
    }

         public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequista ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_catequista', "%{$like}%")
                    ->or
                   ->like('nm_catequista', "%{$like}%")
                    ->or
                   ->like('nr_matricula', "%{$like}%")
                    ->or
                   ->like('dt_nascimento', "%{$like}%")
                    ->or
                   ->like('dt_ingresso', "%{$like}%")
                    ->or
                   ->like('tx_observacao', "%{$like}%");
                 
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Catequista\Entity\CatequistaEntity());

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

  
    public function getCatequistaPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequista')->columns([
            'id_catequista',       
            'nm_catequista',
            'nr_matricula',
            'dt_nascimento',
            'dt_ingresso',
            'tx_observacao',
            'ds_situacao',
            'cs_coordenador'
            
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

        $select->where($where)->order(['id_catequista DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    public function getCatequistaToArray($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista')
            ->where([
                'catequista.id_catequista'=> $id
            ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
    public function getFiltrarCatequistaPorNomeToArray($nm_catequista) {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista')
            ->columns(array('nm_catequista', 'id_catequista')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                    "catequista.nm_catequista LIKE ?" => '%' . $nm_catequista . '%',
                ]);
        return $sql->prepareStatementForSqlObject($select)->execute();
    }
     public function  getCatequistaJoins($id){
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequista')->columns([
            'nm_catequista'
        ])
        ->join('catequista_turma','catequista_turma.id_catequista =  catequista.id_catequista',['id_turma'])
        ->join('turma','turma.id_turma = catequista_turma.id_turma',['nm_turma'])
            ->where([
            'catequista.id_catequista = ?' =>$id
        ]);
        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    
   
    }
 
