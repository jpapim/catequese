use bdcatequese;

drop table if exists etapa;

/*==============================================================*/
/* Table: etapa                                                 */
/*==============================================================*/
create table etapa
(
   id_etapa             int not null auto_increment,
   nm_etapa             varchar(50),
   primary key (id_etapa)
);

alter table etapa comment 'Nesta tabela serão armazenadas todas as etapas que um aluno ';

drop table if exists formacao;

/*==============================================================*/
/* Table: formacao                                              */
/*==============================================================*/
create table formacao
(
   id_formacao          int(11) not null auto_increment,
   nm_formacao          varchar(50),
   primary key (id_formacao)
);

alter table formacao comment 'Armazena as opções de Formação Academica de um Catequista';

drop table if exists turno;

/*==============================================================*/
/* Table: turno                                                 */
/*==============================================================*/
create table turno
(
   id_turno             int(11) not null auto_increment,
   nm_turno             varchar(50),
   primary key (id_turno)
);

alter table turno comment 'Armazenas os Turnos de estudo. Ex: manha, Tarde, Noite ou Di';

drop table if exists sacramento;

/*==============================================================*/
/* Table: sacramento                                            */
/*==============================================================*/
create table sacramento
(
   id_sacramento        int not null auto_increment,
   nm_sacramento        varchar(50),
   primary key (id_sacramento)
);

alter table sacramento comment 'Tabela Resposável por Armazenar os sacramentos possiveis par';

drop table if exists paroquia;

/*==============================================================*/
/* Table: paroquia                                              */
/*==============================================================*/
create table paroquia
(
   id_paroquia          int not null auto_increment,
   id_cidade            int(11),
   nm_paroquia          varchar(100),
   primary key (id_paroquia)
);

alter table paroquia comment 'Armazena os dados da paróquia onde o catequisando realizou o';

alter table paroquia add constraint FK_Reference_102 foreign key (id_cidade)
      references cidade (id_cidade) on delete restrict on update restrict;

drop table if exists turma;

/*==============================================================*/
/* Table: turma                                                 */
/*==============================================================*/
create table turma
(
   id_turma             int(11) not null auto_increment,
   id_etapa             int,
   cd_turma             varchar(8),
   nm_turma             varchar(50),
   primary key (id_turma)
);

alter table turma comment 'Tabela que definirá os dados de uma turma de catequizandos';

alter table turma add constraint FK_Reference_123 foreign key (id_etapa)
      references etapa (id_etapa) on delete restrict on update restrict;

drop table if exists periodo_letivo;

drop table if exists periodo_letivo;

/*==============================================================*/
/* Table: periodo_letivo                                        */
/*==============================================================*/
create table periodo_letivo
(
   id_periodo_letivo    int(11) not null auto_increment,
   dt_inicio            datetime,
   dt_fim               datetime,
   dt_ano_letivo        char(4),
   primary key (id_periodo_letivo)
);

alter table periodo_letivo comment 'Armazena informações sobre inicio e término do periodo letiv';

drop table if exists detalhe_periodo_letivo;

/*==============================================================*/
/* Table: detalhe_periodo_letivo                                */
/*==============================================================*/
create table detalhe_periodo_letivo
(
   id_detalhe_periodo_letivo bigint not null auto_increment,
   id_periodo_letivo    int(11),
   dt_encontro          date,
   primary key (id_detalhe_periodo_letivo)
);

alter table detalhe_periodo_letivo comment 'Data que qirão compor o periodo letivo';

alter table detalhe_periodo_letivo add constraint FK_Reference_124 foreign key (id_periodo_letivo)
      references periodo_letivo (id_periodo_letivo) on delete restrict on update restrict;

drop table if exists situacao_responsavel;

/*==============================================================*/
/* Table: situacao_responsavel                                  */
/*==============================================================*/
create table situacao_responsavel
(
   id_situacao_responsavel int(11) not null auto_increment,
   ds_situacao_responsavel varchar(50),
   cs_pai_mae           char(1),
   primary key (id_situacao_responsavel)
);

alter table situacao_responsavel comment 'Armazena a situação do responsavel. Ex. Mora com pai, pai fa';

drop table if exists grau_parentesco;

/*==============================================================*/
/* Table: grau_parentesco                                       */
/*==============================================================*/
create table grau_parentesco
(
   id_grau_parentesco   int(11) not null auto_increment,
   nm_grau_parentesco   varchar(45),
   primary key (id_grau_parentesco)
);

alter table grau_parentesco comment 'Armazena o Grau de parentesco entre o catequisando e o respo';

drop table if exists movimento_pastoral;

/*==============================================================*/
/* Table: movimento_pastoral                                    */
/*==============================================================*/
create table movimento_pastoral
(
   id_movimento_pastoral int not null auto_increment,
   nm_movimento_pastoral varchar(50),
   primary key (id_movimento_pastoral)
);

