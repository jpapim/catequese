/*==============================================================*/
/* Table: RESPONSAVEL                                           */
/*==============================================================*/
create table RESPONSAVEL
(
   ID_RESPON            int not null,
   NOME_ESPON           varchar(45) not null,
   PARENTESCO           varchar(6) not null,
   RESPONSAVEL          int,
   MORA_RESPON          int not null,
   FALECIDO             int,
   PROFISSAO            varchar(20),
   OBS                  varchar(45),
   id_usuario_cadastro  int(11),
   id_usuario_alteracao int(11),
   id_estado_civil      int(11),
   id_telefone          int(11),
   id_email             int(11),
   id_sexo              int(11),
   primary key (ID_RESPON)
);

alter table RESPONSAVEL add constraint FK_email_responsavel foreign key (id_email)
      references email (id_email) on delete restrict on update restrict;

alter table RESPONSAVEL add constraint FK_estado_civil_responsavel foreign key (id_estado_civil)
      references estado_civil (id_estado_civil) on delete restrict on update restrict;

alter table RESPONSAVEL add constraint FK_sexo_responsavel foreign key (id_sexo)
      references sexo (id_sexo) on delete restrict on update restrict;

alter table RESPONSAVEL add constraint FK_telefone_responsavel foreign key (id_telefone)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table RESPONSAVEL add constraint FK_usuario_alter_responsavel foreign key (id_usuario_alteracao)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table RESPONSAVEL add constraint FK_usuario_cad_responsavel foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;
	  
/*==============================================================*/
/* Table: ALUNO                                                 */
/*==============================================================*/
create table ALUNO
(
   ID_ALUNO             int not null,
   NOME_ALUNO           varchar(45) not null,
   DT_NASCIMENTO        date not null,
   NECES_ESPECIAL       varchar(45),
   OBS_NECES            varchar(45),
   ESTUDA_FORA          int not null,
   PERIODO_FORA         varchar(20),
   COMPRO_BATISMO       int not null,
   OBS_COMPRO_BATISMO   varchar(45) not null,
   id_usuario_cadastro  int(11),
   id_usuario_alteracao int(11),
   id_endereco          int(11),
   id_telefone          int(11),
   id_sexo              int(11),
   id_email             int(11),
   primary key (ID_ALUNO)
);

/*==============================================================*/
/* Index: RELATIONSHIP_18_FK                                    */
/*==============================================================*/
/*create index RELATIONSHIP_18_FK on ALUNO
(
   
);*/

alter table ALUNO add constraint FK_email_aluno foreign key (id_email)
      references email (id_email) on delete restrict on update restrict;

alter table ALUNO add constraint FK_endereco_aluno foreign key (id_endereco)
      references endereco (id_endereco) on delete restrict on update restrict;

alter table ALUNO add constraint FK_sexo_aluno foreign key (id_sexo)
      references sexo (id_sexo) on delete restrict on update restrict;

alter table ALUNO add constraint FK_telefone_aluno foreign key (id_telefone)
      references telefone (id_telefone) on delete restrict on update restrict;

alter table ALUNO add constraint FK_usuario_alter_aluno foreign key (id_usuario_alteracao)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table ALUNO add constraint FK_usuario_cad_aluno foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;

/*==============================================================*/
/* Table: formacao                                              */
/*==============================================================*/
create table formacao
(
   id_formacao          int not null,
   nm_formacao          varchar(20) not null,
   curso                varchar(20),
   primary key (id_formacao)
);

/*==============================================================*/
/* Table: PROFESSOR                                             */
/*==============================================================*/
create table PROFESSOR
(
   ID_PROFESSOR         int not null,
   NOME_PROF            varchar(45) not null,
   DT_NASCIMENTO        date not null,
   DT_INGRESSO          date not null,
   OBS                  varchar(45),
   SITUACAO             int not null,
   OBS_SITUACAO         varchar(45),
   id_usuario           int(11),
   id_formacao          int,
   id_usuario_cadastro  int(11),
   id_usuario_alteracao int(11),
   primary key (ID_PROFESSOR)
);

/*==============================================================*/
/* Index: RELATIONSHIP_24_FK                                    */
/*==============================================================*/
/*create index RELATIONSHIP_24_FK on PROFESSOR
(
   
);*/


