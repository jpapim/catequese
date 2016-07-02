<?php

namespace Turma\Service;

use Turma\Entity\TurmaEntity as Entity;

class TurmaService extends Entity {

    /**
     * 
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getTurma($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('turma')
             
               ->join(
                        'etapa', 'etapa.id_etapa = turma.id_etapa'
                )
      
                ->where([
            'turma.id_turma = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoTurmaCadastro($configList) {

        //Busca os usuarios cadastrados
        $turmaService = $this->getServiceLocator()->get('Turma\Service\TurmaService');
        $resultSetTurmas = $turmaService->filtrarObjeto();

        /* @var $contratoAsContratoService \ContratoAsContrato\Service\ContratoAsContratoService */
        $contratoAsContratoService = $this->getServiceLocator()->get('\ContratoAsContrato\Service\ContratoAsContratoService');
            
        foreach ($resultSetTurmas as $turmaEntity) {

            /* @var $contratoService \Contrato\Service\ContratoService */
            $contratoService = $this->getServiceLocator()->get("\Contrato\Service\ContratoService");
            $contratoService->setIdTurma($turmaEntity->getId());
            $contrato = $contratoService->filtrarObjeto()->current();

            $contratoAsContratoService->setIdContrato($contrato->getId());
            $contratoAsContratoService->setIdNivel(1);
            

            if ($contratoAsContratoService->filtrarObjeto()->count() < $configList['qtd_por_nivel']) {

                return $turmaEntity->getId();
            }
        }
        return NULL;
    }
}

