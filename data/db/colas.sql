mysqldump -u root -B bdcatequese -p > C:\xampp\htdocs\catequese\data\db\script_inicial.sql

mysql -u root -p < C:\xampp\htdocs\catequese\data\db\script_inicial.sql


 SET @@global.sql_mode= 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';