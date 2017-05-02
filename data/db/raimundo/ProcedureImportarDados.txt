
delimiter |

create procedure importarDados()

begin


DECLARE id_importacao int DEFAULT 0;
DECLARE nm_endereco varchar(100);
DECLARE nm_cidade varchar(100);
DECLARE nm_estado varchar(100);
DECLARE id_estado int;
DECLARE id_cidade int;
DECLARE tell_fixo varchar(100);
DECLARE tell_celular varchar(100);
DECLARE email varchar(100);
declare a int;
DECLARE etapa_turma varchar(100);
DECLARE nm_etapa varchar(100);
DECLARE id_periodo int;

DECLARE nm_catequizando varchar(100);
DECLARE id_catequizando int;
DECLARE dt_nascimento varchar(100);
DECLARE dt_cadastro varchar(100);
DECLARE sexo varchar(100);
DECLARE cs_necessidade varchar(100);
DECLARE observacao text;

DECLARE sac_B varchar(1);
DECLARE id_sacramento int;

DECLARE responsavel varchar(100);
DECLARE id_responsavel int;
DECLARE id_grau_parentesco int;
DECLARE nm_responsavel varchar(100);
DECLARE situacaoconjugal varchar(100);
DECLARE ds_situacao varchar(100);
DECLARE id_situacao_responsavel int;
declare situacao_dizimo varchar(20);
declare id_situacao int default 1;




simple_loop: LOOP

set id_importacao = (SELECT importacao.id_importacao from importacao WHERE importacao.flag = 0 limit 1);

if id_importacao is null THEN 
-- drop TABLE importacao;
LEAVE simple_loop;
END IF;



if id_importacao is not null THEN


set nm_cidade = (SELECT importacao.naturalidade from importacao WHERE importacao.id_importacao = id_importacao);
set nm_estado = (SELECT importacao.estado from importacao WHERE importacao.id_importacao = id_importacao limit 1);
set id_estado = (select estado.id_estado FROM estado WHERE estado.sg_estado like nm_estado);
set id_cidade = (select cidade.id_cidade from cidade WHERE cidade.id_estado = id_estado and cidade.nm_cidade like nm_cidade);
set nm_endereco = (SELECT importacao.nm_endereco from importacao WHERE importacao.id_importacao = id_importacao);
if id_cidade is not null THEN INSERT into endereco(nm_logradouro, id_cidade) VALUES(nm_endereco, id_cidade);
else INSERT into endereco(nm_logradouro, id_cidade) VALUES(nm_endereco, 1724);

end
if;
set nm_estado = (select max(endereco.id_endereco) from endereco);

set tell_fixo = (SELECT importacao.tel_fixo FROM importacao WHERE importacao.id_importacao = id_importacao);

if tell_fixo is not null then set tell_celular = (SELECT importacao.tel_celular FROM importacao WHERE importacao.id_importacao = id_importacao);
INSERT INTO telefone(telefone.nr_telefone, telefone.id_tipo_telefone, telefone.id_situacao) VALUES(tell_fixo, 1, 1);
set tell_fixo = (SELECT max(telefone.id_telefone) FROM telefone);
end
if;


if tell_celular is not null then INSERT INTO telefone(telefone.nr_telefone, telefone.id_tipo_telefone, telefone.id_situacao) VALUES(tell_celular, 3, 1);
set tell_celular = (SELECT max(telefone.id_telefone) FROM telefone);
end
if;
set email = (SELECT importacao.email from importacao WHERE importacao.id_importacao = id_importacao);



set nm_catequizando = (SELECT importacao.nm_catequizando from importacao WHERE importacao.id_importacao = id_importacao);
set dt_nascimento = (SELECT importacao.dt_nascimento FROM importacao WHERE importacao.id_importacao = id_importacao);
set dt_cadastro = (SELECT importacao.dt_referencial FROM importacao WHERE importacao.id_importacao = id_importacao);
if dt_nascimento like "%/%" then
set dt_nascimento = (concat(substring(dt_nascimento, 7, 10), "-", substring(dt_nascimento, 4, 2), '-', substring(dt_nascimento, 1, 2)));
else 
set dt_nascimento = "0000-00-00";
end if;
set dt_cadastro = (concat(substring(dt_cadastro, 7, 10), "-", substring(dt_cadastro, 4, 2), '-', substring(dt_cadastro, 1, 2)));


set sexo = (SELECT importacao.sexo FROM importacao WHERE importacao.id_importacao = id_importacao);
if sexo like "M"
THEN
set sexo = "masculino";
ELSE set sexo = "feminino";

END
if;


set sexo = (SELECT sexo.id_sexo from sexo WHERE sexo.nm_sexo like sexo);
set cs_necessidade = (SELECT importacao.necessidade_especial FROM importacao WHERE importacao.id_importacao = id_importacao);
if cs_necessidade like "%sim%" then
set cs_necessidade ="s";
else
set cs_necessidade="n"; 

