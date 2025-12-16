<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

/**
 * Controller de la page d’accueil publique.
 *
 * Affiche la liste des trajets disponibles pour les visiteurs
 * et les utilisateurs non connectés.
 */

/**
 * Récupère tous les trajets disponibles.
 *
 * @param PDO $pdo Connexion à la base de données
 * @return array Liste des trajets disponibles
 */
function getAvailableTrips(PDO $pdo): array
{
    $stmt = $pdo->prepare("
        SELECT t.*, 
               u.nom AS user_nom, 
               u.prenom AS user_prenom, 
               u.email AS user_email, 
               u.telephone AS user_telephone,
               a1.nom AS depart_nom, 
               a2.nom AS arrivee_nom
        FROM trajets t
        INNER JOIN users u ON t.user_id = u.id
        INNER JOIN agences a1 ON t.depart_id = a1.id
        INNER JOIN agences a2 ON t.arrivee_id = a2.id
        WHERE t.date_depart >= NOW()
          AND t.places_disponibles > 0
        ORDER BY t.date_depart ASC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des trajets
$trips = getAvailableTrips($pdo);

// Chargement de la vue
require __DIR__ . '/../public/views/home.php';
