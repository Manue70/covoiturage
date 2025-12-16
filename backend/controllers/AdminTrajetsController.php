<?php
declare(strict_types=1);

namespace App\Controllers;

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de gestion des trajets (ADMIN).
 *
 * Permet :
 * - la consultation de tous les trajets
 * - la modification d’un trajet
 * - la suppression d’un trajet
 *
 * Accès réservé aux administrateurs.
 */

// Vérification rôle admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Accès interdit');
}

/**
 * Modification d’un trajet.
 *
 * Déclenchée via un formulaire POST.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_trajet'])) {
    $stmt = $pdo->prepare("
        UPDATE trajets
        SET depart_id = :depart_id,
            arrivee_id = :arrivee_id,
            date_depart = :date_depart,
            date_arrivee = :date_arrivee,
            places_total = :places_total,
            places_disponibles = :places_disponibles
        WHERE id = :id
    ");

    $stmt->execute([
        'depart_id' => (int)$_POST['depart_id'],
        'arrivee_id' => (int)$_POST['arrivee_id'],
        'date_depart' => $_POST['date_depart'],
        'date_arrivee' => $_POST['date_arrivee'],
        'places_total' => (int)$_POST['places_total'],
        'places_disponibles' => (int)$_POST['places_disponibles'],
        'id' => (int)$_POST['trajet_id'],
    ]);

    header('Location: /admin/trajets');
    exit;
}

/**
 * Suppression d’un trajet.
 */
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM trajets WHERE id = ?");
    $stmt->execute([(int)$_GET['delete_id']]);

    header('Location: /admin/trajets');
    exit;
}

/**
 * Récupération de tous les trajets.
 */
$stmt = $pdo->query("
    SELECT t.*, 
           d.nom AS depart_nom, 
           a.nom AS arrivee_nom, 
           u.prenom, 
           u.nom AS user_nom
    FROM trajets t
    JOIN agences d ON t.depart_id = d.id
    JOIN agences a ON t.arrivee_id = a.id
    JOIN users u ON t.user_id = u.id
    ORDER BY t.date_depart DESC
");
$trajets = $stmt->fetchAll(\PDO::FETCH_ASSOC);

/**
 * Récupération d’un trajet à modifier (mode édition).
 */
$trajetToEdit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM trajets WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_id']]);
    $trajetToEdit = $stmt->fetch(\PDO::FETCH_ASSOC);
}

// Inclusion de la vue
require __DIR__ . '/../public/views/admin_trajets.php';
