

DROP DATABASE IF EXISTS tp_flight;
CREATE DATABASE tp_flight CHARACTER SET utf8mb4;
USE tp_flight;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    age INT
);

CREATE TABLE etablissement_financier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    adresse TEXT,
    fond_disponible DECIMAL(15,2) DEFAULT 0.00,
    date_creation DATE
);

CREATE TABLE type_pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    taux_annuel DECIMAL(5,2) NOT NULL CHECK (taux_annuel >= 0),
    duree_max INT NOT NULL COMMENT 'Durée maximale en mois'
);

CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    age INT,
    profession VARCHAR(100),
    revenu_mensuel DECIMAL(10,2),
    date_inscription DATE DEFAULT CURRENT_DATE
);

CREATE TABLE pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    type_pret_id INT NOT NULL,
    etablissement_id INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL CHECK (montant > 0),
    duree INT NOT NULL COMMENT 'Durée en mois',
    date_demande DATE NOT NULL DEFAULT CURRENT_DATE,
    statut ENUM('en_attente', 'accepte', 'refuse') DEFAULT 'en_attente',
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (type_pret_id) REFERENCES type_pret(id),
    FOREIGN KEY (etablissement_id) REFERENCES etablissement_financier(id)
);

CREATE TABLE remboursement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pret_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL CHECK (montant > 0),
    date_paiement DATE NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (pret_id) REFERENCES pret(id) ON DELETE CASCADE
);
