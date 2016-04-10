/*==============================================================*/
/* DBMS name:      Microsoft SQL Server 2008                    */
/* Created on:     02/01/2015 19:28:37                          */
/*==============================================================*/


if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ASSOCIACOES') and o.name = 'FK_TB_ASSOC_REFERENCE_TB_CIDAD')
alter table TB_ASSOCIACOES
   drop constraint FK_TB_ASSOC_REFERENCE_TB_CIDAD
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ASSOCIACOES') and o.name = 'FK_TB_ASSCI_REFERENCE_TB_USUAR2')
alter table TB_ASSOCIACOES
   drop constraint FK_TB_ASSCI_REFERENCE_TB_USUAR2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ASSOCIACOES') and o.name = 'FK_TB_ASSOC_REFERENCE_TB_USUAR')
alter table TB_ASSOCIACOES
   drop constraint FK_TB_ASSOC_REFERENCE_TB_USUAR
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ASSOCIACOES') and o.name = 'FK_TB_ASSOC_REFERENCE_TB_ARTES')
alter table TB_ASSOCIACOES
   drop constraint FK_TB_ASSOC_REFERENCE_TB_ARTES
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ATLETAS') and o.name = 'FK_TB_ATLET_REFERENCE_TB_ASSOC')
alter table TB_ATLETAS
   drop constraint FK_TB_ATLET_REFERENCE_TB_ASSOC
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ATLETAS') and o.name = 'FK_TB_ATLET_REFERENCE_TB_USUAR2')
alter table TB_ATLETAS
   drop constraint FK_TB_ATLET_REFERENCE_TB_USUAR2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ATLETAS') and o.name = 'FK_TB_ATLET_REFERENCE_TB_USUAR')
alter table TB_ATLETAS
   drop constraint FK_TB_ATLET_REFERENCE_TB_USUAR
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_ATLETAS') and o.name = 'FK_TB_ATLET_REFERENCE_TB_CIDAD')
alter table TB_ATLETAS
   drop constraint FK_TB_ATLET_REFERENCE_TB_CIDAD
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_CIDADES') and o.name = 'FK_TB_CIDAD_REFERENCE_TB_UFS')
alter table TB_CIDADES
   drop constraint FK_TB_CIDAD_REFERENCE_TB_UFS
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_REGRA')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_REGRA
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_CATEG2')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_CATEG2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_CATEG')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_CATEG
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_USUAR')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_USUAR
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_GRADU2')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_GRADU2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_DETALHES_REGRAS_LUTA') and o.name = 'FK_TB_DETAL_REFERENCE_TB_GRADU')
alter table TB_DETALHES_REGRAS_LUTA
   drop constraint FK_TB_DETAL_REFERENCE_TB_GRADU
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_EVENTOS') and o.name = 'FK_TB_EVENT_REFERENCE_TB_TIPOS')
alter table TB_EVENTOS
   drop constraint FK_TB_EVENT_REFERENCE_TB_TIPOS
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_GRADUACOES') and o.name = 'FK_TB_GRADU_REFERENCE_TB_ARTES')
alter table TB_GRADUACOES
   drop constraint FK_TB_GRADU_REFERENCE_TB_ARTES
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_GRADUACOES') and o.name = 'FK_TB_GRADU_REFERENCE_TB_ESTIL')
alter table TB_GRADUACOES
   drop constraint FK_TB_GRADU_REFERENCE_TB_ESTIL
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_GRADUACOES_ATLETAS') and o.name = 'FK_TB_GRADU_REFERENCE_TB_ATLET')
alter table TB_GRADUACOES_ATLETAS
   drop constraint FK_TB_GRADU_REFERENCE_TB_ATLET
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_GRADUACOES_ATLETAS') and o.name = 'FK_TB_GRADU_REFERENCE_TB_GRADU')
alter table TB_GRADUACOES_ATLETAS
   drop constraint FK_TB_GRADU_REFERENCE_TB_GRADU
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ASSOCIACOES') and o.name = 'FK_TB_HISTO_REFERENCE_TB_ASSOC')
alter table TB_HISTORICO_ASSOCIACOES
   drop constraint FK_TB_HISTO_REFERENCE_TB_ASSOC
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ASSOCIACOES') and o.name = 'FK_TB_HISTO_REFERENCE_TB_USUAR')
alter table TB_HISTORICO_ASSOCIACOES
   drop constraint FK_TB_HISTO_REFERENCE_TB_USUAR
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ASSOCIACOES') and o.name = 'FK_TB_HISTO_REFERENCE_TB_CIDAD')
alter table TB_HISTORICO_ASSOCIACOES
   drop constraint FK_TB_HISTO_REFERENCE_TB_CIDAD
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ATLETAS') and o.name = 'FK_TB_HISTO_REFERENCE_TB_ATLET')
alter table TB_HISTORICO_ATLETAS
   drop constraint FK_TB_HISTO_REFERENCE_TB_ATLET
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ATLETAS') and o.name = 'FK_TB_HISTO_REFERENCE_TB_USUAR2')
alter table TB_HISTORICO_ATLETAS
   drop constraint FK_TB_HISTO_REFERENCE_TB_USUAR2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ATLETAS') and o.name = 'FK_TB_HISTO_REFERENCE_TB_ASSCI2')
