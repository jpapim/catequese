CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `alyssonv_appuser`@`localhost` 
    SQL SECURITY DEFINER
VIEW `alyssonv_competicoestkd`.`auth` AS
    (SELECT 
        `alyssonv_competicoestkd`.`login`.`id_usuario` AS `id_usuario`,
        `alyssonv_competicoestkd`.`perfil`.`id_perfil` AS `id_perfil`,
        `alyssonv_competicoestkd`.`email`.`em_email` AS `em_email`,
        `alyssonv_competicoestkd`.`login`.`pw_senha` AS `pw_senha`,
        `alyssonv_competicoestkd`.`usuario`.`nm_usuario` AS `nm_usuario`,
        `alyssonv_competicoestkd`.`contrato`.`id_contrato` AS `id_contrato`
    FROM
        ((((`alyssonv_competicoestkd`.`usuario`
        JOIN `alyssonv_competicoestkd`.`login` ON ((`alyssonv_competicoestkd`.`login`.`id_usuario` = `alyssonv_competicoestkd`.`usuario`.`id_usuario`)))
        JOIN `alyssonv_competicoestkd`.`email` ON ((`alyssonv_competicoestkd`.`email`.`id_email` = `alyssonv_competicoestkd`.`login`.`id_email`)))
        JOIN `alyssonv_competicoestkd`.`perfil` ON ((`alyssonv_competicoestkd`.`perfil`.`id_perfil` = `alyssonv_competicoestkd`.`login`.`id_perfil`)))
        JOIN `alyssonv_competicoestkd`.`contrato` ON ((`alyssonv_competicoestkd`.`contrato`.`id_usuario` = `alyssonv_competicoestkd`.`usuario`.`id_usuario`))));
		