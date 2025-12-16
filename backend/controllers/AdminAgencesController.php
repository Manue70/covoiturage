<?php
declare(strict_types=1);

namespace App\Controllers;

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de gestion des agences (ADMIN).
 *
 * Permet :
 * - l’affichage de la liste des agences
 * - la modification du nom d’une agence
 *
 * Accès réservé aux utilisateurs ayant le rôle "admin".
 */

// Vérification du rôle administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Accès interdit');
}

/**
 * Traitement de la modification d’une agence.
 *
 * Déclenché via un formulaire POST.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['nom'])) {
    $stmt = $pdo->prepare(
        "UPDATE agences SET nom = :nom WHERE id = :id"
    );
    $stmt->execute([
        'nom' => $_POST['nom'],
        'id'  => (int)$_POST['id']
    ]);

    header('Location: /admin/agences');
    exit;
}

/**
 * Récupération de toutes les agences.
 */
$stmt = $pdo->query("SELECT * FROM agences ORDER BY id ASC");
$agences = $stmt->fetchAll(\PDO::FETCH_ASSOC);

/**
 * Récupération d’une agence à modifier (mode édition).
 */
$agenceToEdit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM agences WHERE id = :id");
    $stmt->execute(['id' => (int)$_GET['edit_id']]);
    $agenceToEdit = $stmt->fetch(\PDO::FETCH_ASSOC);
}

// Inclusion de la vue
require __DIR__ . '/../public/views/admin_agences.php';
