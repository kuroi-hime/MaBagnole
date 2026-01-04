<?php
    // namespace APP\classes;
    require_once 'Utilisateur.php';

    class Client extends Utilisateur{
        protected $cin;
        protected $telephone;
        protected $adresse;
        protected $ville;
        protected $statut = 1;

        public function __get($proprety){
            if(in_array($proprety, ['cin', 'telephone', 'adresse', 'ville', 'statut']))
                return $this->$proprety;
        }

        public function setCIN($value){
            //1 ou 3 lettres (3 pour la nouvelle carte) suivies de 4 à 6 chiffres
            $regex = "/^[A-Z]{1,3}[0-9]{4,6}$/i";
            $value = trim($value);
            if(!preg_match($regex, $value))
                throw new Exception('Format de CIN invalide.');
            $this->cin = strtoupper($value);
        }

        public function setTelephone($value){
            $regex = "/^(\+212|0)([5-7])([0-9]{8})$/";
            $value = trim($value);
            if(!preg_match($regex, $value))
                throw new Exception('Format de numéro de téléphone invalide.');
            $this->telephone = $value;
        }

        public function setAdresse($value){
            // Lettres, chiffres, espaces et ponctuation de base (min 5 caractères)
            $regex = "/^[a-zA-Z0-9\s,.'-]{5,100}$/";
            $value = trim($value);
            if(!preg_match($regex, $value))
                throw new Exception('Adresse invalide ou trop courte');
            $this->adresse = $value;
        }

        public function setVille($value){
            // Uniquement des lettres et espaces (2 à 30 caractères)
            $regex = "/^[a-zA-Z\s-]{2,30}$/";
            $value = trim($value);
            if(!preg_match($regex, $value))
                throw new Exception('Nom de ville invalide');
            $this->ville = $value;
        }

        public function setStatut($value){
            if(!in_array($value, [0, 1, false, true]))
                throw new Exception('Statut invalide.');
            $this->statut = $value;
        }

        // public function __set($proprety, $value) {
        //     switch($proprety) {
        //         case 'cin':
                    
        //             break;

        //         case 'telephone':
                    
        //             break;

        //         case 'adresse':
                    
        //             break;

        //         case 'ville':
                    
        //             break;
        //     }
        // }

        public function __toString(){
            return parent::__toString().' '.
                    (($this->cin)?$this->cin:'Inconnue').' '.
                    (($this->telephone)?$this->telephone:'Inconnu').' '.
                    (($this->adresse)?$this->adresse:'Inconnu').' '.
                    (($this->ville)?$this->ville:'Inconnu');
        }

        static function inscription(PDO $pdo, $utilisateur){
            try{
                $sql = "INSERT INTO utilisateurs (nom_user, email, mot_passe_hash, cin, telephone, adresse, ville) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $utilisateur->nom_user); //1
                $stmt->bindParam(2, $utilisateur->email); //2
                $stmt->bindParam(3, $utilisateur->motpasse_hash); //3
                $stmt->bindParam(4, $utilisateur->cin); //4
                $stmt->bindParam(5, $utilisateur->telephone); //5
                $stmt->bindParam(6, $utilisateur->adresse); //6
                $stmt->bindParam(7, $utilisateur->ville); //7

                if(!$stmt->execute())
                    throw new Exception();

                unset($stmt);
            }catch(Exception){
                echo "L'insertion a échoué.";
            }
        }

        static function update($client, $pdo){ //Il y a une erreur? 
            try{
                $sql = "UPDATE utilisateurs 
                        SET nom_user = ?, email = ?, motpasse_hash = ?, cin = ?, telephone = ?, adresse = ?, ville = ?, statut = ?
                        WHERE id_user = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $client->nom_user);
                $stmt->bindParam(2, $client->email);
                $stmt->bindParam(3, $client->motpasse_hash);
                $stmt->bindParam(4, $client->cin);
                $stmt->bindParam(5, $client->telephone);
                $stmt->bindParam(6, $client->adresse);
                $stmt->bindParam(7, $client->ville);
                $stmt->bindParam(8, $client->statut);
                $stmt->bindParam(9, $client->id_user);

                $stmt->execute();
                unset($stmt);
            }catch(Exception $e){
                error_log("Erreur Update: " . $e->getMessage());
                echo "La mise à jour a échoué.";
            }
        }

        static function actifsClients($pdo) {
            try {
                $sql = "SELECT COUNT(*) as total FROM utilisateurs WHERE role='client' AND statut=1";
                $stmt = $pdo->query($sql);
                $count = $stmt->fetch();
                
                return $count['total'];
            } catch(Exception $e) {
                unset($stmt);
                return 0;
            }
        }

        static function allClients($pdo){
            try{
                $sql = "SELECT * FROM utilisateurs WHERE role='client'";
                $stmt = $pdo->query($sql);
                $stmt->execute();
                $clients = $stmt->fetchAll(PDO::FETCH_CLASS, 'Client');
                return $clients;
            }catch(Exception $e){
                unset($stmt);
                return [];
            }
        }

        static function getById($id, $pdo){
            try{
                $sql = "SELECT * FROM utilisateurs WHERE id_user = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $id);

                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Client');
                $client = $stmt->fetch();

                unset($stmt);
            }catch(Exception){
                echo "Client introuvable.";
            }
            return $client?$client:null;
        }
    }
?>