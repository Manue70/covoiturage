<?php
declare(strict_types=1);

namespace App\Controllers;

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de gestion des utilisateurs (ADMIN).
 *
 * Permet :
 * - l’affichage des utilisateurs
 * - la modification d’un utilisateur
 * - la suppression d’un utilisateur
 */

// Sécurité : accès admin uniquement
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Accès interdit');
}

/**
 * Modification d’un utilisateur.
 */
if (isset($_POST['update_user'])) {
    $stmt = $pdo->prepare("
        UPDATE users
        SET nom = :nom,
            prenom = :prenom,
            telephone = :telephone,
            role = :role
        WHERE id = :id
    ");

    $stmt->execute([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'telephone' => $_POST['telephone'] ?? '',
        'role' => $_POST['role'],
        'id' => (int)$_POST['user_id']
    ]);

    header('Location: /admin/users');
    exit;
}

/**
 * Suppression d’un utilisateur.
 */
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => (int)$_GET['delete_id']]);

    header('Location: /admin/users');
    exit;
}

/**
 * Récupération d’un utilisateur à modifier.
 */
$userToEdit = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => (int)$_GET['edit_id']]);
    $userToEdit = $stmt->fetch(\PDO::FETCH_ASSOC);
}

/**
 * Récupération de tous les utilisateurs.
 */
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

// Inclusion de la vue
require __DIR__ . '/../public/views/admin_users.php';
