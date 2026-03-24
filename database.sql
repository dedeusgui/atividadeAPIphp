CREATE DATABASE IF NOT EXISTS api_guilherme;
USE api_guilherme;

DROP TABLE IF EXISTS guilherme;
CREATE TABLE guilherme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    peso VARCHAR(50) NOT NULL,
    altura VARCHAR(50) NOT NULL,
    cor_cabelo VARCHAR(50) NOT NULL,
    cor_olho VARCHAR(50) NOT NULL
);

INSERT INTO guilherme (peso, altura, cor_cabelo, cor_olho) 
VALUES ('75kg', '1.85m', 'Castanho', 'Castanho');
