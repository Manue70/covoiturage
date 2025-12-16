<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de l’espace utilisateur connecté.
 *
 * Permet :
 * - la création de trajets
 * - la modification de trajets
 * - la suppression de trajets
 * - l’affichage de tous les trajets
 *
 * Accès réservé aux utilisateurs ayant le rôle "user".
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification utilisateur connecté
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: /login');
    exit;
}

/**
 * Création d’un trajet.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_trip'])) {
    $stmt = $pdo->prepare("
        INSERT INTO trajets 
        (user_id, depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user']['id'],
        (int)$_POST['depart_id'],
        (int)$_POST['arrivee_id'],
        $_POST['date_depart'],
        $_POST['date_arrivee'],
        (int)$_POST['places_total'],
        (int)$_POST['places_total']
    ]);

    header('Location: /home');
    exit;
}

/**
 * Modification d’un trajet appartenant à l’utilisateur.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_trip'])) {
    $stmt = $pdo->prepare("
        UPDATE trajets
        SET depart_id = ?, arrivee_id = ?, date_depart = ?, date_arrivee = ?, places_total = ?
        WHERE id = ? AND user_id = ?
    ");

    $stmt->execute([
        (int)$_POST['depart_id'],
        (int)$_POST['arrivee_id'],
        $_POST['date_depart'],
        $_POST['date_arrivee'],
        (int)$_POST['places_total'],
        (int)$_POST['trip_id'],
        $_SESSION['user']['id']
    ]);

    header('Location: /home');
    exit;
}

/**
 * Suppression d’un trajet.
 */
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM trajets WHERE id = ? AND user_id = ?");
    $stmt->execute([
        (int)$_GET['delete_id'],
        $_SESSION['user']['id']
    ]);

    header('Location: /home');
    exit;
}

/**
 * Récupération de tous les trajets.
 */
$stmt = $pdo->query("
    SELECT t.*, 
           d.nom AS depart_nom, 
           a.nom AS arrivee_nom,
           u.prenom, u.nom, u.email, u.telephone
    FROM trajets t
    JOIN agences d ON d.id = t.depart_id
    JOIN agences a ON a.id = t.arrivee_id
    JOIN users u ON u.id = t.user_id
    ORDER BY t.date_depart ASC
");
$trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**
 * Mode édition d’un trajet.
 */
$editing = false;
$trip_data = [
    'id' => '',
    'depart_id' => '',
    'arrivee_id' => '',
    'date_depart' => '',
    'date_arrivee' => '',
    'places_total' => ''
];

if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM trajets WHERE id = ? AND user_id = ?");
    $stmt->execute([(int)$_GET['edit_id'], $_SESSION['user']['id']]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        $trip_data = $data;
        $editing = true;
    }
}

require __DIR__ . '/../public/views/home_user.php';