end if;

set observacao = (SELECT importacao.observacao FROM importacao WHERE importacao.id_importacao = id_importacao);


IF email LIKE "%@%"
THEN
insert into email(em_email, id_situacao) VALUES(email, 1);
set email = (SELECT max(email.id_email) FROM email);

insert into catequizando(nm_catequizando, dt_nascimento, dt_ingresso, id_sexo, cs_necessidade_especial, id_endereco, id_telefone_residencial, id_telefone_celular, tx_observacao, id_email, id_naturalidade,id_situacao) VALUES(nm_catequizando, dt_nascimento, dt_cadastro, sexo, cs_necessidade, nm_estado, tell_fixo, tell_celular, observacao, email, id_cidade,id_situacao);

ELSE

insert into catequizando(nm_catequizando, dt_nascimento, dt_ingresso, id_sexo, cs_necessidade_especial, id_endereco, id_telefone_residencial, id_telefone_celular, tx_observacao, id_naturalidade) VALUES(nm_catequizando, dt_nascimento, dt_cadastro, sexo, cs_necessidade, nm_estado, tell_fixo, tell_celular, observacao, id_cidade);


end
if;


set id_catequizando = (select max(catequizando.id_catequizando) from catequizando);
set a = (SELECT importacao.contribuicao from importacao WHERE importacao.id_importacao = id_importacao);
insert into contribuicao(contribuicao.vl_contribuicao, contribuicao.dt_cadastro) VALUES(a, now());
set a = (SELECT max(contribuicao.id_contribuicao) FROM contribuicao);

INSERT into catequizando_contribuicao(catequizando_contribuicao.id_catequizando, catequizando_contribuicao.id_contribuicao) VALUES(id_catequizando, a);




set etapa_turma = (SELECT importacao.etapa_turma from importacao WHERE importacao.id_importacao = id_importacao);
set observacao = etapa_turma;

if etapa_turma like "%sala%"
then
set a = 1;
loop_sala: loop

if etapa_turma like concat("%sala ", a, "%") then
set a = a;
leave loop_sala;
end IF;

if a > 6 then leave loop_sala;
set a = null;
end
if;

set a = a + 1;
END LOOP loop_sala;
end
if;






if substring(etapa_turma, 1, 7) LIKE "%CRISMA"
THEN

set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%CRISMA I");



end
if;

if substring(etapa_turma, 1, 13) LIKE "%EUCARISTIA I "
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%EUCARISTIA I");


end
if;

if substring(etapa_turma, 1, 13) LIKE "%EUCARISTIA II"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%EUCARISTIA II");


end
if;


if substring(etapa_turma, 1, 7) LIKE "%ADULTOS"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%ADULTOs I");



end
if;

if substring(etapa_turma, 1, 9) LIKE "%ADULTO II"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%ADULTOs II");



end
if;

if substring(etapa_turma, 1, 4) LIKE "%PRÉ-"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%PRÉ-CRISMA");



end
if;

if substring(etapa_turma, 1, 4) LIKE "%PERS"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%Perseverança ");



end
if;

if substring(etapa_turma, 1, 12) LIKE "%INICIAÇÃO I "
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%INICIAÇÃO I");



end
if;

if substring(etapa_turma, 1, 12) LIKE "%INICIAÇÃO II"
THEN
set nm_etapa = (SELECT etapa.id_etapa FROM etapa WHERE etapa.nm_etapa LIKE "%INICIAÇÃO II");


end
if;

INSERT into catequizando_etapa_cursou(catequizando_etapa_cursou.id_etapa, catequizando_etapa_cursou.id_catequizando, catequizando_etapa_cursou.dt_cadastro) VALUES(nm_etapa, id_catequizando, now());



if etapa_turma LIKE "%2016/2017%"
THEN
set id_periodo = (SELECT periodo_letivo.id_periodo_letivo FROM periodo_letivo WHERE periodo_letivo.dt_ano_letivo LIKE "%2016%"
limit 1);

if id_periodo is null THEN INSERT into periodo_letivo(dt_ano_letivo) VALUES(2016);
set id_periodo = (SELECT max(periodo_letivo.id_periodo_letivo) from periodo_letivo);
end
if;
end
if;

if etapa_turma LIKE "%2017/2018%"
THEN
set id_periodo = (SELECT periodo_letivo.id_periodo_letivo FROM periodo_letivo WHERE periodo_letivo.dt_ano_letivo LIKE "%2017%"
limit 1);

if id_periodo is null THEN INSERT into periodo_letivo(periodo_letivo.dt_ano_letivo) VALUES(2017);
set id_periodo = (SELECT max(periodo_letivo.id_periodo_letivo) from periodo_letivo);

