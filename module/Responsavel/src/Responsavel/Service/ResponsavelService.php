<?php

namespace Responsavel\Service;

use Responsavel\Entity\ResponsavelEntity as Entity;
use Zend\Db\Sql\Sql;

class ResponsavelService extends Entity {

    /**
     * 
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getResponsavel($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('responsavel')
             
               ->join(
                        'sexo', 'sexo.id_sexo = responsavel.id_sexo'
                )
                   
                 
                    ->join(
                        'telefone_celular', 'telefone_celular.id_telefone_celular = responsavel.id_telefone_celular'
                )
                   
                    ->join(
                        'telefone_residencial', 'telefone_residencial.id_telefone_residencial = responsavel.id_telefone_residencial'
                )
                
                  ->join(
                        'email', 'email.id_email = responsavel.id_email'
                )
                
                  ->join(
                        'profissao', 'profissao.id_profissao = responsavel.id_profissao'
                )
               
               
                
               
                ->where([
            'responsavel.id_responsavel = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getIdProximoResponsavelCadastro($configList) {

        //Busca os usuarios cadastrados
        $ResponsavelService = $this->getServiceLocator()->get('Responsavel\Service\ResponsavelService');
        $resultSetResponsaveis = $ResponsavelService->filtrarObjeto();

        /* @var $contratoAsContratoService \ContratoAsContrato\Service\ContratoAsContratoService */
       
}

 public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_responsavel ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('responsavel')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_responsavel', "%{$like}%")
                    ->or
                    ->like('nm_responsavel', "%{$like}%")
                    ->or
                    ->like('tx_observacao', "%{$like}%")
                    ->or
                    ->like('cs_participa_movimento_pastoral', "%{$like}%")
                    
                    ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Responsavel\Entity\ResponsavelEntity());

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

  
    public function getResponsavelPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('responsavel')->columns([
                    'id_responsavel',
                    'nm_responsavel',
                    'id_telefone_residencial',
                    'id_telefone_celular',
                    'id_email',
                    'id_profissao',

        ])
            ->join('email','email.id_email = responsavel.id_email',['em_email'])
            ->join('profissao','profissao.id_profissao = responsavel.id_profissao',['nm_profissao']);

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

        $select->where($where)->order(['nm_responsavel DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function getFiltrarResponsavelPorNomeToArray($responsavel){

        $sql = new Sql($this->getAdapter());

        $select= $sql->select('responsavel')->columns(['id_responsavel','nm_responsavel'])
        ->where([
            'responsavel.nm_responsavel  LIKE ?'=> '%'.$responsavel.'%'
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    public static function responsavelNome($id){
        $resp = new \Responsavel\Service\ResponsavelService();

        $arrResp = $resp->buscar($id);

        return $arrResp->getNmResponsavel();
    }

    public function getTelefone($id){
        $objTelefone = new \Telefone\Service\TelefoneService();
        $arr = $objTelefone->buscar($id)->toArray();

        return '('.$arr['nr_ddd_telefone'].') '.\Estrutura\Helpers\Telefone::telefoneMask($arr['nr_telefone']);
    }

}




    
