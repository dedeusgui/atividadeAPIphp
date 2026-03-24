CREATE DATABASE IF NOT EXISTS api_guilherme;
USE api_guilherme;

CREATE TABLE IF NOT EXISTS sobre_mim (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    cor_do_olho VARCHAR(50) NOT NULL,
    tamanho VARCHAR(50) NOT NULL
);

INSERT INTO sobre_mim (nome_completo, cor_do_olho, tamanho) 
VALUES ('Guilherme', 'Castanho', '1.80m');
