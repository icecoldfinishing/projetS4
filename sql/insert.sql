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

INSERT INTO typePret (nom, taux, assurance, duree) VALUES
('Prêt personnel', 5.00, 1.50, 60),
('Prêt immobilier', 3.00, 0.80, 240),
('Prêt auto', 4.50, 1.20, 48),
('Prêt étudiant', 2.50, 0.50, 120),
('Prêt travaux', 3.75, 1.00, 72);


INSERT INTO compteEntreprise (valeur,date) VALUES (20000000,'2025-01-09');

INSERT INTO pret (id_user, id_statut, valeur, dateDebut, duree, delai, id_typePret, commentaire, assurance) VALUES
(3, 1, 1500000, '2025-07-16', 12, 2, 1, 'Prêt pour projet A', 1),
(3, 1, 2500000, '2025-07-16', 24, 3, 2, 'Prêt pour projet B', 2),
(3, 1, 3000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet C', 1),
(3, 1, 4500000, '2025-07-16', 12, 2, 3, 'Prêt pour projet D', 2),
(3, 1, 6000000, '2025-07-16', 24, 3, 2, 'Prêt pour projet E', 1),
(3, 1, 7000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet F', 2),
(3, 1, 8000000, '2025-07-16', 12, 2, 2, 'Prêt pour projet G', 1),
(3, 1, 9000000, '2025-07-16', 24, 3, 3, 'Prêt pour projet H', 2),
(3, 1, 10000000, '2025-07-16', 36, 1, 1, 'Prêt pour projet I', 1),
(3, 1, 11000000, '2025-07-16', 12, 2, 2, 'Prêt pour projet J', 2);
