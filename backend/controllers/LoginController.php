<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de connexion utilisateur.
 *
 * Gère :
 * - l’authentification par email / mot de passe
 * - la création de la session utilisateur
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Authentifie un utilisateur.
 *
 * @param PDO    $pdo
 * @param string $email
 * @param string $password
 * @return bool
 */
function login(PDO $pdo, string $email, string $password): bool
{
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || empty($user['password'])) {
        return false;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }

    return false;
}

/**
 * Traitement du formulaire de connexion.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (login($pdo, $email, $password)) {
        header('Location: /home');
        exit;
    }

    header('Location: /login?error=Email ou mot de passe incorrect');
    exit;
}

