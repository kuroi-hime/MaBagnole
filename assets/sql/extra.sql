-- Vue SQL : ListeVehicules
CREATE VIEW IF NOT EXISTS ListeVehicules AS
SELECT id_vehicule, marque, modele, prix, nbr_portes, nbr_places, moteur, boite_vitesse, climatisation, airbag, v.description, categorie_id, c.nom_categorie, c.description as 'description_vehicule', AVG(r.note) as moyenne_avis, duree, re.statut, re.client_id
FROM Vehicules v
LEFT JOIN Categories c ON v.categorie_id = c.id_categorie
LEFT JOIN commentaires r ON v.id_vehicule = r.vehicule_id
LEFT JOIN reservations re ON r.vehicule_id = re.vehicule_id
GROUP BY v.id_vehicule;

-- Procédure Stockée : AjouterReservation
DELIMITER // --à cause de ; aprés insert il marque la fin et rend end; orphelin

CREATE PROCEDURE IF NOT EXISTS AjouterReservation(IN p_client_id INT, IN p_vehicule_id INT, IN p_date_debut DATE, IN p_duree INT, IN p_lieu_depart VARCHAR(100), IN p_lieu_reteur VARCHAR(100))
BEGIN
    INSERT INTO Reservation (client_id, vehicule_id, date_debut, duree, lieu_depart, lieu_reteur, status)
    VALUES (p_client_id, p_vehicule_id, p_date_debut, p_duree, p_lieu_depart, p_lieu_reteur, 'En attente');
END //

DELIMITER ;