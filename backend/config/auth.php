<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

/**
 * Script d’authentification utilisateur.
 *
 * Traite le formulaire de connexion :
 * - vérifie l’email et le mot de passe
 * - crée la session utilisateur
 * - redirige vers la page d’accueil en cas de succès
 */

session_start();

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: /home");
        exit;
    } else {
        echo "Email ou mot de passe incorrect";
    }
}
