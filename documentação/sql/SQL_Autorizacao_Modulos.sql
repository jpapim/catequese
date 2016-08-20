AUTORIZAï¿½ï¿½O CATEGORIA PESO
INSERT INTO perfil_controller_action(id_controller,id_action,id_perfil) VALUES('18','51','1');

<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
AUTORIZAÇÃO PERFIL
INSERT INTO perfil_controller_action(id_controller,id_action,id_perfil) VALUES('12','51','1');

AUTORIZAÇÃO SACRAMENTO index,gravar,index-pagination,cadastro,excluir
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(24,1,1),(24,6,1),(24,51,1),(24,7,1),(24,8,1);


AUTORIZAÇÃO MOVIMENTO_PASTORAL index,gravar,index-pagination,cadastro,excluir
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(26,1,1),(26,6,1),(26,51,1),(26,7,1),(26,8,1);
=======
=======
>>>>>>> master
>>>>>>> dev-raimundo
AUTORIZAï¿½ï¿½O PERFIL
INSERT INTO perfil_controller_action(id_controller,id_action,id_perfil) VALUES('12','51','1');

INSERIR MODULO PERIODOLETIVO
INSERT INTO controller(nm_controller) VALUES('periodo_letivo-periodoletivo');

AUTORIZACAO DOS COMPORTAMENTOS DO MODULO PeriodoLetivo
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('24','1','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('24','6','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('24','7','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('24','8','1');
insert into perfil_controller_action(id_controller,id_action, id_perfil) values('24','51','1');

AUTORIZACAO DOS COMPORTAMENTOS DO MODULO DetalhePeriodo
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('25','1','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('25','6','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('25','7','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('25','8','1');
<<<<<<< HEAD
insert into perfil_controller_action(id_controller,id_action, id_perfil) values('25','51','1');
=======
<<<<<<< HEAD
insert into perfil_controller_action(id_controller,id_action, id_perfil) values('25','51','1');
>>>>>>> dev-igor
=======
insert into perfil_controller_action(id_controller,id_action, id_perfil) values('25','51','1');
>>>>>>> master
>>>>>>> dev-raimundo
INSERIR MODULO CATEQUISTA
INSERT INTO controller(nm_controller) VALUES('catequista-catequista');

AUTORIZACAO cATEQUISTA
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(28,1,1),(28,6,1),(28,51,1),(28,7,1),(28,8,1);
##################################################
INSERIR MODULO ETAPA
INSERT into controller(id_controller,nm_controller) VALUES(null,'etapa-etapa');

AUTORIZACAO ETAPA
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(29,1,1),(29,6,1),(29,51,1),(29,7,1),(29,8,1);
#######################################################
INSERIR MODULO TURMA
INSERT into controller(id_controller,nm_controller) VALUES(null,'turma-turma');

AUTORIZACAO TURMA
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(30,1,1),(30,6,1),(30,51,1),(30,7,1),(30,8,1);
###########################################
INSERIR MODULO TURMA CATEQUISANDO
INSERT into controller(id_controller,nm_controller) VALUES(null,'turma_catequisando-turmacatequisando')

AUTORIZACAO TURMA CATEQUISANDO
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(31,1,1),(31,6,1),(31,51,1),(31,7,1),(31,8,1);
####################################################
INSERIR MODULO GRAU_PARENTESCO
INSERT into controller(id_controller,nm_controller) VALUES(null,'grau_parentesco-grauparentesco');

AUTORIZACAO GRAU_PARENTESCO
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(32,1,1),(32,6,1),(32,51,1),(32,7,1),(32,8,1);
################################################
INSERIR MODULO RESPONSAVEL_CATEQUISANDO
INSERT into controller(id_controller,nm_controller) VALUES(null,'responsavel_catequisando-responsavelcatequisando');

AUTORIZACAO RESPONSAVEL_CATEQUISANDO
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(33,1,1),(33,6,1),(33,51,1),(33,7,1),(33,8,1);
################################################

AUTORIZACAO SACRAMENTO_CATEQUISANDO
INSERT INTO controller(`nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('sacramento_catequisando-sacramentocatequisando', 'Sacramento Catequisando', 'S');


insert into perfil_controller_action(id_controller,id_action,id_perfil) values('44','1','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('44','6','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('44','7','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('44','8','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('44','51','1');
################################################

AUTORIZACAO FREQUENCIA TURMA
INSERT INTO `bdcatequese`.`controller` (`nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('frequencia_turma-frequenciaturma', 'Frequencia Turma', 'S');


insert into perfil_controller_action(id_controller,id_action,id_perfil) values('45','1','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('45','6','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('45','7','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('45','8','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('45','51','1');

################################################

AUTORIZACAO ESTADO CIVIL
INSERT INTO `bdcatequese`.`controller` (`nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('estado_civil-estadocivil', 'Estado Civil', 'S');


insert into perfil_controller_action(id_controller,id_action,id_perfil) values('46','1','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('46','6','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('46','7','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('46','8','1');
insert into perfil_controller_action(id_controller,id_action,id_perfil) values('46','51','1');

################################################
INSERIR MODULO RESPONSAVEL
INSERT into controller(id_controller,nm_controller) VALUES(null,'responsavel-responsavel');

AUTORIZACAO RESPONSAVEL_CATEQUISANDO
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(34,1,1),(34,6,1),(34,51,1),(34,7,1),(34,8,1);
################################################
<<<<<<< HEAD

INSERIR MODULO CATEQUISTA_TURMA
INSERT into controller(id_controller,nm_controller) VALUES(null,'catequista_turma-catequistaturma');

=======

INSERIR MODULO CATEQUISTA_TURMA
INSERT into controller(id_controller,nm_controller) VALUES(null,'catequista_turma-catequistaturma');

>>>>>>> dev-igor
AUTORIZACAO CATEQUISTA_TURMA
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(36,1,1),(36,6,1),(36,51,1),(36,7,1),(36,8,1);
#########################################################
INSERIR MODULO CATEQUISANDO_ETAPA_CURSOU
INSERT into controller(id_controller,nm_controller) VALUES(null,'catequisando_etapa_cursou-catequisandoetapacursou');
<<<<<<< HEAD

AUTORIZACAO CATEQUISANDO_ETAPA_CURSOU
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(37,1,1),(37,6,1),(37,51,1),(37,7,1),(37,8,1);
##############################################################
INSERIR MODULO SACRAMENTO_RESPONSAVEL
INSERT into controller(id_controller,nm_controller) VALUES(null,'sacramento_responsavel-sacramentoresponsavel');

AUTORIZACAO SACRAMENTO_RESPONSAVEL
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(38,1,1),(38,6,1),(38,51,1),(38,7,1),(38,8,1);
#########################################################
INSERIR MODULO SITUACAO_RESPONSAVEL_CATEQUISANDO
INSERT into controller(id_controller,nm_controller) VALUES(null,'situacao_responsavel_catequisando-situacaoresponsavelcatequisando');

AUTORIZACAO SITUACAO_RESPONSAVEL_CATEQUISANDO
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(39,1,1),(39,6,1),(39,51,1),(39,7,1),(39,8,1);
##############################################################
=======
>>>>>>> dev-igor

<<<<<<< HEAD
AUTORIZACAO CATEQUISANDO_ETAPA_CURSOU
insert into perfil_controller_action(id_controller,id_action,id_perfil) VALUES(37,1,1),(37,6,1),(37,51,1),(37,7,1),(37,8,1);
##############################################################
=======

>>>>>>> dev-eduardo
