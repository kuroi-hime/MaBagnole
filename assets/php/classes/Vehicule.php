<?php
    class Vehicule {
        private $id_vehicule;
        private $marque;
        private $modele;
        private $prix;
        private $disponibilite;
        private $image;
        private $nbr_portes;
        private $nbr_places;
        private $moteur;
        private $boite_vitesse;
        private $climatisation;
        private $airbag;
        private $description;
        private $categorie_id;

        public function __get($property){
            if(!property_exists($this, $property))
                throw new Exception($property . ' est une propriété invalide.');
            
            return $this->$property;
        }

        public function __toString(){
            return ($this->marque ?? 'Inconnue') . " " . 
                   ($this->modele ?? '') . " (" . ($this->prix ?? 0) . "MAD)";
        }

        static function ajouter($pdo, $data) {
            $succes = false;
            try {
                $sql = "INSERT INTO vehicules (marque, modele, prix, image, nbr_portes, nbr_places, moteur, boite_vitesse, climatisation, airbag, description, categorie_id) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([
                    $data['marque'], $data['modele'], $data['prix'], $data['image'],
                    $data['nbr_portes'], $data['nbr_places'], $data['moteur'], 
                    $data['boite_vitesse'], $data['climatisation'], $data['airbag'], 
                    $data['description'], $data['categorie_id']
                ]);
            } catch (Exception $e) {
                
            } finally {
                unset($stmt);
                return $succes;
            }
        }

        public function modifier($pdo) {
            $succes = false;
            try {
                $sql = "UPDATE vehicules SET 
                        marque = ?, modele = ?, prix = ?, nbr_portes = ?, nbr_places = ?, 
                        moteur = ?, boite_vitesse = ?, climatisation = ?, airbag = ?, 
                        description = ?, categorie_id = ?, disponibilite = ?, image = ?
                        WHERE id_vehicule = ?";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([
                    $this->marque, $this->modele, $this->prix, $this->nbr_portes, $this->nbr_places,
                    $this->moteur, $this->boite_vitesse, $this->climatisation, $this->airbag,
                    $this->description, $this->categorie_id, $this->disponibilite, $this->image, $this->id_vehicule
                ]);
            } catch (Exception $e) {
                
            } finally {
                unset($stmt);
                return $succes;
            }
        }

        public function supprimer($pdo) {
            $succes = false;
            try {
                $sql = "DELETE FROM vehicules WHERE id_vehicule = ?";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([$this->id_vehicule]);
            } catch (Exception $e) {
                
            } finally {
                unset($stmt);
                return $succes;
            }
        }

        static function getById($pdo, $id) {
            try {
                $sql = "SELECT * FROM vehicules WHERE id_vehicule = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Vehicule');
                return $stmt->fetch();
            } catch (Exception $e) {
                return null;
            }
        }

        static function allVehicules($pdo) {
            try {
                $sql = "SELECT * FROM vehicules";
                $stmt = $pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehicule');
            } catch (Exception $e) {
                return [];
            }
        }

        static function vehiculesByCategorie($pdo, $id_categorie) {
            try{
                $sql = "SELECT * FROM vehicules WHERE categorie_id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id_categorie]);
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehicule');
            }catch(Exception $e){
                return [];
            }
        }

        static function countVehicules($pdo) {
            try {
                $sql = "SELECT COUNT(*) as total FROM vehicules";
                $stmt = $pdo->query($sql);
                $count = $stmt->fetch();
                
                return $count['total'];
            } catch(Exception $e) {
                return 0;
            }
        }

        static function paginatedVehicules($pdo, $limit, $offset){
            try {
                $sql = "SELECT * FROM vehicules LIMIT ? OFFSET ?";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$limit, $offset]);
                
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Vehicule');
            } catch (Exception $e) {
                return [];
            }
        }
    }
?>