end
if;
end
if;

set etapa_turma = (SELECT etapa.nm_etapa FROM etapa WHERE etapa.id_etapa = nm_etapa);

set email=(SELECT turma.id_turma from turma WHERE turma.nm_turma like etapa_turma LIMIT 1);

if email is null THEN 

if etapa_turma is not null then
INSERT INTO turma(nm_turma,id_etapa) VALUES(etapa_turma,nm_etapa);
set email=(SELECT max(turma.id_turma) from turma);
end if;
END IF;





INSERT INTO turma_catequizando(id_turma, id_catequizando, id_usuario, id_periodo_letivo, dt_cadastro, nr_sala, tx_observacoes) VALUES(email, id_catequizando, 1, id_periodo, now(), a, observacao);







set sac_B = (SELECT importacao.B from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Batismo");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");

INSERT into sacramento_catequizando(id_catequizando, id_sacramento, dt_cadastro) VALUES(id_catequizando, id_sacramento, curdate());
END
if;


set sac_B = (SELECT importacao.E from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Eucaristia");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");

INSERT into sacramento_catequizando(id_catequizando, id_sacramento, dt_cadastro) VALUES(id_catequizando, id_sacramento, curdate());
END
if;


set sac_B = (SELECT importacao.M from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Matrimônio");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");

INSERT into sacramento_catequizando(id_catequizando, id_sacramento, dt_cadastro) VALUES(id_catequizando, id_sacramento, curdate());
END
if;


set sac_B = (SELECT importacao.C from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Crisma");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");

INSERT into sacramento_catequizando(id_catequizando, id_sacramento, dt_cadastro) VALUES(id_catequizando, id_sacramento, curdate());
END
if;

set id_responsavel = (SELECT importacao.idade_2016 FROM importacao WHERE importacao.id_importacao = id_importacao);
set responsavel = (SELECT importacao.responsavel FROM importacao WHERE importacao.id_importacao = id_importacao);
if id_responsavel < 19 then



set nm_responsavel = (SELECT importacao.nm_responsavel FROM importacao WHERE importacao.id_importacao = id_importacao);


set tell_fixo = (SELECT importacao.tel_responsavel FROM importacao WHERE importacao.id_importacao = id_importacao);
if tell_fixo is not null then INSERT INTO telefone(telefone.nr_telefone, telefone.id_tipo_telefone, telefone.id_situacao) VALUES(tell_fixo, 1, 1);
set tell_fixo = (SELECT max(telefone.id_telefone) FROM telefone);
end
if;

set email = (SELECT importacao.email_responsavel from importacao WHERE importacao.id_importacao = id_importacao);



if responsavel like "%Pai%"
or "%Avô%"
THEN
set sexo = "Masculino";
set sexo = (SELECT sexo.id_sexo from sexo WHERE nm_sexo like sexo);

ELSE set sexo = "Feminino";
set sexo = (SELECT sexo.id_sexo from sexo WHERE nm_sexo like sexo);
END IF;

IF email LIKE "%@%"
THEN
insert into email(em_email, id_situacao) VALUES(email, 1);
set email = (SELECT max(email.id_email) FROM email);

INSERT into responsavel(nm_responsavel, id_sexo, id_telefone_residencial, id_email) VALUES(nm_responsavel, sexo, tell_fixo, email);
ELSE
INSERT into responsavel(nm_responsavel, id_sexo, id_telefone_residencial) VALUES(nm_responsavel, sexo, tell_fixo);

end
if;
set situacaoconjugal = (select importacao.estado_civil from importacao where importacao.id_importacao=id_importacao);
set ds_situacao = (select situacao_conjugal.id_situacao_conjugal from situacao_conjugal where situacao_conjugal.ds_situacao_conjugal like situacaoconjugal  limit 1);
if ds_situacao is null then
insert into situacao_conjugal(situacao_conjugal.ds_situacao_conjugal) values(situacaoconjugal) ;
set ds_situacao = (select max(situacao_conjugal.id_situacao_conjugal) from situacao_conjugal);

end if;

set id_responsavel = (SELECT max(responsavel.id_responsavel) from responsavel);
set id_grau_parentesco = (SELECT grau_parentesco.id_grau_parentesco from grau_parentesco WHERE grau_parentesco.nm_grau_parentesco LIKE responsavel);

INSERT into responsavel_catequizando(id_responsavel, id_catequizando, id_grau_parentesco,id_situacao_conjugal) VALUES(id_responsavel, id_catequizando, id_grau_parentesco,ds_situacao);

set nm_responsavel = (SELECT importacao.nm_pai FROM importacao WHERE importacao.id_importacao = id_importacao);
set situacao_dizimo = (SELECT importacao.dizimo_pai FROM importacao WHERE importacao.id_importacao = id_importacao);
if situacao_dizimo like "%sim%"
THEN
set situacao_dizimo = true;
ELSE set situacao_dizimo = false;
end
if;