alter table movimento_pastoral comment 'Tabela responsável por armazenar todos os movimentos que a c';

drop table if exists situacao_conjugal;

/*==============================================================*/
/* Table: situacao_conjugal                                     */
/*==============================================================*/
create table situacao_conjugal
(
   id_situacao_conjugal int(11) not null auto_increment,
   ds_situacao_conjugal varchar(50),
   primary key (id_situacao_conjugal)
);

alter table situacao_conjugal comment 'Armazena a situacao conjugal dos pais do catequisando. Ex: S';

drop table if exists profissao;

/*==============================================================*/
/* Table: profissao                                             */
/*==============================================================*/
create table profissao
(
   id_profissao         int(11) not null auto_increment,
   nm_profissao         varchar(100),
   primary key (id_profissao)
);

alter table profissao comment 'Armazena a profissão do responsavel';

drop table if exists detalhe_formacao;

/*==============================================================*/
/* Table: detalhe_formacao                                      */
/*==============================================================*/
create table detalhe_formacao
(
   id_detalhe_formacao  int not null auto_increment,
   id_formacao          int(11),
   ds_detalhe_formacao  varchar(50),
   primary key (id_detalhe_formacao)
);

alter table detalhe_formacao comment 'Armazena os detalhes da formação, como o nome do curso de gr';

alter table detalhe_formacao add constraint FK_Reference_88 foreign key (id_formacao)
      references formacao (id_formacao) on delete restrict on update restrict;


drop table if exists responsavel;

/*==============================================================*/
/* Table: responsavel                                           */
/*==============================================================*/
create table responsavel
(
   id_responsavel       int(11) not null auto_increment,
   id_sexo              int(11),
   id_telefone_celular  int(11),
   id_telefone_residencial int(11),
   id_email             int(11),
   id_profissao         int(11),
   id_movimento_pastoral int,
   nm_responsavel       varchar(50),
   tx_observacao        text,
   cs_participa_movimento_pastoral char(1),
   primary key (id_responsavel)
);

alter table responsavel comment 'Analogo a tabela pessoa e armazena todos os dados de uma pes';

alter table responsavel add constraint FK_Reference_106 foreign key (id_sexo)
      references sexo (id_sexo) on delete restrict on update restrict;

alter table responsavel add constraint FK_Reference_107 foreign key (id_telefone_celular)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table responsavel add constraint FK_Reference_108 foreign key (id_telefone_residencial)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table responsavel add constraint FK_Reference_109 foreign key (id_email)
      references email (id_email) on delete restrict on update restrict;

alter table responsavel add constraint FK_Reference_110 foreign key (id_profissao)
      references profissao (id_profissao) on delete restrict on update restrict;

alter table responsavel add constraint FK_Reference_111 foreign key (id_movimento_pastoral)
      references movimento_pastoral (id_movimento_pastoral) on delete restrict on update restrict;


drop table if exists catequisando;

/*==============================================================*/
/* Table: catequisando                                          */
/*==============================================================*/
create table catequisando
(
   id_catequisando      int not null auto_increment,
   id_endereco          int(11),
   id_sexo              int(11),
   id_naturalidade      int(11),
   id_telefone_residencial int(11),
   id_telefone_celular  int(11),
   id_email             int(11),
   id_situacao          int(11),
   id_turno             int(11),
   id_movimento_pastoral int,
   nm_catequisando      varchar(150),
   nr_matricula         varchar(6),
   dt_nascimento        timestamp,
   dt_ingresso          timestamp,
   tx_observacao        text,
   ds_situacao          varchar(100),
   cs_necessidade_especial char(1),
   nm_necessidade_especial varchar(50),
   cs_estudante         char(1),
   cs_participa_movimento_pastoral char(1),
   primary key (id_catequisando)
);

alter table catequisando add constraint FK_Reference_103 foreign key (id_movimento_pastoral)
      references movimento_pastoral (id_movimento_pastoral) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_90 foreign key (id_sexo)
      references sexo (id_sexo) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_91 foreign key (id_endereco)
      references endereco (id_endereco) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_92 foreign key (id_naturalidade)
      references cidade (id_cidade) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_94 foreign key (id_telefone_residencial)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_95 foreign key (id_telefone_celular)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_96 foreign key (id_email)
      references email (id_email) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_97 foreign key (id_situacao)
      references situacao (id_situacao) on delete restrict on update restrict;

alter table catequisando add constraint FK_Reference_98 foreign key (id_turno)
      references turno (id_turno) on delete restrict on update restrict;

	  
drop table if exists catequista;

