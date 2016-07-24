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
        'Banco',
        'Principal',
        'Email',
        'Usuario',
        'Perfil',
        'EsqueciSenha',
        'Config',
        'Cidade',
        'Estado',
        'Sexo',
        'EstadoCivil',
        'TipoUsuario',
        'SituacaoUsuario',
        'Endereco',
        'ArteMarcial',
        'Estilo',
        'Graduacao',
        'TipoEvento',
        'Evento',
        'Academia',
        'Atleta',
        'CategoriaPeso',
        'CategoriaIdade',
        'RegrasLutas',
        'DetalhesRegrasLuta',
        'InscricoesEvento',
        'ChavesLuta',
        #'ContaBancaria',
        #'DOMPDFModule',
        #'Gerador',
        'Login',
        #'PhpBoletoZf2',
        'Telefone',
        #'TipoConta',
        'TipoTelefone',
        'PeriodoLetivo',
        'DetalhePeriodoLetivo',
        'Sacramento',
        'SacramentoCatequisando',
        'MovimentoPastoral',
        'Controller',
        'Action',
        'Permissao',
        'Paroquia',
        'PerfilControllerAction',
        'Catequista',
        'Etapa',
        'Turma',
        'Turno',
        'TurmaCatequisando',
        'Formacao',
        'DetalheFormacao',
        'Infra',
        'GrauParentesco',
        'ResponsavelCatequisando',
        'SituacaoConjugal',
        'Profissao',
        'SituacaoResponsavel',
        'Catequisando',
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
