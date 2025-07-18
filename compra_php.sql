use compra_php;
show tables;
DESCRIBE compra_php;
SHOW COLUMNS FROM compra_php;
SELECT DATABASE() as 'compra_php';
SHOW TABLES;
SHOW DATABASES;
select * from produto;
select * from compra_php;
describe usuario;
select * from usuario;
USE compra_php;
USE compra_php;

ALTER TABLE usuarios RENAME TO usuario;

CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL -- Corrigido para VARCHAR(255) para armazenar o hash da senha
);