alter table PROFESSOR add constraint FK_usuairo_professor foreign key (id_usuario)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table PROFESSOR add constraint FK_usuario_alter_professor foreign key (id_usuario_alteracao)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table PROFESSOR add constraint FK_usuario_cad_professor foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;

/*==============================================================*/
/* Table: MOVIMENTO                                             */
/*==============================================================*/
create table MOVIMENTO
(
   ID_MOVIMENTO         int not null,
   NM_MOVIMENTO         varchar(25) not null,
   primary key (ID_MOVIMENTO)
);


/*==============================================================*/
/* Table: RESPON_MOVIMENTO                                      */
/*==============================================================*/
create table RESPON_MOVIMENTO
(
   ID_MOVIMENTO         int not null,
   ID_RESPON            int not null,
   SITUACAO             int,
   OBS                  varchar(45)
);

alter table RESPON_MOVIMENTO add constraint FK_RESPONSABEL_RESPON_MOVIMENTO foreign key (ID_RESPON)
      references RESPONSAVEL (ID_RESPON) on delete restrict on update restrict;

alter table RESPON_MOVIMENTO add constraint FK_movimento_respon_movimento foreign key (ID_MOVIMENTO)
      references MOVIMENTO (ID_MOVIMENTO) on delete restrict on update restrict;

/*==============================================================*/
/* Table: ALUNO_MOVIMENTO                                       */
/*==============================================================*/
create table ALUNO_MOVIMENTO
(
   ID_MOVIMENTO         int not null,
   ID_ALUNO             int not null,
   SITUACAO             int,
   OBS                  varchar(45)
);

alter table ALUNO_MOVIMENTO add constraint FK_ALUNO_ALUNO_MOVIMENTO foreign key (ID_ALUNO)
      references ALUNO (ID_ALUNO) on delete restrict on update restrict;

alter table ALUNO_MOVIMENTO add constraint FK_MOVIMENTO_ALUNO_MOVIMENTO foreign key (ID_MOVIMENTO)
      references MOVIMENTO (ID_MOVIMENTO) on delete restrict on update restrict;

/*==============================================================*/
/* Table: RESPON_ALUNO                                          */
/*==============================================================*/
create table RESPON_ALUNO
(
   ID_ALUNO             int not null,
   ID_RESPON            int not null
);

alter table RESPON_ALUNO add constraint FK_aluno_respon_aluno foreign key (ID_ALUNO)
      references ALUNO (ID_ALUNO) on delete restrict on update restrict;

alter table RESPON_ALUNO add constraint FK_responsavel_aluno foreign key (ID_RESPON)
      references RESPONSAVEL (ID_RESPON) on delete restrict on update restrict;

/*==============================================================*/
/* Table: SACRAMENTOS                                           */
/*==============================================================*/
create table SACRAMENTOS
(
   ID_SACRAMENTO        int not null,
   NM_SACRAMENTO        varchar(25) not null,
   primary key (ID_SACRAMENTO)
);

/*==============================================================*/
/* Table: ALUNO_SACRAMENTO                                      */
/*==============================================================*/
create table ALUNO_SACRAMENTO
(
   ID_SACRAMENTO        int not null,
   ID_ALUNO             int not null,
   id_cidade            int(11),
   DATA                 date,
   PAROQUIA             varchar(25)
);

/*==============================================================*/
/* Index: RELATIONSHIP_6_FK                                     */
/*==============================================================*/
/*create index RELATIONSHIP_6_FK on ALUNO_SACRAMENTO
(
   
);*/

alter table ALUNO_SACRAMENTO add constraint FK_RELATIONSHIP_5 foreign key (ID_SACRAMENTO)
      references SACRAMENTOS (ID_SACRAMENTO) on delete restrict on update restrict;

alter table ALUNO_SACRAMENTO add constraint FK_aluno_aluno_sacramento foreign key (ID_ALUNO)
      references ALUNO (ID_ALUNO) on delete restrict on update restrict;

alter table ALUNO_SACRAMENTO add constraint FK_cidade_aluno_sacramento foreign key (id_cidade)
      references cidade (id_cidade) on delete restrict on update restrict;



/*==============================================================*/
/* Table: RESPON_SACRAMENTO                                     */
/*==============================================================*/
create table RESPON_SACRAMENTO
(
   ID_RESPON            int,
   ID_SACRAMENTO        int not null,
   id_cidade            int(11),
   DATA                 date,
   PAROQUIA             varchar(25)
);

