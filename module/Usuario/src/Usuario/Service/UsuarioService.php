<?php

namespace Usuario\Service;

use \Usuario\Entity\UsuarioEntity as Entity;
use usuario\Table\UsuarioTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UsuarioService extends Entity {

    /**
     * 
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getUsuario($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('usuario')
                //->join(
                 //       'contrato', 'contrato.id_usuario = usuario.id_usuario'
                //)
                //->join(
                //        'conta_bancaria', 'conta_bancaria.id_usuario = usuario.id_usuario', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
               // )
                ->join(
                        'estado_civil', 'estado_civil.id_estado_civil = usuario.id_estado_civil', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                )
                ->join(
                        'situacao_usuario', 'situacao_usuario.id_situacao_usuario = usuario.id_situacao_usuario'
                )
                ->join(
                        'email', 'email.id_email = usuario.id_email'
                )
                ->join(
                        'telefone', 'telefone.id_telefone = usuario.id_telefone'
                )                
                ->join(
                        'endereco', 'endereco.id_endereco = usuario.id_endereco', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                )
                ->join(
                        'cidade', 'cidade.id_cidade = endereco.id_cidade', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                )
                ->join(
                        'estado', 'estado.id_estado = cidade.id_estado', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                )                
                // ->join(
                //        'banco', 'banco.id_banco = conta_bancaria.id_banco', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                //)
                //->join(
                //        'tipo_conta', 'tipo_conta.id_tipo_conta = conta_bancaria.id_tipo_conta', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
                //)
                ->where([
            'usuario.id_usuario = ?' => $id,
            ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoUsuarioCadastro($configList) {

        //Busca os usuarios cadastrados
        $usuarioService = $this->getServiceLocator()->get('Usuario\Service\UsuarioService');
        $resultSetUsuarios = $usuarioService->filtrarObjeto();

        /* @var $contratoAsContratoService \ContratoAsContrato\Service\ContratoAsContratoService */
        $contratoAsContratoService = $this->getServiceLocator()->get('\ContratoAsContrato\Service\ContratoAsContratoService');
            
        foreach ($resultSetUsuarios as $usuarioEntity) {

            /* @var $contratoService \Contrato\Service\ContratoService */
            $contratoService = $this->getServiceLocator()->get("\Contrato\Service\ContratoService");
            $contratoService->setIdUsuario($usuarioEntity->getId());
            $contrato = $contratoService->filtrarObjeto()->current();

            $contratoAsContratoService->setIdContrato($contrato->getId());
            $contratoAsContratoService->setIdNivel(1);
            

            if ($contratoAsContratoService->filtrarObjeto()->count() < $configList['qtd_por_nivel']) {

                return $usuarioEntity->getId();
            }
        }
        return NULL;
    }
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_usuario ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('usuario')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_usuario', "%{$like}%")
                    ->or
                    ->like('nm_usuario', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \usuario\Entity\UsuarioEntity());

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
    public function getUsuarioPaginator($filter = NULL, $camposFilter = NULL) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('usuario')->columns([
                    'id_usuario',
                    'nm_usuario',
                    'dt_nascimento',
                    'nu_rg',
                    'nu_cpf',
                    'nm_profissao',
                    'nm_nacionalidade',
                
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

        $select->where($where)->order(['nm_usuario DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

