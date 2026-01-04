<?php
    class Admin {
        static function bloquerClient($pdo, $idClient){
            try{
                $sql = "UPDATE utilisateurs 
                        SET statut = 0
                        WHERE id_user = ?";

                $stmt = $pdo->prepare($sql);

                $succes = $stmt->execute([$idClient]);
            }catch(Exception $e){
                echo "La mise à jour a échoué.";
            }
        }

        static function debloquerClient($pdo, $idClient){
            try{
                $sql = "UPDATE utilisateurs 
                        SET statut = 1
                        WHERE id_user = ?";

                $stmt = $pdo->prepare($sql);

                $succes = $stmt->execute([$idClient]);
            }catch(Exception $e){
                echo "La mise à jour a échoué.";
            }
        }
    }
?>