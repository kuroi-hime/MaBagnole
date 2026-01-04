<?php
    // namespace App\classes;

    class Utilisateur{
        protected $id_user;
        protected $nom_user;
        protected $role = 'client';
        protected $email;
        protected $mot_passe_hash;

        public function getId(){
            return $this->id_user;
        }

        public function getNom(){
            return $this->nom_user;
        }

        public function setNom($nom){
            if($nom){
                $nom = ucwords(htmlspecialchars(trim($nom)));
                $regex = "/^[a-zA-ZÀ-ÿ]+([\s\'\-][a-zA-ZÀ-ÿ]+)*$/i";
                if(!preg_match($regex, $nom))
                    throw new Exception('Syntaxe du nom éronnée.');
            }
            $this->nom_user = $nom;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            if($email){
                $email = htmlspecialchars(trim($email));
                if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                    throw new Exception('Email incorrect.');
            }
            $this->email = $email;
        }

        public function getRole(){
            return $this->role;
        }

        public function setRole($role){
            if($role){
                if($role != 'client')
                    throw new Exception('Rôle interdit.');
            }
            $this->role = $role;
        }

        static function getByEmail($pdo, $email){
            $sql = "SELECT *
                    FROM utilisateurs
                    WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
            $utilisateur = $stmt->fetch();
            unset($stmt);

            return ($utilisateur == false) ? null:$utilisateur;
        }

        public function verifierMotDePasse($password){
            $password = trim($password);
            if($password){
                if($this->mot_passe_hash == md5($password))
                    return true;
            }
            return false;
        }

        public function setMotDePassHash($password){
            $password = trim($password);
            if($password)
                $this->motpasse_hash = md5($password);
        }

        public function __toString(){
            return  (($this->id_user)?$this->id_user:'Inconnu').' '.
                    (($this->nom_user)?$this->nom_user:'Inconnu').' '.
                    (($this->email)?$this->email:'Inconnu').' '.
                    (($this->role)?$this->role:'Inconnu');
        }

        // public function connexion($pdo){
        //     $utilisateur = $this->getByEmail($pdo);
        //     if($utilisateur){
        //         if(!$this->verifierMotDePasse($utilisateur->motpasse_hash))
        //             throw new Exception('Mot de passe incorrect.');

        //         return $utilisateur;
        //     }
        //     else
        //         throw new Exception('utilisateur introuvable.');
        // }

        static function connexion($pdo, $email, $password){
            $utilisateur = self::getByEmail($pdo, $email);
            
            if($utilisateur){
                if(!$utilisateur->verifierMotDePasse($password)) {
                    throw new Exception('Mot de passe incorrect.');
                }
                return $utilisateur;
            } else {
                throw new Exception('Utilisateur introuvable.');
            }
        }

        static function getById($id, $pdo){
            try{
                $sql = "SELECT * FROM utilisateurs WHERE id_user = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(1, $id);

                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
                $utilisateur = $stmt->fetch();

                unset($stmt);
            }catch(Exception){
                echo "Utilisateur introuvable.";
            }
            return $utilisateur?$utilisateur:null;
        }
    }
?>