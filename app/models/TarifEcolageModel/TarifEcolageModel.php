<?php
            namespace app\models\TarifEcolageModel;

            use Flight;
            use PDO;

            class TarifEcolageModel {
                public function insert($montant, $adult) {
                    try {
                        $db = Flight::db();
                        $stmt = $db->prepare("INSERT INTO tarif_ecolage (montant, adult) VALUES (:montant, :adult)");
                        $stmt->execute([':montant' => $montant, ':adult' => $adult]);
                        return "Insertion réussie !";
                    } catch (\PDOException $e) {
                        return "Erreur : " . $e->getMessage();
                    }
                }

                public function getCurrentTarifAdulte() {
                    try {
                        $db = Flight::db();
                        $stmt = $db->query("SELECT * FROM tarif_ecolage WHERE adult = true ORDER BY id_tarif DESC LIMIT 1");
                        return ($stmt && ($result = $stmt->fetch(PDO::FETCH_ASSOC))) ? $result : null;
                    } catch (\PDOException $e) {
                        return null;
                    }
                }

                public function getCurrentTarifEnfant() {
                    try {
                        $db = Flight::db();
                        $stmt = $db->query("SELECT * FROM tarif_ecolage WHERE adult = false ORDER BY id_tarif DESC LIMIT 1");
                        return ($stmt && ($result = $stmt->fetch(PDO::FETCH_ASSOC))) ? $result : null;
                    } catch (\PDOException $e) {
                        return null;
                    }
                }
            }
            ?>