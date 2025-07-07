-- Insertion des rôles
INSERT INTO role (valeur) VALUES
  ('investisseur'),
  ('etablissement'),
  ('client');

-- Insertion des statuts
INSERT INTO statut (valeur) VALUES
  ('en attente'),
  ('validé'),
  ('refusé');

-- Insertion des utilisateurs (avec le mot de passe "mdp")
-- On suppose que l'ordre des rôles est : 1 = investisseur, 2 = etablissement, 3 = client
INSERT INTO user (id_role, nom, prenom, pwd) VALUES
  (1, 'Dupont', 'Investisseur', 'mdp'),
  (2, 'Martin', 'Etablissement', 'mdp'),
  (3, 'Durand', 'Client', 'mdp');
