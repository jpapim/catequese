CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `alyssonv_appuser`@`localhost` 
    SQL SECURITY DEFINER
VIEW `alyssonv_competicoestkd`.`acl` AS
    (SELECT 
        `alyssonv_competicoestkd`.`perfil_controller_action`.`id_perfil` AS `id_perfil`,
        CONCAT(`alyssonv_competicoestkd`.`controller`.`nm_controller`,
                '/',
                `alyssonv_competicoestkd`.`action`.`nm_action`) AS `nm_resource`
    FROM
        ((`alyssonv_competicoestkd`.`perfil_controller_action`
        JOIN `alyssonv_competicoestkd`.`controller` ON ((`alyssonv_competicoestkd`.`controller`.`id_controller` = `alyssonv_competicoestkd`.`perfil_controller_action`.`id_controller`)))
        JOIN `alyssonv_competicoestkd`.`action` ON ((`alyssonv_competicoestkd`.`action`.`id_action` = `alyssonv_competicoestkd`.`perfil_controller_action`.`id_action`))))