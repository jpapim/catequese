alter table `bdcatequese`.`controller` add column nm_modulo varchar(50) null;
alter table `bdcatequese`.`controller` add column cs_exibir_combo char(1) default 'S';

UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Arte Marcial' WHERE `id_controller`='1';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Estilo da Arte' WHERE `id_controller`='2';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Usuario' WHERE `id_controller`='3';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Aplicação', `cs_exibir_combo`='N' WHERE `id_controller`='4';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Cidade' WHERE `id_controller`='5';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Estado' WHERE `id_controller`='6';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Graduação' WHERE `id_controller`='7';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Pagamento' WHERE `id_controller`='8';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Boleto do Itau', `cs_exibir_combo`='N' WHERE `id_controller`='9';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Banco' WHERE `id_controller`='10';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Principal' WHERE `id_controller`='11';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Perfil' WHERE `id_controller`='12';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Tipo de Evento' WHERE `id_controller`='13';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Evento' WHERE `id_controller`='14';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Teste de Action ', `cs_exibir_combo`='N' WHERE `id_controller`='15';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Academia' WHERE `id_controller`='16';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Atleta' WHERE `id_controller`='17';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Categoria de Peso' WHERE `id_controller`='18';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Categoria de Idade' WHERE `id_controller`='19';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Regras de Luta' WHERE `id_controller`='20';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Definição das Regras de Luta' WHERE `id_controller`='21';
UPDATE `bdcatequese`.`controller` SET `nm_modulo`='Inscrições nos Eventos' WHERE `id_controller`='22';

