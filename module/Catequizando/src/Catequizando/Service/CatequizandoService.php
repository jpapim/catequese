<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 14/07/2016
 * Time: 16:45
 */

namespace Catequizando\Service;

use Catequizando\Entity\CatequizandoEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CatequizandoService extends  Entity{

    public function getCatequizandoPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequizando')->columns([

            'id_catequizando',
            'id_telefone_residencial',
            'id_telefone_celular',
            'nm_catequizando',


        ])
<<<<<<< HEAD:module/Catequizando/src/Catequizando/Service/CatequizandoService.php
        ->join('email','catequizando.id_email = email.id_email',['em_email'])
        ->join('telefone','telefone.id_telefone = catequizando.id_telefone_residencial',['nr_ddd_telefone','nr_telefone']);
=======
        ->join('email','catequisando.id_email = email.id_email',['em_email'])
        ->join('telefone','telefone.id_telefone = catequisando.id_telefone_residencial',['nr_ddd_telefone','nr_telefone'])
        ->join('responsavel_catequisando','responsavel_catequisando.id_catequisando = catequisando.id_catequisando',['id_responsavel'],\Zend\Db\Sql\Select::JOIN_LEFT)
        ->join('responsavel','responsavel.id_responsavel = responsavel_catequisando.id_responsavel',['nm_responsavel'],\Zend\Db\Sql\Select::JOIN_LEFT)
        ->join('turma_catequisando','turma_catequisando.id_catequisando = catequisando.id_catequisando',['id_turma'],\Zend\Db\Sql\Select::JOIN_LEFT)
        ->join('turma','turma.id_turma = turma_catequisando.id_turma',['nm_turma'],\Zend\Db\Sql\Select::JOIN_LEFT);


>>>>>>> dev-raimundo:module/Catequisando/src/Catequisando/Service/CatequisandoService.php

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

<<<<<<< HEAD:module/Catequizando/src/Catequizando/Service/CatequizandoService.php
        $select->where($where)->order(['id_catequizando ASC']);
=======
        $select->where($where)->order(['nm_catequisando ASC']);
>>>>>>> dev-raimundo:module/Catequisando/src/Catequisando/Service/CatequisandoService.php

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_catequizando ASC' , $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('catequizando')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_catequizando', "%{$like}%")
                ->or
                ->like('nm_catequizando', "%{$like}%");

        }

        $resultSet = new HydratingResultSet(new Reflection(), new Entity());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->getAdapter(),
            $resultSet
        );

        return (new Paginator($paginatorAdapter))
            ->setCurrentPageNumber((int)$pagina)
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    public function getCatequizandoToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequizando')
            ->where([
                'catequizando.id_catequizando'=> $id
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarCatequizandoPorNomeToArray($nm_catequizando) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequizando')
            ->columns(array('nm_catequizando', 'id_catequizando')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
            ->where([
                    "catequizando.nm_catequizando LIKE ?" => '%' . $nm_catequizando . '%',
                ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

<<<<<<< HEAD:module/Catequizando/src/Catequizando/Service/CatequizandoService.php
    public function  getCatequizandoJoins($id){
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('catequizando')->columns([

            'nm_catequizando'
        ])
        ->join('turma_catequizando','turma_catequizando.id_catequizando =  catequizando.id_catequizando',['id_turma'])
        ->join('turma','turma.id_turma = turma_catequizando.id_turma',['nm_turma'])

            ->where([
            'catequizando.id_catequizando = ?' =>$id
        ]);
=======
    public function  getCatequisandoTurma($id){
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequisando')->columns(['id_turma'])
            ->where(['turma_catequisando.id_catequisando = ?'=>$id]);

        $id_turma = $sql->prepareStatementForSqlObject($select)->execute()->current();
>>>>>>> dev-raimundo:module/Catequisando/src/Catequisando/Service/CatequisandoService.php

        $select = $sql->select('turma')->columns(['nm_turma'])
            ->where(['turma.id_turma = ?'=>$id_turma['id_turma']]);

        $x =  $sql->prepareStatementForSqlObject($select)->execute()->current();
        return $x['nm_turma'];
    }

<<<<<<< HEAD:module/Catequizando/src/Catequizando/Service/CatequizandoService.php
    public function  getCatequizandoResponsavel($id){
=======
    public function  getCatequisandoResponsavel($id){
        $sql =  new \Zend\Db\Sql\Sql($this->getAdapter());

        $select =$sql->select('responsavel_catequisando')->columns(['id_responsavel'])
        ->where(['responsavel_catequisando.id_catequisando = ?' =>$id ]);

        $id_responsavel = $sql->prepareStatementForSqlObject($select)->execute()->current();
        #$id_responsavel['id_responsavel']
        $select=$sql->select('responsavel')->columns(['nm_responsavel'])->where(['responsavel.id_responsavel = ?'=>$id_responsavel['id_responsavel']]);
>>>>>>> dev-raimundo:module/Catequisando/src/Catequisando/Service/CatequisandoService.php

        $nm_responsavel = $sql->prepareStatementForSqlObject($select)->execute()->current();
         return $nm_responsavel['nm_responsavel'];
    }


} 