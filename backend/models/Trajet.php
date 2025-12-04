<?php
require_once '../config/db.php';

class Trajet {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les trajets disponibles triés par date de départ
     * avec les informations de l'utilisateur qui propose le trajet.
     *
     * @return array
     */
    public function getAllAvailable() {
        $stmt = $this->pdo->prepare("
            SELECT t.id, t.date_depart, t.date_arrivee, t.places_total, t.places_disponibles,
                   a1.nom AS depart, a2.nom AS arrivee,
                   u.prenom, u.nom, u.telephone, u.email, t.user_id
            FROM trajets t
            JOIN agences a1 ON t.depart_id = a1.id
            JOIN agences a2 ON t.arrivee_id = a2.id
            JOIN users u ON t.user_id = u.id
            WHERE t.places_disponibles > 0
            ORDER BY t.date_depart ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet spécifique par son ID
     *
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("
            SELECT t.id, t.date_depart, t.date_arrivee, t.places_total, t.places_disponibles,
                   a1.nom AS depart, a2.nom AS arrivee,
                   u.prenom, u.nom, u.telephone, u.email, t.user_id
            FROM trajets t
            JOIN agences a1 ON t.depart_id = a1.id
            JOIN agences a2 ON t.arrivee_id = a2.id
            JOIN users u ON t.user_id = u.id
            WHERE t.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

