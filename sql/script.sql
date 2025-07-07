

DROP DATABASE IF EXISTS tp_flight;
CREATE DATABASE tp_flight CHARACTER SET utf8mb4;
USE tp_flight;

CREATE TABLE role (
  id INT PRIMARY KEY AUTO_INCREMENT,
  valeur VARCHAR(255)
);

CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_role INT,
  nom VARCHAR(255),
  prenom VARCHAR(255),
  pwd VARCHAR(255),
  FOREIGN KEY (id_role) REFERENCES role(id)
);

CREATE TABLE statut (
  id INT PRIMARY KEY AUTO_INCREMENT,
  valeur VARCHAR(255)
);

CREATE TABLE investissement (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_user INT,
  id_statut INT,
  capital INT,
  dateDebut DATE,
  duree INT,
  taux INT,
  FOREIGN KEY (id_user) REFERENCES user(id),
  FOREIGN KEY (id_statut) REFERENCES statut(id)
);

CREATE TABLE typePret (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(255),
  taux DECIMAL(10,2),
  duree int
);

CREATE TABLE pret (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_user INT,
  id_statut INT,
  valeur INT,
  dateDebut DATE,
  duree INT,
  id_typePret INT,
  FOREIGN KEY (id_user) REFERENCES user(id),
  FOREIGN KEY (id_statut) REFERENCES statut(id),
  FOREIGN KEY (id_typePret) REFERENCES typePret(id)
);

CREATE TABLE remboursement (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_investissement INT,
  id_pret INT,
  valeur INT,
  dateRemboursement DATE,
  FOREIGN KEY (id_investissement) REFERENCES investissement(id),
  FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE TABLE compteEntreprise (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_pret INT,
  id_investissement INT,
  id_remboursement INT,
  valeur INT,
  FOREIGN KEY (id_pret) REFERENCES pret(id),
  FOREIGN KEY (id_investissement) REFERENCES investissement(id),
  FOREIGN KEY (id_remboursement) REFERENCES remboursement(id)
);

