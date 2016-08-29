<?php

namespace FrequenciaTurma\Service;

use FrequenciaTurma\Entity\FrequenciaTurmaEntity as Entity;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class FrequenciaTurmaService extends Entity
{

    public function getFrequenciaTurmaPaginator($filter = NULL, $camposFilter = NULL)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('frequencia_turma')->columns([
            'id_frequencia_turma',
            'id_turma_catequizando',
            'id_detalhe_periodo_letivo',
        ])->join(array('tct' =>
                'turma_catequizando'), 'tct.id_turma_catequizando = frequencia_turma.id_turma_catequizando',
                array('id_turma', 'id_catequizando', 'id_usuario', 'turma_catequizando_id_periodo_letivo'=>'id_periodo_letivo', 'dt_cadastro', 'cs_aprovado', 'ds_motivo_reprovacao', 'tx_observacoes') #Alysson - Criando Alias para a Coluna
        )->join( array('dpl' =>
                'detalhe_periodo_letivo'), 'dpl.id_detalhe_periodo_letivo = frequencia_turma.id_detalhe_periodo_letivo',
                array('detalhe_periodo_letivo_id_periodo_letivo'=>'id_periodo_letivo', 'dt_encontro')#Alysson - Criando Alias para a Coluna
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

        $select->where($where)->order(['id_frequencia_turma DESC']);
        #xd($select->getSqlString($this->getAdapter()->getPlatform()));

        return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
    }

    public function fetchPaginator($pagina = 1, $itensPagina = 5, $ordem = 'id_frequencia_turma ASC', $like = null, $itensPaginacao = 5)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select('frequencia_turma')->order($ordem);

        if (isset($like)) {
            $select
                ->where
                ->like('id_frequencia_turma', "%{$like}%")
                ->or
                ->like('id_turma_catequizando', "%{$like}%")
                ->or
                ->like('id_detalhe_periodo_letivo', "%{$like}%");
        }

        $resultSet = new HydratingResultSet(new Reflection(), new \FrequenciaTurma\Entity\FrequenciaTurmaEntity());

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

    public function getFrequenciaTurmaToArray($id)
    {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        $select = $sql->select('frequencia_turma')
            ->where([
                'frequencia_turma.id_frequencia_turma = ?' => $id,
            ]);

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }


}
