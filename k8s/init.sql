CREATE DATABASE IF NOT EXISTS gestionEtudiant;
USE gestionEtudiant;

CREATE TABLE admins (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cin VARCHAR(255) NOT NULL UNIQUE,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tel VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ... include the rest of the tables (filieres, etudiants) from the first response