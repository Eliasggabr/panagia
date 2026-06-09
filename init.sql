CREATE DATABASE IF NOT EXISTS panagia;
USE panagia;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo VARCHAR(20) NOT NULL DEFAULT 'leitor'
);

CREATE TABLE IF NOT EXISTS artigos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(100) NOT NULL DEFAULT 'admin',
    conteudo TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS oracoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS santos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    biografia TEXT NOT NULL
);

INSERT INTO usuarios (nome, email, senha, tipo) 
VALUES ('Admin - Elias', 'admin@panagia', 'EG13062009TY456', 'admin')
ON DUPLICATE KEY UPDATE tipo='admin';
