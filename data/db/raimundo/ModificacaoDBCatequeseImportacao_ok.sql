
ALTER TABLE situacao_responsavel_catequizando ADD id_responsavel int;

ALTER TABLE situacao_responsavel_catequizando ADD CONSTRAINT Fk_id_responsavel  FOREIGN KEY (id_responsavel)
REFERENCES responsavel(id_responsavel);

insert into etapa (nm_etapa) values("inicia��o I"),("inicia��o II");

alter TABLE responsavel add st_dizimo boolean DEFAULT false;


create TABLE contribuicao(
  id_contribuicao int not null auto_increment,
  vl_contribuicao float,
  dt_cadastro timestamp, CONSTRAINT pk_contribuicao PRIMARY KEY (id_contribuicao)


);


create TABLE catequizando_contribuicao(
  id_catequizando_contribuicao int not null auto_increment,
  id_catequizando int,
  id_contribuicao int,
  CONSTRAINT pk_catequizando_contribuicao PRIMARY KEY (id_catequizando_contribuicao),
  CONSTRAINT fk_catequizando_contribuicao FOREIGN KEY (id_catequizando) REFERENCES catequizando(id_catequizando),
  CONSTRAINT fk_contribuicao_catequizando FOREIGN KEY (id_contribuicao) REFERENCES contribuicao(id_contribuicao)



);

alter TABLE catequizando MODIFY COLUMN dt_nascimento
date;
alter TABLE catequizando MODIFY COLUMN dt_ingresso
date;



CREATE TABLE importacao (
    nm_catequizando varchar(500),
    dt_nascimento varchar(20),
    dt_referencial varchar(20),
    idade_2016 int,
    etapa_turma varchar(500),
    nm_endereco varchar(500),
    tel_fixo varchar(50),
    tel_celular varchar(50),
    email varchar(100),
    naturalidade varchar(500),
    estado varchar(100),
    sexo varchar(100),
    B VARCHAR(1),
    E VARCHAR(1),
    C VARCHAR(1),
    M VARCHAR(1),
    comp varchar(5),
    estado_civil varchar(500),
    necessidade_especial varchar(500),
    responsavel varchar(500),
    nm_responsavel varchar(500),
    tel_responsavel varchar(116),
    email_responsavel varchar(500),
    situacao_pais varchar(500),
    contribuicao decimal(10,2),
    nm_pai varchar(500),
    tel_pai varchar(500),
    religiao_pai varchar(500),
    B_pai VARCHAR(1),
    E_pai VARCHAR(1),
    C_pai VARCHAR(1),
    M_pai VARCHAR(1),
    dizimo_pai varchar(30),
    nm_mae varchar(500),
    tel_mae varchar(500),
    religiao_mae varchar(500),
    B_mae VARCHAR(1),
    E_mae VARCHAR(1),
    C_mae VARCHAR(1),
    M_mae VARCHAR(1),
    dizimo_mae varchar(30),
    observacao varchar(5000),
    id_importacao int AUTO_INCREMENT PRIMARY key,
    flag int default 0
);


LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/catequese/data/db/raimundo/catequese_2017.csv' INTO TABLE importacao
CHARACTER SET UTF8
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES;