set tell_fixo = (SELECT importacao.tel_pai FROM importacao WHERE importacao.id_importacao = id_importacao);
if tell_fixo is not null then INSERT INTO telefone(nr_telefone, id_tipo_telefone, id_situacao) VALUES(tell_fixo, 1, 1);
set tell_fixo = (SELECT max(telefone.id_telefone) FROM telefone);
end
if;
set id_grau_parentesco = (SELECT grau_parentesco.id_grau_parentesco from grau_parentesco WHERE grau_parentesco.nm_grau_parentesco LIKE "%Pai%");
set sexo = 1;
INSERT into responsavel(responsavel.nm_responsavel, responsavel.id_sexo, responsavel.id_telefone_residencial, responsavel.st_dizimo) VALUES(nm_responsavel, sexo, tell_fixo, situacao_dizimo);
set id_responsavel = (SELECT max(responsavel.id_responsavel) from responsavel);
INSERT into responsavel_catequizando(id_responsavel, id_catequizando, id_grau_parentesco) VALUES(id_responsavel, id_catequizando, id_grau_parentesco);

set sac_B = (SELECT importacao.B_pai from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Batismo");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.E_pai from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Eucaristia");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.M_pai from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Matrimônio");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.C_pai from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Crisma");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;

set situacaoconjugal= (select importacao.situacao_pais from importacao where importacao.id_importacao = id_importacao);
set id_situacao_responsavel =(select situacao_responsavel.id_situacao_responsavel from situacao_responsavel 
WHERE situacao_responsavel.ds_situacao_responsavel like situacaoconjugal);

if id_situacao_responsavel is null THEN INSERT into situacao_responsavel(ds_situacao_responsavel) VALUES(situacaoconjugal);
set id_situacao_responsavel = (SELECT max(id_situacao_responsavel) from situacao_responsavel);
end
if;
insert into situacao_responsavel_catequizando(id_catequizando, id_responsavel, id_situacao_responsavel) VALUES(id_catequizando, id_responsavel, id_situacao_responsavel);
set nm_responsavel = (SELECT importacao.nm_mae FROM importacao WHERE importacao.id_importacao = id_importacao);

set situacao_dizimo = (SELECT importacao.dizimo_mae FROM importacao WHERE importacao.id_importacao = id_importacao);
if situacao_dizimo like "%sim%"
THEN
set situacao_dizimo = true;
ELSE set situacao_dizimo = false;
end
if;



set tell_fixo = (SELECT importacao.tel_mae FROM importacao WHERE importacao.id_importacao = id_importacao);
if tell_fixo is not null then INSERT INTO telefone(nr_telefone, id_tipo_telefone, id_situacao) VALUES(tell_fixo, 1, 1);
set tell_fixo = (SELECT max(telefone.id_telefone) FROM telefone);
end
if;

set id_grau_parentesco = (SELECT grau_parentesco.id_grau_parentesco from grau_parentesco WHERE grau_parentesco.nm_grau_parentesco LIKE "%Mae%");
set sexo = 2;
INSERT into responsavel(responsavel.nm_responsavel, responsavel.id_sexo, responsavel.id_telefone_residencial, responsavel.st_dizimo) VALUES(nm_responsavel, sexo, tell_fixo, situacao_dizimo);
set id_responsavel = (SELECT max(responsavel.id_responsavel) from responsavel);

INSERT into responsavel_catequizando(id_responsavel, id_catequizando, id_grau_parentesco) VALUES(id_responsavel, id_catequizando, id_grau_parentesco);

set sac_B = (SELECT importacao.B_mae from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Batismo");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Batismo%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.E_mae from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Eucaristia");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Eucaristia%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.M_mae from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Matrimônio");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Matrimônio%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;


set sac_B = (SELECT importacao.C_mae from importacao WHERE importacao.id_importacao = id_importacao);
if sac_B is not null THEN set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");
if id_sacramento is null THEN INSERT into sacramento(nm_sacramento) VALUES("Crisma");
end
if;

set id_sacramento = (SELECT sacramento.id_sacramento FROM sacramento WHERE sacramento.nm_sacramento LIKE "%Crisma%");

INSERT into sacramento_responsavel(id_responsavel, id_sacramento) VALUES(id_responsavel, id_sacramento);
END
if;

insert into situacao_responsavel_catequizando(id_catequizando, id_responsavel, id_situacao_responsavel) VALUES(id_catequizando, id_responsavel, id_situacao_responsavel);


end
if;

UPDATE importacao set importacao.flag = 1 WHERE importacao.id_importacao = id_importacao;

end
if;


END LOOP simple_loop;




end
|

delimiter ;


call importarDados();