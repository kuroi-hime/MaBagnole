<?php
    class Categorie{
        private $id_categorie;
        private $nom_categorie;
        private $description;

        public function __get($proprety){
            return (in_array($proprety, ['id_categorie', 'nom_categorie', 'description']))?$this->$proprety:throw new Exception($proprety.' est une propriété invalide.');
        }

        public function __setNom($value){
            if($value){
                $regex = "/^[a-z]+(\s[a-z])*$/";
                $value = htmlspecialchars(trim(value));
                if(!preg_match($regex, $value))
                    throw new Exception('Nom de catégorie invalid.');
            }
            $this->nom_categorie = htmlspecialchars_decode($value);
        }

        public function __setDescription($value){
            if($value){
                $value = htmlspecialchars(trim($value));
            }

            $this->description = htmlspecialchars_decode($value);
        }

        public function __toString(){
            return ($this->id_categorie?$this->id_categorie:'Inconnu.').' '.
                   ($this->nom_categorie?$this->nom_categorie:'Non déféni.').' '.
                   ($this->description?$this->description:'Non fournie.');
        }

        static function ajouter($pdo, $nom_categorie, $description){
            $succes = false;
            try{
                $sql = "INSERT INTO categories(nom_categorie, description) VALUES(?, ?)";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([$nom_categorie, $description]);
                // if(!$succes)
                //     throw new Exception();
            }catch(Exception $e){
                // echo "L'insertion a échoué.";
            }finally{
                unset($stmt);
            }
            
            return $succes;
        }

        public function modifier($pdo){
            $succes = false;
            try{
                $sql = "UPDATE categories
                        SET nom_categorie = ?, description = ?
                        WHERE id_categorie = ?";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([$this->id_categorie, $this->nom_categorie, $this->description]);
            }catch(Exception $e){
                // à venir;
            }finally{
                unset($stmt);
            }
            
            return $succes;
        }

        public function supprimer($pdo){
            $succes = false;
            try{
                $sql = "DELETE FROM categories
                        WHERE id_categorie = ?";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([$this->id_categorie]);
            }catch(Exception $e){
                // à venir;
            }finally{
                unset($stmt);
            }
            
            return $succes;
        }

        static function getById($pdo, $id){
            $succes = false;
            try{
                $sql = "SELECT * FROM categories WHERE id_categorie = ?";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute([$id]);
                if($succes){
                    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Categorie');
                    $categorie = $stmt->fetch();
                }
            }catch(Exception $e){
                // à venir;
            }finally{
                unset($stmt);
            }
            
            return $succes?$categorie:null;
        }

        static function allCategories($pdo){
            $succes = false;
            try{
                $sql = "SELECT * FROM categories";
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute();
                if($succes)
                    $categories = $stmt->fetchAll(PDO::FETCH_CLASS, 'Categorie');
            }catch(Exception $e){
                // à venir;
            }finally{
                unset($stmt);
            }
            
            return $succes?$categories:[];
        }

        static function insertionEnMasse($pdo, $categories){
            $succes = false;
            try{
                $colonnes = [];
                $values = [];
                foreach($categories as $categorie){
                    $colonnes[] = "(?, ?)";
                    $values[] = $categorie->nom_categorie;
                    $values[] = $categorie->description;
                }
                $sql = "INSERT INTO categories VALUES".implode(",", $colonnes);
                $stmt = $pdo->prepare($sql);
                $succes = $stmt->execute($values);
            }catch(Exception $e){

            }finally{
                unset($stmt);
            }
            
            return $succes;
        }
    }
?>