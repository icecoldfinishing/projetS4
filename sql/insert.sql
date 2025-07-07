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