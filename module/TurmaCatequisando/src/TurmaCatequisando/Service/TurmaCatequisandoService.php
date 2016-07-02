<?php

namespace TurmaCatequisando\Service;

use TurmaCatequisando\Entity\TurmaCatequisandoEntity as Entity;

class TurmaCatequisandoService extends Entity {

 
    public function getTurmaCatequisando($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('turma_catequisando')
             
               ->join(
                        'turma', 'turma.id_turma = turma_catequisando.id_turma'
                )
                  ->join(
                        'catequisando', 'catequisando.id_catequisando = turma_catequisando.id_catequisando'
                )
                
                  ->join(
                        'usuario', 'usuario.id_usuario = turma_catequisando.id_usuario'
                )
                  ->join(
                        'periodo_letivo', 'periodo_letido.id_periodo_letivo = turma_catequisando.id_periodo_letivo'
                )
      
                ->where([
            'turma_catequisando.id_turma_catequisando = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
}}