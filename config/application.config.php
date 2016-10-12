<?php


return array(
    'modules' => array(
        'Application',
        'Auth',
        'Estrutura', //Tem que vir antes dos demais módulos
        //Para Testar: http://admin.mcnetwork.com.br/assets/compact-js/jquery.min.js,bootstrap.min.js,ie-emulation-modes-warning.js,transition.js,collapse.js
        //http://dev.catequese.com.br/assets/compact-js/jquery.min.js,bootstrap.min.js
        'CompactAsset', //Compacta o Javascript e CSS para retornar em apenas uma requisição (Responsável pela minificar o css e js: compila os arquivos em um só)
        //Ronaldo 02/03/2016 - Responsável por melhorar o desempenho da aplicação
        'EdpSuperluminal', //http://dev.catequese.com.br/?EDPSUPERLUMINAL_CACHE - Execute isso na URL para compilar os arquivos e ficar mais rapido - em cada requisição, em vês de baixar em tempo de execução cada require do autoload, ele salva um unico arquivo, minificado, com todas as classes dentro
        'Situacao',
        'Principal',
        'Email',
        'Usuario',
        'Perfil',
        'EsqueciSenha',
        'Config',
        'Cidade',
        'Estado',
        'Sexo',
        'TipoUsuario',
        'SituacaoUsuario',
        'Endereco',
        'DOMPDFModule',
        'Gerador',
        'Login',
        #'PhpBoletoZf2',
        'Telefone',
        'TipoTelefone',
        'PeriodoLetivo',
        'DetalhePeriodoLetivo',
        'Sacramento',
        'SacramentoCatequizando',
        'MovimentoPastoral',
        'Controller',
        'Action',
        'Permissao',
        'Paroquia',
        'PerfilControllerAction',
        'Catequista',
        'Catequizando',
        'Etapa',
        'Turma',
        'FrequenciaTurma',
        'Turno',
        'TurmaCatequizando',
        'Formacao',
        'DetalheFormacao',
        'Infra',
        'GrauParentesco',
        'ResponsavelCatequizando',
        'SituacaoConjugal',
        'Profissao',
        'SituacaoResponsavel',
        'Responsavel',
        'CatequistaTurma',
        'CatequizandoEtapaCursou',
        'SacramentoResponsavel',
        'SituacaoResponsavelCatequizando',
        'CatequistaEtapaAtuacao',
        'EstadoCivil',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,' . APPLICATION_ENV . '}.php'
        ),
    )
);
