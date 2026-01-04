-- Insertion des valeurs dans la table utilisateurs:
-- Admin
INSERT INTO utilisateurs (nom_user, email, role, mot_passe_hash) VALUES
('Admin Principal', 'admin@mabagnole.com', 'admin', md5('admin123'));

-- Clients
INSERT INTO utilisateurs (nom_user, cin, role, email, mot_passe_hash, telephone, adresse, ville) VALUES
('Ahmed Alami', 'AB1234', 'client', 'ahmed@mabagnole.ma', md5('ahmed123'), '+212600112233', 'Rue 123, Maarif', 'Casablanca'),
('Sara Bennani', 'CD5678', 'client', 'sara@email.com', md5('sara123'), '+212661445566', 'Appt 4, Agdal', 'Rabat'),
('Karim Tazi', 'EF9012', 'client', 'karim@email.com', md5('karim123'), '+212670889900', 'Villa 15, Anfa', 'Casablanca');