/*==============================================================*/
/* Table: catequista                                            */
/*==============================================================*/
create table catequista
(
   id_catequista        int not null auto_increment,
   id_usuario           int(11),
   id_endereco          int(11),
   id_sexo              int(11),
   id_naturalidade      int(11),
   id_telefone_residencial int(11),
   id_telefone_celular  int(11),
   id_email             int(11),
   id_situacao          int(11),
   id_detalhe_formacao  int,
   nm_catequista        varchar(50),
   nr_matricula         varchar(6),
   dt_nascimento        timestamp,
   dt_ingresso          timestamp,
   tx_observacao        text,
   ds_situacao          varchar(100),
   cs_coordenador       char(1),
   primary key (id_catequista)
);

alter table catequista add constraint FK_Reference_133 foreign key (id_detalhe_formacao)
      references detalhe_formacao (id_detalhe_formacao) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_80 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_81 foreign key (id_endereco)
      references endereco (id_endereco) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_82 foreign key (id_sexo)
      references sexo (id_sexo) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_83 foreign key (id_naturalidade)
      references cidade (id_cidade) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_84 foreign key (id_telefone_residencial)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_85 foreign key (id_telefone_celular)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_86 foreign key (id_email)
      references email (id_email) on delete restrict on update restrict;

alter table catequista add constraint FK_Reference_89 foreign key (id_situacao)
      references situacao (id_situacao) on delete restrict on update restrict;
	  
drop table if exists turma_catequisando;

/*==============================================================*/
/* Table: turma_catequisando                                    */
/*==============================================================*/
create table turma_catequisando
(
   id_turma_catequisando bigint not null auto_increment,
   id_turma             int(11),
   id_catequisando      int,
   id_usuario           int(11),
   id_periodo_letivo    int(11),
   dt_cadastro          timestamp,
   cs_aprovado          char(1),
   ds_motivo_reprovacao varchar(1000),
   tx_observacoes       text,
   primary key (id_turma_catequisando)
);

alter table turma_catequisando comment 'Tabela que Armazena todos os Catequizandos por Turma';

alter table turma_catequisando add constraint FK_Reference_127 foreign key (id_turma)
      references turma (id_turma) on delete restrict on update restrict;

alter table turma_catequisando add constraint FK_Reference_128 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

alter table turma_catequisando add constraint FK_Reference_129 foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table turma_catequisando add constraint FK_Reference_132 foreign key (id_periodo_letivo)
      references periodo_letivo (id_periodo_letivo) on delete restrict on update restrict;


drop table if exists frequencia_turma;

/*==============================================================*/
/* Table: frequencia_turma                                      */
/*==============================================================*/
create table frequencia_turma
(
   id_frequencia_turma  bigint not null auto_increment,
   id_turma_catequisando bigint,
   id_detalhe_periodo_letivo bigint,
   primary key (id_frequencia_turma)
);

alter table frequencia_turma add constraint FK_Reference_130 foreign key (id_turma_catequisando)
      references turma_catequisando (id_turma_catequisando) on delete restrict on update restrict;

alter table frequencia_turma add constraint FK_Reference_131 foreign key (id_detalhe_periodo_letivo)
      references detalhe_periodo_letivo (id_detalhe_periodo_letivo) on delete restrict on update restrict;
	  

drop table if exists situacao_responsavel_catequisando;

/*==============================================================*/
/* Table: situacao_responsavel_catequisando                     */
/*==============================================================*/
create table situacao_responsavel_catequisando
(
   id_situacao_responsavel_catequisando int(11) not null auto_increment,
   id_catequisando      int,
   id_situacao_responsavel int(11),
   primary key (id_situacao_responsavel_catequisando)
);

alter table situacao_responsavel_catequisando add constraint FK_Reference_121 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

alter table situacao_responsavel_catequisando add constraint FK_Reference_122 foreign key (id_situacao_responsavel)
      references situacao_responsavel (id_situacao_responsavel) on delete restrict on update restrict;

	  
drop table if exists sacramento_responsavel;

/*==============================================================*/
/* Table: sacramento_responsavel                                */
/*==============================================================*/
create table sacramento_responsavel
(
   id_sacramento_responsavel int(11) not null auto_increment,
   id_sacramento        int,
   id_responsavel       int(11),
   primary key (id_sacramento_responsavel)
);

alter table sacramento_responsavel add constraint FK_Reference_112 foreign key (id_sacramento)
      references sacramento (id_sacramento) on delete restrict on update restrict;

alter table sacramento_responsavel add constraint FK_Reference_113 foreign key (id_responsavel)
      references responsavel (id_responsavel) on delete restrict on update restrict;

drop table if exists responsavel_catequisando;

