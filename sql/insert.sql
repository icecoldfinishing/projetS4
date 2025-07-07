-- Insertion des rôles
INSERT INTO role (valeur) VALUES
  ('investisseur'),
  ('etablissement'),
  ('client');

-- Insertion des statuts
INSERT INTO statut (valeur) VALUES
  ('en attente'),
  ('valide'),
  ('refuse');

-- Insertion des utilisateurs (avec le mot de passe "mdp")
-- On suppose que l'ordre des rôles est : 1 = investisseur, 2 = etablissement, 3 = client
INSERT INTO user (id_role, nom, prenom, pwd) VALUES
  (1, 'Rohy', 'Investisseur', 'mdp'),
  (2, 'Fenitra', 'Etablissement', 'mdp'),
  (3, 'Sanda', 'Client', 'mdp');

INSERT INTO typePret (nom, taux, duree) VALUES
('Prêt personnel', 5.00, 60),
('Prêt immobilier', 3.00, 240),
('Prêt auto', 4.50, 48),
('Prêt etudiant', 2.50, 120),
('Prêt travaux', 3.75, 72);


INSERT INTO pret (id_user, id_statut, valeur, dateDebut, duree, delai, id_typePret, commentaire) VALUES
(3, 1, 1500000, '2025-07-16', 12, 2, 1, 'Prêt pour projet A'),
(3, 1, 2500000, '2025-07-16', 24, 3, 2, 'Prêt pour projet B'),
(3, 1, 3000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet C'),
(3, 1, 4500000, '2025-07-16', 12, 2, 3, 'Prêt pour projet D'),
(3, 1, 6000000, '2025-07-16', 24, 3, 2, 'Prêt pour projet E'),
(3, 1, 7000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet F'),
(3, 1, 8000000, '2025-07-16', 12, 2, 2, 'Prêt pour projet G'),
(3, 1, 9000000, '2025-07-16', 24, 3, 3, 'Prêt pour projet H'),
(3, 1, 10000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet I'),
(3, 1, 11000000, '2025-07-16', 12, 2, 2, 'Prêt pour projet J');