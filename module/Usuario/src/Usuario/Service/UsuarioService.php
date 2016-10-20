<?php

namespace Usuario\Service;

use \Usuario\Entity\UsuarioEntity as Entity;
use usuario\Table\UsuarioTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class UsuarioService extends Entity
{

    /**
     *
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getUsuario($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('usuario')
            ->join(
                'situacao_usuario', 'situacao_usuario.id_situacao_usuario = usuario.id_situacao_usuario'
            )
            ->join(
                'perfil', 'perfil.id_perfil = usuario.id_perfil'
            )
            ->join(
                'email', 'email.id_email = usuario.id_email'
            )
            ->join(
                'telefone', 'telefone.id_telefone = usuario.id_telefone'
            )
            ->where([
                'usuario.id_usuario = ?' => $id,
            ]);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     *
     * @return type
     */
    public function getIdProximoUsuarioCadastro($configList)
    {

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

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_usuario ASC', $like = null, $itensPaginacao = 5)
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('usuario')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_usuario', "%{$like}%")
                ->or
                ->like('nm_usuario', "%{$like}%");
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
        // resultado da paginaçao
        return (new Paginator($paginatorAdapter))
            // pagina a ser buscada
            ->setCurrentPageNumber((int)$pagina)
            // quantidade de itens na página
            ->setItemCountPerPage((int)$itensPagina)
            ->setPageRange((int)$itensPaginacao);
    }

    /**
     * @param null $filter
     * @param null $camposFilter
     * @return Paginator
     */
    public function getUsuarioPaginator($filter = NULL, $camposFilter = NULL, $usuarios_ativos = 1)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $ob_usuario_logado = $this->getServiceLocator()->get('Auth\Table\MyAuth')->read();
        $select = $sql->select('usuario')->columns([
            'id_usuario',
            'nm_usuario',
            'nm_funcao',
            'id_perfil',
        ])->join('perfil', 'perfil.id_perfil = usuario.id_perfil', [
            'nm_perfil'
        ]);

        if($ob_usuario_logado->id_perfil != TXT_CONST_PERFIL_ADMINISTRADOR) {
            if($ob_usuario_logado->id_perfil == TXT_CONST_PERFIL_CLIENTE) {
                $where = [
                    'id_situacao_usuario' => $usuarios_ativos,
                    'id_perfil != ?' => TXT_CONST_PERFIL_ADMINISTRADOR,
                ];
            } else {
                $where = [
                    'id_situacao_usuario' => $usuarios_ativos,
                    'id_usuario' => $ob_usuario_logado->id_usuario,
                ];
            }
        } else {
            $where = [
                'id_situacao_usuario' => $usuarios_ativos,
            ];
        }

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

        $select->where($where)->order(['nm_usuario ASC']);
        $select->where($where)->order(['nm_funcao ASC']);
        $select->where($where)->order(['nm_perfil ASC']);

        #xd($select->getSqlString($this->getAdapter()->getPlatform()));
        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}

