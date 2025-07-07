

-- Insérer des étudiants (table indépendante)
INSERT INTO etudiant (nom, prenom, email, age) VALUES
('Rasoa', 'Miora', 'miora.rasoa@example.com', 22),
('Andry', 'Haja', 'haja.andry@example.com', 24),
('Lova', 'Faly', 'faly.lova@example.com', 21);

-- Insérer des établissements financiers
INSERT INTO etablissement_financier (nom, adresse, fond_disponible, date_creation) VALUES
('Banque Centrale', '123 Rue Principale, Antananarivo', 1000000000.00, '2000-01-01'),
('BNI Madagascar', '45 Avenue de l Indépendance, Antananarivo', 500000000.00, '2010-06-15'),
('BFV Société Générale', '77 Boulevard de la Liberté, Toamasina', 300000000.00, '2005-09-20');

-- Insérer des types de prêt
INSERT INTO type_pret (nom, taux_annuel, duree_max) VALUES
('Prêt Immobilier', 6.50, 180),
('Prêt Auto', 5.20, 60),
('Prêt Personnel', 7.00, 36);

-- Insérer des clients
INSERT INTO client (nom, prenom, email, age, profession, revenu_mensuel, date_inscription) VALUES
('Rakoto', 'Jean', 'jean.rakoto@example.com', 35, 'Ingénieur', 2500000.00, '2023-01-10'),
('Rabe', 'Marie', 'marie.rabe@example.com', 28, 'Comptable', 1800000.00, '2024-03-22'),
('Andrian', 'Hery', 'hery.andrian@example.com', 42, 'Chef d entreprise', 5000000.00, '2022-11-05');

-- Insérer des prêts
INSERT INTO pret (client_id, type_pret_id, etablissement_id, montant, duree, date_demande, statut) VALUES
(1, 1, 1, 150000000.00, 120, '2025-06-01', 'en_attente'),
(2, 2, 2, 20000000.00, 48, '2025-05-20', 'accepte'),
(3, 3, 3, 5000000.00, 24, '2025-04-15', 'refuse');

-- Insérer des remboursements pour le prêt accepté (id=2)
INSERT INTO remboursement (pret_id, montant, date_paiement) VALUES
(2, 500000.00, '2025-06-01'),
(2, 500000.00, '2025-07-01'),
(2, 500000.00, '2025-08-01');
