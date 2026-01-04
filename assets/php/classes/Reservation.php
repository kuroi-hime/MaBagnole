<?php

    class Reservation {
        private $id_reservation;
        private $date_debut;
        private $duree;
        private $lieu_depart;
        private $lieu_reteur;
        private $statut;
        private $vehicule_id;
        private $client_id;

        public function __get($proprety){
            return $this->$proprety;
        }

        public function __set($proprety, $value){
            return $this->$proprety = $value;
        }

        public function __toString() {
            return 
                "Réservation $this->id_reservation : Véhicule $this->vehicule_id réservé par Client $this->client_id | Du $this->date_debut ($this->duree jours) | Trajet : $this->lieu_depart -> $this->lieu_reteur | Statut : $this->statut";
        }

        static function allReservations($pdo) {
            try {
                $sql = "SELECT * FROM reservations";
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'Reservation');
                
                return $results;
            } catch (Exception $e) {
                error_log($e->getMessage());
                return [];
            }
        }

        static function revenu($pdo){
            try {
                $sql = "SELECT SUM(prix*duree) as total FROM ListeVehicules WHERE statut='Confirmée'";
                $stmt = $pdo->query($sql);
                $count = $stmt->fetch();
                
                return $count['total'];
            } catch(Exception $e) {
                return 0;
            }
        }

        static function getByClient($pdo, $id_client) {
            $sql = "SELECT r.*, v.modele, v.image, v.id_vehicule,
                    c.note, c.contenu as texte_avis 
                    FROM reservations r
                    JOIN vehicules v ON r.vehicule_id = v.id_vehicule
                    LEFT JOIN commentaires c ON (c.vehicule_id = v.id_vehicule AND c.client_id = :id_client)
                    WHERE r.client_id = :id_client2
                    ORDER BY r.date_debut DESC";
                    
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_client' => $id_client, 'id_client2' => $id_client]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Reservation');
        }

        public static function creerReservation($pdo, $clientId, $vehiculeId, $dateDebut, $duree, $depart, $retour) {
            try {
                $sql = "CALL AjouterReservation(:client, :vehicule, :debut, :duree, :depart, :retour)";
                $stmt = $pdo->prepare($sql);

                return $stmt->execute([$clientId, $vehiculeId, $dateDebut, $duree, $depart, $retour]);
            } catch (PDOException $e) {
                error_log("Erreur SQL Procédure : " . $e->getMessage());
                return false;
            }
        }

    }
?>