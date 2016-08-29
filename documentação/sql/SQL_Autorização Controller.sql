# AUTORIZAÇÃO DE CONTROLLER #

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('33', 'catequizando-catequizando', 'Catequizando', 'S');

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('34', 'catequizando_etapa_cursou-catequizandoetapacursou', 'Catequizando Etapa Cursou', 'S');

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('35', 'responsavel_catequizando-responsavelcatequizando', 'Responsavel catequizando', 'S');

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('36', 'sacramento_catequizando-sacramentocatequizando', 'Sacramento Catequizando', 'S');

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('37', 'situacao_responsavel_catequizando-situacaoresponsavelcatequizando', 'Situacao Responsavel Catequizando', 'S');

INSERT INTO `bdcatequese`.`controller` (`id_controller`, `nm_controller`, `nm_modulo`, `cs_exibir_combo`) VALUES ('38', 'turma_catequizando-turmacatequizando', 'Turma Catequizando', 'S');

-------------------------------------------------------------------------------------------------

# LIBERANDO PERMISSÃO #

INSERT INTO `bdcatequese`.`perfil_controller_action` (`id_perfil_controller_action`, `id_controller`, `id_action`, `id_perfil`) VALUES ('198', '33', '1', '1');

INSERT INTO `bdcatequese`.`perfil_controller_action` (`id_perfil_controller_action`, `id_controller`, `id_action`, `id_perfil`) VALUES ('199', '33', '6', '1');

INSERT INTO `bdcatequese`.`perfil_controller_action` (`id_perfil_controller_action`, `id_controller`, `id_action`, `id_perfil`) VALUES ('200', '33', '7', '1');

INSERT INTO `bdcatequese`.`perfil_controller_action` (`id_perfil_controller_action`, `id_controller`, `id_action`, `id_perfil`) VALUES ('201', '33', '8', '1');

INSERT INTO `bdcatequese`.`perfil_controller_action` (`id_perfil_controller_action`, `id_controller`, `id_action`, `id_perfil`) VALUES ('202', '33', '51', '1');