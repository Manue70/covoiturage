-- seed.sql - Données initiales

INSERT INTO agences (nom) VALUES
('Paris'), ('Lyon'), ('Marseille'), ('Toulouse'), ('Nice'),
('Nantes'), ('Strasbourg'), ('Montpellier'), ('Bordeaux'),
('Lille'), ('Rennes'), ('Reims');

INSERT INTO users (nom, prenom, telephone, email, role) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', 'user'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', 'user'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', 'user'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', 'user'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', 'user'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', 'user'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', 'user'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', 'user'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', 'user'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', 'user'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', 'user'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', 'user'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', 'user'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', 'user'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', 'user'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', 'user'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', 'user'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', 'user'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', 'user'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', 'user');

-- Admin à ajouter ensuite manuellement si hash du mot de passe
-- Vous pourrez ajouter un champ password hash plus tard

INSERT INTO trajets (depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles, user_id) VALUES
(1, 2, '2025-12-05 08:00:00', '2025-12-05 12:00:00', 4, 3, 1),
(3, 5, '2025-12-06 09:00:00', '2025-12-06 11:00:00', 3, 2, 2),
(11, 9, '2025-12-07 10:00:00', '2025-12-07 16:00:00', 5, 5, 3),
(4, 8, '2025-12-08 07:30:00', '2025-12-08 10:00:00', 4, 1, 4);
