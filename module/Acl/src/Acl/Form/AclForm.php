<?php

namespace Acl\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AclForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('aclform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('aclform',$this,$this->inputFilter);
        $objForm->combo("id_perfil", '\Perfil\Service\PerfilService', 'id', 'nm_perfil')->required(true)->label("Perfil");  
        $objForm->textarea("nm_resource")->required(false)->label("NmResource");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}