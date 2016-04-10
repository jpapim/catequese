<?php

namespace Atleta\Service;

use \Atleta\Entity\AtletaEntity as Entity;
use Atleta\Table\AtletaTable;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class AtletaService extends Entity {

    public function fetchAllAcademia($params) {

        $resultSet = NULL;

        if (isset($params['id_academia']) && $params['id_academia']) {

            $resultSet = $this->select(
                    [
                        'atleta.id_academia = ? ' => $params['id_academia']
                    ]
            );
        }
        return $resultSet;
    }

    public function getAtletaToArray($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('atleta')
                ->where([
            'atleta.id_atleta = ?' => $id,
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getIdAtletaPorNomeToArray($nm_atleta) {

        $arNomeAtleta = explode('(', $nm_atleta);
        $nm_atleta = $arNomeAtleta[0];

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $filter = new \Zend\Filter\StringTrim();
        $select = $sql->select('atleta')
                ->columns(array('id_atleta'))
                ->where([
            'atleta.nm_atleta = ?' => $filter->filter($nm_atleta),
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    public function getFiltrarAtletaPorNomeToArray($nm_atleta) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('atleta')
                ->columns(array('nm_atleta', 'id_academia')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
                ->where([
            "atleta.nm_atleta LIKE ?" => '%' . $nm_atleta . '%',
        ]);

        return $sql->prepareStatementForSqlObject($select)->execute();
    }

    /*     * *
     * Metodo customizado que para cadastramento de Atletas Atravez da tela de cadastro de academias
     * @param $post
     * @return mixed
     */

    public function salvarviaacademia($post) {
        $this->preSave();

        $dados = $this->hydrate();

        $where = null;

        if ($this->getId()) {
            if (!$field = $this->fieldName('id')) {
                $field = $this->fieldName('Id');
            }

            $where = [$field => $this->getId()];
        }
        #Alysson - Setando os Dados do Formulario Manualmente
        $dados['id_academia'] = $post['id_academia'];
        $dados['id_usuario'] = $post['id_usuario'];
        $dados['id_usuario_cadastro'] = $post['id_usuario_cadastro'];
        $dados['id_cidade'] = $post['id_cidade'];

        #var_dump( $post );
        #var_dump( $dados );
        #die;

        $result = $this->getTable()->salvar($dados, $where);
        if (is_string($result)) {
            $this->setId($result);
        }
        $this->posSave();
        return $result;
    }

    /*     * *
     * Metodo customizado que para cadastramento de Atletas Atravez da tela de cadastro de academias
     * @param $post
     * @return mixed
     */

    public function salvaralterarviaacademia($post) {
        $this->preSave();

        $dados = $this->hydrate();

        $where = null;

        if ($post['id_atleta']) {
            if (!$field = $this->fieldName('id')) {
                $field = $this->fieldName('Id');
            }

            $where = [$field => $post['id_atleta']];
        }
        #Alysson - Setando os Dados do Formulario Manualmente
        $dados['id_academia'] = $post['id_academia'];
        $dados['id_usuario'] = $post['id_usuario'];
        $dados['id_usuario_cadastro'] = $post['id_usuario_cadastro'];
        $dados['id_cidade'] = $post['id_cidade'];
        $dados['id_atleta'] = $post['id_atleta'];

        $result = $this->getTable()->salvar($dados, $where);
        if (is_string($result)) {
            $this->setId($result);
        }
        $this->posSave();
        return $result;
    }

    /**
     * Localizar itens por pagina��o
     *
     * @param type $pagina
     * @param type $itensPagina
     * @param type $ordem
     * @param type $like
     * @param type $itensPaginacao
     * @return type Paginator
     */
    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'nm_atleta ASC', $like = null, $itensPaginacao = 5) {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        // preparar um select para tabela contato com uma ordem
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('atleta')->order($ordem);

        if (isset($like)) {
            $select
                    ->where
                    ->like('id_atleta', "%{$like}%")
                    ->or
                    ->like('nm_atleta', "%{$like}%")
            #->or
            #->like('telefone_principal', "%{$like}%")
            #->or
            #->like('data_criacao', "%{$like}%")
            ;
        }

        // criar um objeto com a estrutura desejada para armazenar valores
        $resultSet = new HydratingResultSet(new Reflection(), new \Atleta\Entity\AtletaEntity());

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

        $select = $sql->select('atleta')->columns([
                    'id_atleta',
                    'nm_atleta',
                    'nr_peso',
                    'dt_nascimento',
                ])
                ->join('cidade', 'cidade.id_cidade = atleta.id_cidade', [
                    'nm_cidade'
                ])
                ->join('estado', 'estado.id_estado = cidade.id_estado', [
                    'nm_estado'
                ])               
                ->join('academias', 'academias.id_academia = atleta.id_academia', [
                    'nm_academia'
                ])
                ->join('sexo', 'sexo.id_sexo = atleta.id_sexo', [
            'nm_sexo',
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

        $select->where($where)->order(['nm_atleta DESC']);

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

}