alter table TB_HISTORICO_ATLETAS
   drop constraint FK_TB_HISTO_REFERENCE_TB_ASSCI2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_HISTORICO_ATLETAS') and o.name = 'FK_TB_HISTO_REFERENCE_TB_CIDAD2')
alter table TB_HISTORICO_ATLETAS
   drop constraint FK_TB_HISTO_REFERENCE_TB_CIDAD2
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_INSCRITOS_EVENTO') and o.name = 'FK_TB_INSCR_REFERENCE_TB_EVENT')
alter table TB_INSCRITOS_EVENTO
   drop constraint FK_TB_INSCR_REFERENCE_TB_EVENT
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_INSCRITOS_EVENTO') and o.name = 'FK_TB_INSCR_REFERENCE_TB_ATLET')
alter table TB_INSCRITOS_EVENTO
   drop constraint FK_TB_INSCR_REFERENCE_TB_ATLET
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_PREFERENCIAS') and o.name = 'FK_TB_PREFE_REFERENCE_TB_ASSOC')
alter table TB_PREFERENCIAS
   drop constraint FK_TB_PREFE_REFERENCE_TB_ASSOC
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_PREFERENCIAS') and o.name = 'FK_TB_PREFE_REFERENCE_TB_USUAR')
alter table TB_PREFERENCIAS
   drop constraint FK_TB_PREFE_REFERENCE_TB_USUAR
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_PREFERENCIAS') and o.name = 'FK_TB_PREFE_REFERENCE_TB_REGRA')
alter table TB_PREFERENCIAS
   drop constraint FK_TB_PREFE_REFERENCE_TB_REGRA
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('TB_USUARIOS') and o.name = 'FK_TB_USUAR_REFERENCE_TB_PERFI')
alter table TB_USUARIOS
   drop constraint FK_TB_USUAR_REFERENCE_TB_PERFI
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_ARTES_MARCIAIS')
            and   type = 'U')
   drop table TB_ARTES_MARCIAIS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_ASSOCIACOES')
            and   type = 'U')
   drop table TB_ASSOCIACOES
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_ATLETAS')
            and   type = 'U')
   drop table TB_ATLETAS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_CATEGORIA_IDADE')
            and   type = 'U')
   drop table TB_CATEGORIA_IDADE
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_CATEGORIA_PESO')
            and   type = 'U')
   drop table TB_CATEGORIA_PESO
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_CIDADES')
            and   type = 'U')
   drop table TB_CIDADES
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_DETALHES_REGRAS_LUTA')
            and   type = 'U')
   drop table TB_DETALHES_REGRAS_LUTA
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_ESTILOS')
            and   type = 'U')
   drop table TB_ESTILOS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_EVENTOS')
            and   type = 'U')
   drop table TB_EVENTOS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_GRADUACOES')
            and   type = 'U')
   drop table TB_GRADUACOES
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_GRADUACOES_ATLETAS')
            and   type = 'U')
   drop table TB_GRADUACOES_ATLETAS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_HISTORICO_ASSOCIACOES')
            and   type = 'U')
   drop table TB_HISTORICO_ASSOCIACOES
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_HISTORICO_ATLETAS')
            and   type = 'U')
   drop table TB_HISTORICO_ATLETAS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_INSCRITOS_EVENTO')
            and   type = 'U')
   drop table TB_INSCRITOS_EVENTO
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_PERFIS')
            and   type = 'U')
   drop table TB_PERFIS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_PREFERENCIAS')
            and   type = 'U')
   drop table TB_PREFERENCIAS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_REGRAS_LUTAS')
            and   type = 'U')
   drop table TB_REGRAS_LUTAS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_TIPOS_EVENTOS')
            and   type = 'U')
   drop table TB_TIPOS_EVENTOS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_UFS')
            and   type = 'U')
   drop table TB_UFS
go

if exists (select 1
            from  sysobjects
           where  id = object_id('TB_USUARIOS')
            and   type = 'U')
   drop table TB_USUARIOS
go

