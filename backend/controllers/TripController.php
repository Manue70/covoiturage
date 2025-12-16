<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de gestion des trajets (USER).
 *
 * Permet :
 * - la création d’un trajet
 * - la modification d’un trajet
 * - la suppression d’un trajet
 *
 * Accès réservé aux utilisateurs connectés.
 */

// Vérification utilisateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    http_response_code(403);
    exit('Accès interdit');
}

$user_id = (int)$_SESSION['user']['id'];

/**
 * Création ou modification d’un trajet.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'] ?? null;

    try {
        if ($trip_id) {
            // Modification
            $stmt = $pdo->prepare("
                UPDATE trajets 
                SET depart_id=?, arrivee_id=?, date_depart=?, date_arrivee=?, places_total=?
                WHERE id=? AND user_id=?
            ");
            $stmt->execute([
                $_POST['depart_id'],
                $_POST['arrivee_id'],
                $_POST['date_depart'],
                $_POST['date_arrivee'],
                $_POST['places_total'],
                $trip_id,
                $user_id
            ]);
        } else {
            // Création
            $stmt = $pdo->prepare("
                INSERT INTO trajets (user_id, depart_id, arrivee_id, date_depart, date_arrivee, places_total)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id,
                $_POST['depart_id'],
                $_POST['arrivee_id'],
                $_POST['date_depart'],
                $_POST['date_arrivee'],
                $_POST['places_total']
            ]);
        }
    } catch (\PDOException $e) {
        die('Erreur BDD : ' . $e->getMessage());
    }

    header('Location: /home');
    exit;
}

/**
 * Suppression d’un trajet.
 */
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM trajets WHERE id=? AND user_id=?");
    $stmt->execute([(int)$_GET['delete'], $user_id]);

    header('Location: /home');
    exit;
}

// Inclusion de la vue
require __DIR__ . '/../public/views/trip_modal.php';
