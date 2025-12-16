<?php
declare(strict_types=1);

/**
 * Fichier de configuration de la base de données.
 *
 * Ce fichier initialise la connexion PDO à la base PostgreSQL
 * utilisée par l’application de covoiturage.
 *
 * Il doit être inclus dans les contrôleurs et scripts nécessitant
 * un accès à la base de données.
 */

$host = "aws-1-eu-west-2.pooler.supabase.com";
$port = 6543;
$dbname = "postgres";
$user = "postgres.lfnmbwiitrykxfyrstrh";
$password = "Manue-database_covoiturage";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
