create database barbearia_db;
use barbearia_db;

CREATE TABLE barbeiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

insert into barbeiros (nome) values ('Fernando');
insert into barbeiros (nome) values ('Jeferson');
insert into barbeiros (nome) values ('Paulo');


select * from barbeiros
;

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    duracao INT NOT NULL
);

insert into servicos (nome, duracao) values ('cabelo', '1');
insert into servicos (nome, duracao) values ('barba', '1');
insert into servicos (nome, duracao) values ('sombrancelha', '1');
insert into servicos (nome, duracao) values ('coloracao', '2');

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(100),
    telefone VARCHAR(20),
    barbeiro_id INT,
    servico_id INT,
    data DATE,
    hora TIME,
    FOREIGN KEY (barbeiro_id) REFERENCES barbeiros(id),
    FOREIGN KEY (servico_id) REFERENCES servicos(id)
);

select * from agendamentos;

ALTER TABLE agendamentos 
ADD UNIQUE (data, hora, barbeiro_id);

CREATE TABLE servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255)
);

select * from servico;

CREATE TABLE servicos_realizados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    imagem VARCHAR(255) NOT NULL,
    data_servico DATE DEFAULT CURRENT_DATE
);
