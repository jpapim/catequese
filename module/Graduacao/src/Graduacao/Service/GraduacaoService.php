<?php

namespace Graduacao\Service;

use \Graduacao\Entity\GraduacaoEntity as Entity;

class GraduacaoService extends Entity{

    public function getGraduacaoToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('graduacoes')
            ->where([
                'graduacoes.id_graduacao = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

/*
    public function getGraduacao($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        die($id);
        $select = $sql->select('usuario')
            ->join(
                'contrato', 'contrato.id_usuario = usuario.id_usuario'
            )
            ->join(
                'conta_bancaria', 'conta_bancaria.id_usuario = usuario.id_usuario', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
            )
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
            ->join(
                'banco', 'banco.id_banco = conta_bancaria.id_banco', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
            )
            ->join(
                'tipo_conta', 'tipo_conta.id_tipo_conta = conta_bancaria.id_tipo_conta', \Zend\Db\Sql\Select::SQL_STAR, \Zend\Db\Sql\Select::JOIN_LEFT
            )
            ->where([
                'usuario.id_usuario = ?' => $id,
            ]);
        print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }
*/
}