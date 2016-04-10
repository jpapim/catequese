<?php

namespace DetalhesRegrasLuta\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class DetalhesRegrasLutaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('detalhesregraslutaform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalhesregraslutaform',$this,$this->inputFilter);

        $objForm->hidden("id")
            ->required(false)
            ->label("Id");

        $objForm->hidden("id_usuario_cadastro")
            ->required(false)
            ->label("Usuario Cadastrador");

        $objForm->combo("id_regra_luta", '\RegrasLutas\Service\RegrasLutasService', 'id', 'nm_regra_luta')
            ->required(true)
            ->label("Regra de Luta")
            ->setAttribute('title', 'Selecione a regra a ser configurada');

        $objForm->combo("id_categoria_idade", '\CategoriaIdade\Service\CategoriaIdadeService', 'id', 'nm_categoria_idade')
            ->required(true)
            ->label("Categoria da Idade")
            ->setAttribute('title', 'Selecione a categoria de idade');

        $objForm->integer("nr_idade_inicial")
            ->required(true)
            ->label("Idade inicial")
            ->setAttribute('title', 'Insira a idade inicial para a categoria de idade selecionada');

        $objForm->integer("nr_idade_final")
            ->required(true)
            ->label("Idade  Final")
            ->setAttribute('title', 'Insira a idade inicial para a categoria de idade selecionada');

        $objForm->combo("id_categoria_peso", '\CategoriaPeso\Service\CategoriaPesoService', 'id', 'nm_categoria_peso')
            ->required(true)
            ->label("Categoria do Peso")
            ->setAttribute('title', 'Selecione a categoria de peso');

        $objForm->number("nr_peso_inicial", 3)
            ->required(true)
            ->label("Peso Inicial")
            ->setAttribute('title', 'Insira o peso inicial para a categoria de peso e idade selecionadas');

        $objForm->number("nr_peso_final", 3)
            ->required(true)
            ->label("Peso Final")
            ->setAttribute('title', 'Insira o peso final para a categoria de peso e idade selecionadas');

        $objForm->combo("id_sexo", '\Sexo\Service\SexoService', 'id', 'nm_sexo')
            ->required(true)
            ->label("Sexo")
            ->setAttribute('title', 'Escolha o sexo');

        $objForm->combo("id_graduacao_inicial", '\Graduacao\Service\GraduacaoService', 'id', 'nm_graduacao')
            ->required(true)
            ->label("Graduaçao Inicial")
            ->setAttribute('title', 'Insira a graduação inicial para a categoria de peso e idade selecionadas');

        $objForm->combo("id_graduacao_final", '\Graduacao\Service\GraduacaoService', 'id', 'nm_graduacao')
            ->required(true)
            ->label("Graduaçao Final")
            ->setAttribute('title', 'Insira a graduação final para a categoria de peso e idade selecionadas');

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}