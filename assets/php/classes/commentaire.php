<?php

class Commentaire {
    private $id_commentaire;
    private $contenu;
    private $note;
    private $date_commentaire;
    private $statut;
    private $client_id;
    private $vehicule_id;

    // Propriétés additionnelles pour l'affichage (via la jointure SQL)
    private $nom_client;
    private $modele_vehicule;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // --- GETTER MAGIQUE ---
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    // --- SETTER MAGIQUE ---
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            // Exemple de validation pour la note
            if ($property === 'note' && ($value < 0 || $value > 5)) {
                throw new Exception("La note doit être entre 0 et 5.");
            }
            $this->$property = $value;
        }
    }

    // --- RÉCUPÉRATION DE TOUS LES COMMENTAIRES ---
    public static function allCommentaires($pdo) {
        try {
            // On joint les tables utilisateurs et vehicules pour avoir des infos lisibles
            $sql = "SELECT c.*, u.nom_user as nom_client, v.modele as modele_vehicule 
                    FROM commentaires c
                    JOIN utilisateurs u ON c.client_id = u.id_user
                    JOIN vehicules v ON c.vehicule_id = v.id_vehicule
                    ORDER BY c.date_commentaire DESC";

            $stmt = $pdo->query($sql);
            
            // On retourne un tableau d'objets Commentaire
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Commentaire');
            
        } catch (PDOException $e) {
            error_log("Erreur allCommentaires: " . $e->getMessage());
            return [];
        }
    }
}