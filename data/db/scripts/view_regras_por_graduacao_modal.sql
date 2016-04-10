CREATE OR REPLACE VIEW vw_regras_lutas AS
SELECT 
		rls.id_regra_luta,
        rls.nm_regra_luta,
        grd.nm_graduacao as nm_graduacao_inicial,
        grd2.nm_graduacao as nm_graduacao_final
FROM 
		detalhes_regras_luta drl
        INNER JOIN regras_lutas rls
			ON rls.id_regra_luta = drl.id_regra_luta
		INNER JOIN graduacoes grd
			ON grd.id_graduacao = drl.id_graduacao_inicial
		INNER JOIN graduacoes grd2
			ON grd2.id_graduacao = drl.id_graduacao_final
WHERE 		
        drl.id_categoria_peso = 1
        AND drl.id_categoria_idade = 6
        AND drl.id_sexo = 1
        