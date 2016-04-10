CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `alyssonv_appuser`@`localhost` 
    SQL SECURITY DEFINER
VIEW `alyssonv_competicoestkd`.`vw_regras_lutas` AS
    SELECT 
        `rls`.`id_regra_luta` AS `id_regra_luta`,
        `rls`.`nm_regra_luta` AS `nm_regra_luta`,
        `grd`.`nm_graduacao` AS `nm_graduacao_inicial`,
        `grd2`.`nm_graduacao` AS `nm_graduacao_final`
    FROM
        (((`alyssonv_competicoestkd`.`detalhes_regras_luta` `drl`
        JOIN `alyssonv_competicoestkd`.`regras_lutas` `rls` ON ((`rls`.`id_regra_luta` = `drl`.`id_regra_luta`)))
        JOIN `alyssonv_competicoestkd`.`graduacoes` `grd` ON ((`grd`.`id_graduacao` = `drl`.`id_graduacao_inicial`)))
        JOIN `alyssonv_competicoestkd`.`graduacoes` `grd2` ON ((`grd2`.`id_graduacao` = `drl`.`id_graduacao_final`)))
    WHERE
        ((`drl`.`id_categoria_peso` = 1)
            AND (`drl`.`id_categoria_idade` = 6)
            AND (`drl`.`id_sexo` = 1))