/*==============================================================*/
/* Table: responsavel_catequisando                              */
/*==============================================================*/
create table responsavel_catequisando
(
   id_responsavel_catequisando int(11) not null auto_increment,
   id_responsavel       int(11),
   id_catequisando      int,
   id_grau_parentesco   int(11),
   primary key (id_responsavel_catequisando)
);

alter table responsavel_catequisando add constraint FK_Reference_114 foreign key (id_responsavel)
      references responsavel (id_responsavel) on delete restrict on update restrict;

alter table responsavel_catequisando add constraint FK_Reference_115 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

alter table responsavel_catequisando add constraint FK_Reference_116 foreign key (id_grau_parentesco)
      references grau_parentesco (id_grau_parentesco) on delete restrict on update restrict;

drop table if exists pais_catequisando;

/*==============================================================*/
/* Table: pais_catequisando                                     */
/*==============================================================*/
create table pais_catequisando
(
   id_pais_catequisando int(11) not null auto_increment,
   id_pai               int(11),
   id_mae               int(11),
   id_catequisando      int,
   id_situacao_conjugal int(11),
   primary key (id_pais_catequisando)
);

alter table pais_catequisando add constraint FK_Reference_117 foreign key (id_pai)
      references responsavel (id_responsavel) on delete restrict on update restrict;

alter table pais_catequisando add constraint FK_Reference_118 foreign key (id_mae)
      references responsavel (id_responsavel) on delete restrict on update restrict;

alter table pais_catequisando add constraint FK_Reference_119 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

alter table pais_catequisando add constraint FK_Reference_120 foreign key (id_situacao_conjugal)
      references situacao_conjugal (id_situacao_conjugal) on delete restrict on update restrict;

drop table if exists catequisanto_etapa_cursou;

/*==============================================================*/
/* Table: catequisanto_etapa_cursou                             */
/*==============================================================*/
create table catequisanto_etapa_cursou
(
   id_catequisanto_etapa_cursou int(11) not null auto_increment,
   id_etapa             int,
   id_catequisando      int,
   dt_cadastro          timestamp,
   primary key (id_catequisanto_etapa_cursou)
);

alter table catequisanto_etapa_cursou add constraint FK_Reference_104 foreign key (id_etapa)
      references etapa (id_etapa) on delete restrict on update restrict;

alter table catequisanto_etapa_cursou add constraint FK_Reference_105 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

drop table if exists catequista_etapa_atuacao;

/*==============================================================*/
/* Table: catequista_etapa_atuacao                              */
/*==============================================================*/
create table catequista_etapa_atuacao
(
   id_catequista_etapa_atuacao int not null auto_increment,
   id_catequista        int,
   id_etapa             int,
   dt_cadastro          timestamp,
   primary key (id_catequista_etapa_atuacao)
);

alter table catequista_etapa_atuacao add constraint FK_Reference_78 foreign key (id_catequista)
      references catequista (id_catequista) on delete restrict on update restrict;

alter table catequista_etapa_atuacao add constraint FK_Reference_79 foreign key (id_etapa)
      references etapa (id_etapa) on delete restrict on update restrict;

drop table if exists catequista_turma;

/*==============================================================*/
/* Table: catequista_turma                                      */
/*==============================================================*/
create table catequista_turma
(
   id_catequista_turma  int(11) not null auto_increment,
   id_turma             int(11),
   id_catequista        int,
   primary key (id_catequista_turma)
);

alter table catequista_turma comment 'Armazena os Catequistas Responsaveis por uma turma';

alter table catequista_turma add constraint FK_Reference_125 foreign key (id_turma)
      references turma (id_turma) on delete restrict on update restrict;

alter table catequista_turma add constraint FK_Reference_126 foreign key (id_catequista)
      references catequista (id_catequista) on delete restrict on update restrict;

	  
drop table if exists sacramento_catequisando;

/*==============================================================*/
/* Table: sacramento_catequisando                               */
/*==============================================================*/
create table sacramento_catequisando
(
   id_sacramento_catequisando int(11) not null auto_increment,
   id_catequisando      int,
   id_sacramento        int,
   id_paroquia          int,
   dt_cadastro          timestamp,
   cs_comprovante_batismo char(1),
   primary key (id_sacramento_catequisando)
);

alter table sacramento_catequisando add constraint FK_Reference_100 foreign key (id_sacramento)
      references sacramento (id_sacramento) on delete restrict on update restrict;

alter table sacramento_catequisando add constraint FK_Reference_101 foreign key (id_paroquia)
      references paroquia (id_paroquia) on delete restrict on update restrict;

alter table sacramento_catequisando add constraint FK_Reference_99 foreign key (id_catequisando)
      references catequisando (id_catequisando) on delete restrict on update restrict;

	  
DROP VIEW `bdcatequese`.`vw_regras_lutas`;	  





	  