/*==============================================================*/
/* Table: TB_ARTES_MARCIAIS                                     */
/*==============================================================*/
create table TB_ARTES_MARCIAIS (
   ID_ARTE_MARCIAL      smallint             identity,
   NM_ARTE_MARCIAL      varchar(50)          not null,
   constraint PK_TB_ARTES_MARCIAIS primary key (ID_ARTE_MARCIAL)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_ARTES_MARCIAIS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_artes_marciais', 
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ARTES_MARCIAIS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ARTE_MARCIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS', 'column', 'ID_ARTE_MARCIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_arte_marcial',
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS', 'column', 'ID_ARTE_MARCIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ARTES_MARCIAIS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ARTE_MARCIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS', 'column', 'NM_ARTE_MARCIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_arte_marcial',
   'user', @CurrentUser, 'table', 'TB_ARTES_MARCIAIS', 'column', 'NM_ARTE_MARCIAL'
go

/*==============================================================*/
/* Table: TB_ASSOCIACOES                                        */
/*==============================================================*/
create table TB_ASSOCIACOES (
   ID_ASSOCIACAO        int                  identity,
   ID_CIDADE            int                  null,
   ID_USUARIO_CADASTRO  int                  null,
   ID_USUARIO           int                  null,
   ID_ARTE_MARCIAL      smallint             null,
   NM_ASSOCIACAO        nvarchar(100)        null,
   DT_CADASTRO          datetime2            null,
   TX_ENDERECO          varchar(200)         null,
   NR_CEP               varchar(12)          null,
   BO_EXCLUIDO          bit                  null,
   constraint PK_TB_ASSOCIACOES primary key (ID_ASSOCIACAO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_ASSOCIACOES') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_associacoes', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_associacao',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_cidade',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_USUARIO_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario_cadastro',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_USUARIO_CADASTRO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ARTE_MARCIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_ARTE_MARCIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_arte_marcial',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'ID_ARTE_MARCIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'NM_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_associacao',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'NM_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'DT_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_cadastro',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'DT_CADASTRO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'TX_ENDERECO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'TX_ENDERECO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'tx_endereco',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'TX_ENDERECO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_CEP')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'NR_CEP'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_cep',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'NR_CEP'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EXCLUIDO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'BO_EXCLUIDO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_excluido',
   'user', @CurrentUser, 'table', 'TB_ASSOCIACOES', 'column', 'BO_EXCLUIDO'
go

/*==============================================================*/
/* Table: TB_ATLETAS                                            */
/*==============================================================*/
create table TB_ATLETAS (
   ID_ATLETA            int                  identity,
   ID_ASSOCIACAO        int                  not null,
   ID_CIDADE            int                  null,
   ID_USUARIO_CADASTRO  int                  not null,
   ID_USUARIO           int                  null,
   NM_ATLETA            nvarchar(50)         not null,
   DT_CADASTRO          datetime2            null,
   TX_ENDERECO          varchar(200)         null,
   NR_CEP               varchar(12)          null,
   BO_EXCLUIDO          bit                  null,
   DT_NASCIMENTO        datetime2            not null,
   constraint PK_TB_ATLETAS primary key (ID_ATLETA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_ATLETAS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_ATLETAS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_atletas', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_atleta',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_associacao',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_cidade',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_USUARIO_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario_cadastro',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_USUARIO_CADASTRO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'ID_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'NM_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_atleta',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'NM_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'DT_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_cadastro',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'DT_CADASTRO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'TX_ENDERECO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'TX_ENDERECO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'tx_endereco',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'TX_ENDERECO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_CEP')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'NR_CEP'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_cep',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'NR_CEP'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EXCLUIDO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'BO_EXCLUIDO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_excluido',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'BO_EXCLUIDO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_NASCIMENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'DT_NASCIMENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_nascimento',
   'user', @CurrentUser, 'table', 'TB_ATLETAS', 'column', 'DT_NASCIMENTO'
go

/*==============================================================*/
/* Table: TB_CATEGORIA_IDADE                                    */
/*==============================================================*/
create table TB_CATEGORIA_IDADE (
   ID_CATEGORIA_IDADE   int                  identity,
   NM_CATEGORIA_IDADE   varchar(100)         not null,
   constraint PK_TB_CATEGORIA_IDADE primary key nonclustered (ID_CATEGORIA_IDADE)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_CATEGORIA_IDADE') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_categoria_idade', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CATEGORIA_IDADE')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CATEGORIA_IDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE', 'column', 'ID_CATEGORIA_IDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_categoria_idade',
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE', 'column', 'ID_CATEGORIA_IDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CATEGORIA_IDADE')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_CATEGORIA_IDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE', 'column', 'NM_CATEGORIA_IDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_categoria_idade',
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_IDADE', 'column', 'NM_CATEGORIA_IDADE'
go

/*==============================================================*/
/* Table: TB_CATEGORIA_PESO                                     */
/*==============================================================*/
create table TB_CATEGORIA_PESO (
   ID_CATEGORIA_PESO    int                  identity,
   NM_CATEGORIA_PESO    varchar(100)         not null,
   constraint PK_TB_CATEGORIA_PESO primary key nonclustered (ID_CATEGORIA_PESO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_CATEGORIA_PESO') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_categoria_peso', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CATEGORIA_PESO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CATEGORIA_PESO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO', 'column', 'ID_CATEGORIA_PESO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_categoria_peso',
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO', 'column', 'ID_CATEGORIA_PESO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CATEGORIA_PESO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_CATEGORIA_PESO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO', 'column', 'NM_CATEGORIA_PESO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_categoria_peso',
   'user', @CurrentUser, 'table', 'TB_CATEGORIA_PESO', 'column', 'NM_CATEGORIA_PESO'
go

/*==============================================================*/
/* Table: TB_CIDADES                                            */
/*==============================================================*/
create table TB_CIDADES (
   ID_CIDADE            int                  identity,
   ID_UF                smallint             not null,
   NM_CIDADE            varchar(50)          not null,
   NR_LATITUDE          float                null,
   NR_LONGITUDE         float                null,
   NR_ALTITUDE          float                null,
   constraint PK_TB_CIDADES primary key (ID_CIDADE)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_CIDADES') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_CIDADES' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_cidades', 
   'user', @CurrentUser, 'table', 'TB_CIDADES'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'ID_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_cidade',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'ID_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_UF')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'ID_UF'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_uf',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'ID_UF'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NM_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_cidade',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NM_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_LATITUDE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_LATITUDE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_latitude',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_LATITUDE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_LONGITUDE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_LONGITUDE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_longitude',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_LONGITUDE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_CIDADES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_ALTITUDE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_ALTITUDE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_altitude',
   'user', @CurrentUser, 'table', 'TB_CIDADES', 'column', 'NR_ALTITUDE'
go

/*==============================================================*/
/* Table: TB_DETALHES_REGRAS_LUTA                               */
/*==============================================================*/
create table TB_DETALHES_REGRAS_LUTA (
   ID_DETALHE_REGRA_LUTA int                  identity,
   ID_REGRA_LUTA        smallint             null,
   ID_CATEGORIA_IDADE   int                  not null,
   ID_CATEGORIA_PESO    int                  not null,
   ID_USUARIO           int                  null,
   ID_GRADUACAO_INICIAL smallint             null,
   ID_GRADUACAO_FINAL   smallint             null,
   NR_IDADE_INICIAL     smallint             not null,
   NR_IDADE_FINAL       smallint             not null,
   NR_PESO_INICIAL      float                not null,
   NR_PESO_FINAL        float                not null,
   CS_SEXO              char(1)              not null,
   constraint PK_TB_DETALHES_REGRAS_LUTA primary key (ID_DETALHE_REGRA_LUTA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_DETALHES_REGRAS_LUTA') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_detalhes_regras_luta', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_DETALHE_REGRA_LUTA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_DETALHE_REGRA_LUTA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_detalhe_regra_luta',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_DETALHE_REGRA_LUTA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_REGRA_LUTA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_REGRA_LUTA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_regra_luta',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_REGRA_LUTA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CATEGORIA_IDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_CATEGORIA_IDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_categoria_idade',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_CATEGORIA_IDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CATEGORIA_PESO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_CATEGORIA_PESO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_categoria_peso',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_CATEGORIA_PESO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_GRADUACAO_INICIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_GRADUACAO_INICIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_graduacao_inicial',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_GRADUACAO_INICIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_GRADUACAO_FINAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_GRADUACAO_FINAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_graduacao_final',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'ID_GRADUACAO_FINAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_IDADE_INICIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_IDADE_INICIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_idade_inicial',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_IDADE_INICIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_IDADE_FINAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_IDADE_FINAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_idade_final',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_IDADE_FINAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_PESO_INICIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_PESO_INICIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_peso_inicial',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_PESO_INICIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_PESO_FINAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_PESO_FINAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_peso_final',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'NR_PESO_FINAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_DETALHES_REGRAS_LUTA')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'CS_SEXO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'CS_SEXO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'cs_sexo',
   'user', @CurrentUser, 'table', 'TB_DETALHES_REGRAS_LUTA', 'column', 'CS_SEXO'
go

/*==============================================================*/
/* Table: TB_ESTILOS                                            */
/*==============================================================*/
create table TB_ESTILOS (
   ID_ESTILO            smallint             identity,
   NM_ESTILO            varchar(20)          not null,
   DS_ESTILO            varchar(250)         null,
   constraint PK_TB_ESTILOS primary key (ID_ESTILO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_ESTILOS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_ESTILOS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_estilos', 
   'user', @CurrentUser, 'table', 'TB_ESTILOS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ESTILOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ESTILO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'ID_ESTILO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_estilo',
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'ID_ESTILO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ESTILOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ESTILO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'NM_ESTILO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_estilo',
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'NM_ESTILO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_ESTILOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DS_ESTILO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'DS_ESTILO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'ds_estilo',
   'user', @CurrentUser, 'table', 'TB_ESTILOS', 'column', 'DS_ESTILO'
go

/*==============================================================*/
/* Table: TB_EVENTOS                                            */
/*==============================================================*/
create table TB_EVENTOS (
   ID_EVENTO            int                  identity,
   ID_TIPO_EVENTO       smallint             null,
   NM_EVENTO            varchar(100)         not null,
   DT_EVENTO            datetime2            not null,
   VL_INSCRICAO_COLORIDA float                null,
   VL_INSCRICAO_PRETA   float                null,
   constraint PK_TB_EVENTOS primary key (ID_EVENTO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_EVENTOS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_EVENTOS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_eventos', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'ID_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_evento',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'ID_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_TIPO_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'ID_TIPO_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_tipo_evento',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'ID_TIPO_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'NM_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_evento',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'NM_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'DT_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_evento',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'DT_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'VL_INSCRICAO_COLORIDA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'VL_INSCRICAO_COLORIDA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'vl_inscricao_colorida',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'VL_INSCRICAO_COLORIDA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'VL_INSCRICAO_PRETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'VL_INSCRICAO_PRETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'vl_inscricao_preta',
   'user', @CurrentUser, 'table', 'TB_EVENTOS', 'column', 'VL_INSCRICAO_PRETA'
go

/*==============================================================*/
/* Table: TB_GRADUACOES                                         */
/*==============================================================*/
create table TB_GRADUACOES (
   ID_GRADUACAO         smallint             identity,
   ID_ESTILO            smallint             not null,
   ID_ARTE_MARCIAL      smallint             not null,
   NM_GRADUACAO         varchar(40)          not null,
   SG_GRADUACAO         char(15)             null,
   constraint PK_TB_GRADUACOES primary key (ID_GRADUACAO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_GRADUACOES') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_GRADUACOES' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_graduacoes', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_GRADUACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_GRADUACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_graduacao',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_GRADUACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ESTILO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_ESTILO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_estilo',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_ESTILO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ARTE_MARCIAL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_ARTE_MARCIAL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_arte_marcial',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'ID_ARTE_MARCIAL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_GRADUACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'NM_GRADUACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_graduacao',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'NM_GRADUACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'SG_GRADUACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'SG_GRADUACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'sg_graduacao',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES', 'column', 'SG_GRADUACAO'
go

/*==============================================================*/
/* Table: TB_GRADUACOES_ATLETAS                                 */
/*==============================================================*/
create table TB_GRADUACOES_ATLETAS (
   ID_GRADUACAO_ATLETA  bigint               identity,
   ID_ATLETA            int                  null,
   ID_GRADUACAO         smallint             null,
   DT_CADASTRO          datetime2            null,
   constraint PK_TB_GRADUACOES_ATLETAS primary key (ID_GRADUACAO_ATLETA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_GRADUACOES_ATLETAS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_graduacoes_atletas', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_GRADUACAO_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_GRADUACAO_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_graduacao_atleta',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_GRADUACAO_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_atleta',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_GRADUACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_GRADUACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_graduacao',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'ID_GRADUACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_GRADUACOES_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'DT_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_cadastro',
   'user', @CurrentUser, 'table', 'TB_GRADUACOES_ATLETAS', 'column', 'DT_CADASTRO'
go

/*==============================================================*/
/* Table: TB_HISTORICO_ASSOCIACOES                              */
/*==============================================================*/
create table TB_HISTORICO_ASSOCIACOES (
   ID_HISTORICO_ASSOCIACAO bigint               identity,
   ID_ASSOCIACAO        int                  null,
   ID_USUARIO_ALTERACAO int                  null,
   ID_CIDADE            int                  null,
   NM_ASSOCIACAO        nvarchar(100)        null,
   TX_ENDERECO          varchar(200)         null,
   NR_CEP               varchar(12)          null,
   BO_EXCLUIDO          bit                  null,
   constraint PK_TB_HISTORICO_ASSOCIACOES primary key (ID_HISTORICO_ASSOCIACAO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_HISTORICO_ASSOCIACOES') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_historico_associacoes', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_HISTORICO_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_HISTORICO_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_historico_associacao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_HISTORICO_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_associacao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO_ALTERACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_USUARIO_ALTERACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario_alteracao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_USUARIO_ALTERACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_cidade',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'ID_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'NM_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_associacao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'NM_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'TX_ENDERECO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'TX_ENDERECO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'tx_endereco',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'TX_ENDERECO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_CEP')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'NR_CEP'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_cep',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'NR_CEP'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ASSOCIACOES')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EXCLUIDO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'BO_EXCLUIDO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_excluido',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ASSOCIACOES', 'column', 'BO_EXCLUIDO'
go

/*==============================================================*/
/* Table: TB_HISTORICO_ATLETAS                                  */
/*==============================================================*/
create table TB_HISTORICO_ATLETAS (
   ID_HISTORICO_ATLETA  bigint               identity,
   ID_ATLETA            int                  null,
   ID_USUARIO_ALTERACAO int                  null,
   ID_ASSOCIACAO        int                  null,
   ID_CIDADE            int                  null,
   DT_ALTERACAO         datetime2            null,
   NM_ATLETA            nvarchar(50)         null,
   TX_ENDERECO          varchar(200)         null,
   NR_CEP               varchar(12)          null,
   BO_EXCLUIDO          bit                  null,
   constraint PK_TB_HISTORICO_ATLETAS primary key (ID_HISTORICO_ATLETA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_HISTORICO_ATLETAS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_historico_atletas', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_HISTORICO_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_HISTORICO_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_historico_atleta',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_HISTORICO_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_atleta',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO_ALTERACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_USUARIO_ALTERACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario_alteracao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_USUARIO_ALTERACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_associacao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_CIDADE')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_CIDADE'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_cidade',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'ID_CIDADE'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_ALTERACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'DT_ALTERACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_alteracao',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'DT_ALTERACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'NM_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_atleta',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'NM_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'TX_ENDERECO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'TX_ENDERECO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'tx_endereco',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'TX_ENDERECO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NR_CEP')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'NR_CEP'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nr_cep',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'NR_CEP'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_HISTORICO_ATLETAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EXCLUIDO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'BO_EXCLUIDO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_excluido',
   'user', @CurrentUser, 'table', 'TB_HISTORICO_ATLETAS', 'column', 'BO_EXCLUIDO'
go

/*==============================================================*/
/* Table: TB_INSCRITOS_EVENTO                                   */
/*==============================================================*/
create table TB_INSCRITOS_EVENTO (
   ID_INSCRITO_EVENTO   bigint               identity,
   ID_EVENTO            int                  null,
   ID_ATLETA            int                  null,
   DT_INSCRICAO         datetime2            null,
   constraint PK_TB_INSCRITOS_EVENTO primary key (ID_INSCRITO_EVENTO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_INSCRITOS_EVENTO') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_inscritos_evento', 
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_INSCRITOS_EVENTO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_INSCRITO_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_INSCRITO_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_inscrito_evento',
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_INSCRITO_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_INSCRITOS_EVENTO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_evento',
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_INSCRITOS_EVENTO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_atleta',
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'ID_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_INSCRITOS_EVENTO')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_INSCRICAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'DT_INSCRICAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_inscricao',
   'user', @CurrentUser, 'table', 'TB_INSCRITOS_EVENTO', 'column', 'DT_INSCRICAO'
go

/*==============================================================*/
/* Table: TB_PERFIS                                             */
/*==============================================================*/
create table TB_PERFIS (
   ID_PERFIL            smallint             identity,
   NM_PERFIL            varchar(30)          not null,
   DS_PERFIL            varchar(300)         null,
   constraint PK_TB_PERFIS primary key (ID_PERFIL)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_PERFIS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_PERFIS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_perfis', 
   'user', @CurrentUser, 'table', 'TB_PERFIS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PERFIS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_PERFIL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'ID_PERFIL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_perfil',
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'ID_PERFIL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PERFIS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_PERFIL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'NM_PERFIL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_perfil',
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'NM_PERFIL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PERFIS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DS_PERFIL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'DS_PERFIL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'ds_perfil',
   'user', @CurrentUser, 'table', 'TB_PERFIS', 'column', 'DS_PERFIL'
go

/*==============================================================*/
/* Table: TB_PREFERENCIAS                                       */
/*==============================================================*/
create table TB_PREFERENCIAS (
   ID_PREFERENCIA       int                  identity,
   ID_ASSOCIACAO        int                  null,
   ID_USUARIO           int                  null,
   ID_REGRA             smallint             null,
   BO_EDITAR_CAD_ATLETA bit                  null,
   BO_EDITAR_CAD_ASSOCIACAO bit                  null,
   DT_CADASTRO          datetime2            null,
   DT_ALTERACAO         datetime2            null,
   constraint PK_TB_PREFERENCIAS primary key (ID_PREFERENCIA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_PREFERENCIAS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_preferencias', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_PREFERENCIA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_PREFERENCIA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_preferencia',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_PREFERENCIA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_associacao',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_REGRA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_REGRA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_regra',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'ID_REGRA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EDITAR_CAD_ATLETA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'BO_EDITAR_CAD_ATLETA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_editar_cad_atleta',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'BO_EDITAR_CAD_ATLETA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EDITAR_CAD_ASSOCIACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'BO_EDITAR_CAD_ASSOCIACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_editar_cad_associacao',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'BO_EDITAR_CAD_ASSOCIACAO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_CADASTRO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'DT_CADASTRO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_cadastro',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'DT_CADASTRO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_PREFERENCIAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DT_ALTERACAO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'DT_ALTERACAO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'dt_alteracao',
   'user', @CurrentUser, 'table', 'TB_PREFERENCIAS', 'column', 'DT_ALTERACAO'
go

/*==============================================================*/
/* Table: TB_REGRAS_LUTAS                                       */
/*==============================================================*/
create table TB_REGRAS_LUTAS (
   ID_REGRA_LUTA        smallint             identity,
   NM_REGRA_LUTA        varchar(100)         not null,
   constraint PK_TB_REGRAS_LUTAS primary key (ID_REGRA_LUTA)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_REGRAS_LUTAS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_regras_lutas', 
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_REGRAS_LUTAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_REGRA_LUTA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS', 'column', 'ID_REGRA_LUTA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_regra_luta',
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS', 'column', 'ID_REGRA_LUTA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_REGRAS_LUTAS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_REGRA_LUTA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS', 'column', 'NM_REGRA_LUTA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_regra_luta',
   'user', @CurrentUser, 'table', 'TB_REGRAS_LUTAS', 'column', 'NM_REGRA_LUTA'
go

/*==============================================================*/
/* Table: TB_TIPOS_EVENTOS                                      */
/*==============================================================*/
create table TB_TIPOS_EVENTOS (
   ID_TIPO_EVENTO       smallint             identity,
   NM_TIPO_EVENTO       varchar(25)          not null,
   DS_TIPO_EVENTO       varchar(255)         null,
   constraint PK_TB_TIPOS_EVENTOS primary key (ID_TIPO_EVENTO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_TIPOS_EVENTOS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_tipos_eventos', 
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_TIPOS_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_TIPO_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'ID_TIPO_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_tipo_evento',
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'ID_TIPO_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_TIPOS_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_TIPO_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'NM_TIPO_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_tipo_evento',
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'NM_TIPO_EVENTO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_TIPOS_EVENTOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'DS_TIPO_EVENTO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'DS_TIPO_EVENTO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'ds_tipo_evento',
   'user', @CurrentUser, 'table', 'TB_TIPOS_EVENTOS', 'column', 'DS_TIPO_EVENTO'
go

/*==============================================================*/
/* Table: TB_UFS                                                */
/*==============================================================*/
create table TB_UFS (
   ID_UF                smallint             identity,
   NM_UF                varchar(50)          not null,
   SG_UF                char(2)              not null,
   constraint PK_TB_UFS primary key (ID_UF)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_UFS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_UFS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_ufs', 
   'user', @CurrentUser, 'table', 'TB_UFS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_UFS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_UF')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'ID_UF'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_uf',
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'ID_UF'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_UFS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_UF')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'NM_UF'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_uf',
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'NM_UF'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_UFS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'SG_UF')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'SG_UF'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'sg_uf',
   'user', @CurrentUser, 'table', 'TB_UFS', 'column', 'SG_UF'
go

/*==============================================================*/
/* Table: TB_USUARIOS                                           */
/*==============================================================*/
create table TB_USUARIOS (
   ID_USUARIO           int                  identity,
   ID_PERFIL            smallint             not null,
   NM_USUARIO           varchar(25)          not null,
   TX_SENHA             varchar(1000)        not null,
   BO_DESATIVADO        bit                  null,
   BO_EXCLUIDO          bit                  null,
   constraint PK_TB_USUARIOS primary key (ID_USUARIO)
)
go

if exists (select 1 from  sys.extended_properties
           where major_id = object_id('TB_USUARIOS') and minor_id = 0)
begin 
   declare @CurrentUser sysname 
select @CurrentUser = user_name() 
execute sp_dropextendedproperty 'MS_Description',  
   'user', @CurrentUser, 'table', 'TB_USUARIOS' 
 
end 


select @CurrentUser = user_name() 
execute sp_addextendedproperty 'MS_Description',  
   'tb_usuarios', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'ID_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_usuario',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'ID_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'ID_PERFIL')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'ID_PERFIL'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'id_perfil',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'ID_PERFIL'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'NM_USUARIO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'NM_USUARIO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'nm_usuario',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'NM_USUARIO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'TX_SENHA')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'TX_SENHA'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'tx_senha',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'TX_SENHA'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_DESATIVADO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'BO_DESATIVADO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_desativado',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'BO_DESATIVADO'
go

if exists(select 1 from sys.extended_properties p where
      p.major_id = object_id('TB_USUARIOS')
  and p.minor_id = (select c.column_id from sys.columns c where c.object_id = p.major_id and c.name = 'BO_EXCLUIDO')
)
begin
   declare @CurrentUser sysname
select @CurrentUser = user_name()
execute sp_dropextendedproperty 'MS_Description', 
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'BO_EXCLUIDO'

end


select @CurrentUser = user_name()
execute sp_addextendedproperty 'MS_Description', 
   'bo_excluido',
   'user', @CurrentUser, 'table', 'TB_USUARIOS', 'column', 'BO_EXCLUIDO'
go

alter table TB_ASSOCIACOES
   add constraint FK_TB_ASSOC_REFERENCE_TB_CIDAD foreign key (ID_CIDADE)
      references TB_CIDADES (ID_CIDADE)
go

alter table TB_ASSOCIACOES
   add constraint FK_TB_ASSCI_REFERENCE_TB_USUAR2 foreign key (ID_USUARIO_CADASTRO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_ASSOCIACOES
   add constraint FK_TB_ASSOC_REFERENCE_TB_USUAR foreign key (ID_USUARIO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_ASSOCIACOES
   add constraint FK_TB_ASSOC_REFERENCE_TB_ARTES foreign key (ID_ARTE_MARCIAL)
      references TB_ARTES_MARCIAIS (ID_ARTE_MARCIAL)
go

alter table TB_ATLETAS
   add constraint FK_TB_ATLET_REFERENCE_TB_ASSOC foreign key (ID_ASSOCIACAO)
      references TB_ASSOCIACOES (ID_ASSOCIACAO)
go

alter table TB_ATLETAS
   add constraint FK_TB_ATLET_REFERENCE_TB_USUAR2 foreign key (ID_USUARIO_CADASTRO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_ATLETAS
   add constraint FK_TB_ATLET_REFERENCE_TB_USUAR foreign key (ID_USUARIO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_ATLETAS
   add constraint FK_TB_ATLET_REFERENCE_TB_CIDAD foreign key (ID_CIDADE)
      references TB_CIDADES (ID_CIDADE)
go

alter table TB_CIDADES
   add constraint FK_TB_CIDAD_REFERENCE_TB_UFS foreign key (ID_UF)
      references TB_UFS (ID_UF)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_REGRA foreign key (ID_REGRA_LUTA)
      references TB_REGRAS_LUTAS (ID_REGRA_LUTA)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_CATEG2 foreign key (ID_CATEGORIA_PESO)
      references TB_CATEGORIA_PESO (ID_CATEGORIA_PESO)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_CATEG foreign key (ID_CATEGORIA_IDADE)
      references TB_CATEGORIA_IDADE (ID_CATEGORIA_IDADE)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_USUAR foreign key (ID_USUARIO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_GRADU2 foreign key (ID_GRADUACAO_INICIAL)
      references TB_GRADUACOES (ID_GRADUACAO)
go

alter table TB_DETALHES_REGRAS_LUTA
   add constraint FK_TB_DETAL_REFERENCE_TB_GRADU foreign key (ID_GRADUACAO_FINAL)
      references TB_GRADUACOES (ID_GRADUACAO)
go

alter table TB_EVENTOS
   add constraint FK_TB_EVENT_REFERENCE_TB_TIPOS foreign key (ID_TIPO_EVENTO)
      references TB_TIPOS_EVENTOS (ID_TIPO_EVENTO)
go

alter table TB_GRADUACOES
   add constraint FK_TB_GRADU_REFERENCE_TB_ARTES foreign key (ID_ARTE_MARCIAL)
      references TB_ARTES_MARCIAIS (ID_ARTE_MARCIAL)
go

alter table TB_GRADUACOES
   add constraint FK_TB_GRADU_REFERENCE_TB_ESTIL foreign key (ID_ESTILO)
      references TB_ESTILOS (ID_ESTILO)
go

alter table TB_GRADUACOES_ATLETAS
   add constraint FK_TB_GRADU_REFERENCE_TB_ATLET foreign key (ID_ATLETA)
      references TB_ATLETAS (ID_ATLETA)
go

alter table TB_GRADUACOES_ATLETAS
   add constraint FK_TB_GRADU_REFERENCE_TB_GRADU foreign key (ID_GRADUACAO)
      references TB_GRADUACOES (ID_GRADUACAO)
go

alter table TB_HISTORICO_ASSOCIACOES
   add constraint FK_TB_HISTO_REFERENCE_TB_ASSOC foreign key (ID_ASSOCIACAO)
      references TB_ASSOCIACOES (ID_ASSOCIACAO)
go

alter table TB_HISTORICO_ASSOCIACOES
   add constraint FK_TB_HISTO_REFERENCE_TB_USUAR foreign key (ID_USUARIO_ALTERACAO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_HISTORICO_ASSOCIACOES
   add constraint FK_TB_HISTO_REFERENCE_TB_CIDAD foreign key (ID_CIDADE)
      references TB_CIDADES (ID_CIDADE)
go

alter table TB_HISTORICO_ATLETAS
   add constraint FK_TB_HISTO_REFERENCE_TB_ATLET foreign key (ID_ATLETA)
      references TB_ATLETAS (ID_ATLETA)
go

alter table TB_HISTORICO_ATLETAS
   add constraint FK_TB_HISTO_REFERENCE_TB_USUAR2 foreign key (ID_USUARIO_ALTERACAO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_HISTORICO_ATLETAS
   add constraint FK_TB_HISTO_REFERENCE_TB_ASSCI2 foreign key (ID_ASSOCIACAO)
      references TB_ASSOCIACOES (ID_ASSOCIACAO)
go

alter table TB_HISTORICO_ATLETAS
   add constraint FK_TB_HISTO_REFERENCE_TB_CIDAD2 foreign key (ID_CIDADE)
      references TB_CIDADES (ID_CIDADE)
go

alter table TB_INSCRITOS_EVENTO
   add constraint FK_TB_INSCR_REFERENCE_TB_EVENT foreign key (ID_EVENTO)
      references TB_EVENTOS (ID_EVENTO)
go

alter table TB_INSCRITOS_EVENTO
   add constraint FK_TB_INSCR_REFERENCE_TB_ATLET foreign key (ID_ATLETA)
      references TB_ATLETAS (ID_ATLETA)
go

alter table TB_PREFERENCIAS
   add constraint FK_TB_PREFE_REFERENCE_TB_ASSOC foreign key (ID_ASSOCIACAO)
      references TB_ASSOCIACOES (ID_ASSOCIACAO)
go

alter table TB_PREFERENCIAS
   add constraint FK_TB_PREFE_REFERENCE_TB_USUAR foreign key (ID_USUARIO)
      references TB_USUARIOS (ID_USUARIO)
go

alter table TB_PREFERENCIAS
   add constraint FK_TB_PREFE_REFERENCE_TB_REGRA foreign key (ID_REGRA)
      references TB_REGRAS_LUTAS (ID_REGRA_LUTA)
go

alter table TB_USUARIOS
   add constraint FK_TB_USUAR_REFERENCE_TB_PERFI foreign key (ID_PERFIL)
      references TB_PERFIS (ID_PERFIL)
go