/*==============================================================*/
/* Index: RELATIONSHIP_17_FK                                    */
/*==============================================================*/
/*create index RELATIONSHIP_17_FK on RESPON_SACRAMENTO
(
   
);*/

alter table RESPON_SACRAMENTO add constraint FK_cidade_respon_sacramento foreign key (id_cidade)
      references cidade (id_cidade) on delete restrict on update restrict;

alter table RESPON_SACRAMENTO add constraint FK_responsavel_respon_sacramento foreign key (ID_RESPON)
      references RESPONSAVEL (ID_RESPON) on delete restrict on update restrict;

alter table RESPON_SACRAMENTO add constraint FK_sacramento_respon_sacramento foreign key (ID_SACRAMENTO)
      references SACRAMENTOS (ID_SACRAMENTO) on delete restrict on update restrict;

/*==============================================================*/
/* Table: ETAPA                                                 */
/*==============================================================*/
create table ETAPA
(
   ID_ETAPA             int not null,
   NOME_ETAPA           char(20) not null,
   primary key (ID_ETAPA)
);

/*==============================================================*/
/* Table: ALUNO_ETAPAS                                          */
/*==============================================================*/
create table ALUNO_ETAPAS
(
   ID_ETAPA             int,
   ID_ALUNO             int not null,
   SITUCAO              int not null
);

alter table ALUNO_ETAPAS add constraint FK_aluno_etapa foreign key (ID_ALUNO)
      references ALUNO (ID_ALUNO) on delete restrict on update restrict;

alter table ALUNO_ETAPAS add constraint FK_etapa_aluno_etapas foreign key (ID_ETAPA)
      references ETAPA (ID_ETAPA) on delete restrict on update restrict;

/*==============================================================*/
/* Table: TURMA                                                 */
/*==============================================================*/
create table TURMA
(
   ID_TURMA             int not null,
   ID_ETAPA             int,
   ID_PROFESSOR         int not null,
   NOME_TURMA           char(20) not null,
   DT_INICIO            date not null,
   primary key (ID_TURMA)
);

alter table TURMA add constraint FK_etapa_turma foreign key (ID_ETAPA)
      references ETAPA (ID_ETAPA) on delete restrict on update restrict;

alter table TURMA add constraint FK_professor_turma foreign key (ID_PROFESSOR)
      references PROFESSOR (ID_PROFESSOR) on delete restrict on update restrict;

/*==============================================================*/	  
/* Table: FREQUENCIA                                            */
/*==============================================================*/
create table FREQUENCIA
(
   ID_FREQUENCIA        int not null,
   NM_FREQUENCIA        varchar(15) not null,
   ID_TURMA             int not null,
   ID_ALUNO             int not null,
   primary key (ID_FREQUENCIA)
);

alter table FREQUENCIA add constraint FK_aluno_frequencia foreign key (ID_ALUNO)
      references ALUNO (ID_ALUNO) on delete restrict on update restrict;

alter table FREQUENCIA add constraint FK_turma_frequencia foreign key (ID_TURMA)
      references TURMA (ID_TURMA) on delete restrict on update restrict;

/*==============================================================*/
/* Table: DATA_FREQUENCIA                                       */
/*==============================================================*/
create table DATA_FREQUENCIA
(
   ID_DATAFREQ          int not null,
   DATA                 date not null,
   primary key (ID_DATAFREQ)
);

/*==============================================================*/
/* Table: FREQ_DIAS                                             */
/*==============================================================*/
create table FREQ_DIAS
(
   ID_DATAFREQ          int not null,
   ID_FREQUENCIA        int not null,
   PRESENTE             int not null,
   id_usuario_cadastro  int(11),
   id_usuario_alteracao int(11)
);

alter table FREQ_DIAS add constraint FK_RELATIONSHIP_21 foreign key (ID_DATAFREQ)
      references DATA_FREQUENCIA (ID_DATAFREQ) on delete restrict on update restrict;

alter table FREQ_DIAS add constraint FK_frequencia_freq_dias foreign key (ID_FREQUENCIA)
      references FREQUENCIA (ID_FREQUENCIA) on delete restrict on update restrict;

alter table FREQ_DIAS add constraint FK_usuario_alter_freq_dias foreign key (id_usuario_alteracao)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table FREQ_DIAS add constraint FK_usuario_cad_frea_dias foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;
	  


	  