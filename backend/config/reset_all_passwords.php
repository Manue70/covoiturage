<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

/**
 * Script d’administration.
 *
 * Permet de réinitialiser tous les mots de passe utilisateurs
 * en générant un mot de passe sécurisé pour chaque compte.
 *
 * ⚠️ Script à usage interne uniquement.
 */

/**
 * Génère un mot de passe aléatoire sécurisé.
 *
 * @param int $length Longueur du mot de passe
 * @return string Mot de passe généré
 */
function generatePassword(int $length = 12): string
{
    return substr(
        str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_'),
        0,
        $length
    );
}

try {
    $stmt = $pdo->query('SELECT id, email FROM users');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $newPassword = generatePassword();
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);

        $update = $pdo->prepare(
            'UPDATE users SET password = :password WHERE id = :id'
        );
        $update->execute([
            'password' => $hashed,
            'id' => $user['id']
        ]);

        echo "Email : {$user['email']} | Nouveau mot de passe : {$newPassword}\n";
    }

    echo "\nTous les mots de passe ont été réinitialisés avec succès.\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
