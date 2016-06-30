<?php

namespace Catequista\Service;

use Catequista\Entity\CatequistaEntity as Entity;

class CatequistaService extends Entity {

    /**
     * 
     * @param type $auth
     * @param type $nivel
     * @return type
     */
    public function getCatequista($id) {

        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());

        //die($id);
        $select = $sql->select('catequista')
             
               ->join(
                        'sexo', 'sexo.id_sexo = catequista.id_sexo'
                )
                   
               
                ->join(
                        'email', 'email.id_email = catequista.id_email'
                )
                            
               
               
                
               
                ->where([
            'catequista.id_catequista = ?' => $id,
        ]);
        //print_r($sql->prepareStatementForSqlObject($select)->execute());exit;

        return $sql->prepareStatementForSqlObject($select)->execute()->current();
    }

    /**
     * 
     * @return type
     */
    public function getIdProximoCatequistaCadastro($configList) {

        //Busca os usuarios cadastrados
        $catequistaService = $this->getServiceLocator()->get('Catequista\Service\CatequistaService');
        $resultSetCatequistas = $catequistaService->filtrarObjeto();

        /* @var $contratoAsContratoService \ContratoAsContrato\Service\ContratoAsContratoService */
        $contratoAsContratoService = $this->getServiceLocator()->get('\ContratoAsContrato\Service\ContratoAsContratoService');
            
        foreach ($resultSetCatequistas as $catequistaEntity) {

            /* @var $contratoService \Contrato\Service\ContratoService */
            $contratoService = $this->getServiceLocator()->get("\Contrato\Service\ContratoService");
            $contratoService->setIdCatequista($catequistaEntity->getId());
            $contrato = $contratoService->filtrarObjeto()->current();

            $contratoAsContratoService->setIdContrato($contrato->getId());
            $contratoAsContratoService->setIdNivel(1);
            

            if ($contratoAsContratoService->filtrarObjeto()->count() < $configList['qtd_por_nivel']) {

                return $catequistaEntity->getId();
            }
        }
        return NULL;
    }
}
