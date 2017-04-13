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
use Zend\Db\Sql\Select;
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
        ->join('email','catequizando.id_email = email.id_email',['em_email'])
        ->join('telefone','telefone.id_telefone = catequizando.id_telefone_residencial',['nr_ddd_telefone','nr_telefone'])  ;
        $where = [
        ];

        if (!empty($filter)) {

            foreach ($filter as $key => $value) {


                if ($value) {

                    if(isset($filter[1]) && !empty($filter[1])){
                        $select->join('responsavel_catequizando','responsavel_catequizando.id_catequizando = catequizando.id_catequizando',['id_responsavel'])
                            ->join('responsavel','responsavel.id_responsavel = responsavel_catequizando.id_responsavel',['nm_responsavel']);
                        $where[$camposFilter[1]['filter']]= '%' . $value . '%';

                    }

                    if(isset($filter[4]) && !empty($filter[4])){
                        $select->join('turma_catequizando','turma_catequizando.id_catequizando = catequizando.id_catequizando',['id_turma'])
                            ->join('turma','turma.id_turma = turma_catequizando.id_turma',['nm_turma']);
                        $where[$camposFilter[4]['filter']]= '%' . $value . '%';

                    }

                    if (isset($camposFilter[$key]['mascara'])) {

                        eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
                    }

                    $where[$camposFilter[$key]['filter']] = '%' . $value . '%';

                }
            }

        }

        $select->where($where)->order(['id_catequizando DESC']);

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

    public function  getCatequizandoTurma($id){
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('turma_catequizando')->columns([
            'id_turma'
        ])
        ->where(['turma_catequizando.id_catequizando = ? '=>$id]);

        $id_turma = $sql->prepareStatementForSqlObject($select)->execute()->current();

        $select = $sql->select('turma')->columns([
            'nm_turma'
        ])
            ->where(['turma.id_turma = ? '=> $id_turma]);

        $result = $sql->prepareStatementForSqlObject($select)->execute()->current();

        return $result['nm_turma'];
    }

    public function  getCatequizandoResponsavel($id){
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel_catequizando')->columns([

            'id_responsavel'
        ])
        ->where(['responsavel_catequizando.id_catequizando = ?'=>$id]);

        $id_responsavel = $sql->prepareStatementForSqlObject($select)->execute()->current();

            if(!empty($id_responsavel)){
                $select= $sql->select('responsavel')->columns(
                    [
                        'nm_responsavel'
                    ]
                )
                    ->where(['responsavel.id_responsavel = ? ' =>$id_responsavel]);

                $result = $sql->prepareStatementForSqlObject($select)->execute()->current();

                return  $result['nm_responsavel'];
            }
        return null;
    }


    public function getCatequizandoResponsavelPaginator($id_catequizando, $filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel_catequizando');

        $where = [
            'id_catequizando'=>$id_catequizando,
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

        $select->where($where)->order(['id_responsavel DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }


    ### Actions Para os parametros do responsavel-pagination

    public function grauParentesco($id){

        $grauParen = new \GrauParentesco\Service\GrauParentescoService();
        $arrParen = $grauParen->buscar($id);

        return $arrParen->getNmGrauParentesco();
    }

    public function situacaoConjugal($id){
        $sitCon = new \SituacaoConjugal\Service\SituacaoConjugalService();
        $arrSit = $sitCon->buscar($id);

        return $arrSit->getDsSituacaoConjugal();
    }

    public function responsavelCatequizando($id){
        $resp = new \Responsavel\Service\ResponsavelService();

        $arrResp = $resp->buscar($id);

        return $arrResp->getNmResponsavel();
    }

    public function fetchAllMyCustom() {

        $select = $this->getTable()->select();
        $select->order('nm_catequizando ASC');

        return  $this->fetchAllCustom($select);
    }
} 