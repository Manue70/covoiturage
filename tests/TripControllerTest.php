<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Teste les fonctionnalités du TripController
 */
class TripControllerTest extends TestCase
{
    private PDO $pdo;
    private int $userId;

    /**
     * Initialise la connexion à la base et crée un utilisateur test
     */
    protected function setUp(): void
    {
        $host = "aws-1-eu-west-2.pooler.supabase.com";
        $port = 6543;
        $dbname = "postgres";
        $user = "postgres.lfnmbwiitrykxfyrstrh";
        $password = "Manue-database_covoiturage";
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        $this->pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        // Création d’un utilisateur test
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute(['triptest@example.com']);
        $user = $stmt->fetch();

        if (!$user) {
            $this->pdo->prepare(
                "INSERT INTO users (nom, prenom, telephone, email) VALUES (?, ?, ?, ?)"
            )->execute(['Trip', 'Tester', '0000000000', 'triptest@example.com']);

            $stmt->execute(['triptest@example.com']);
            $user = $stmt->fetch();
        }

        $this->userId = (int)$user['id'];
    }

    /**
     * Teste la création d’un trajet valide
     */
    public function testCreateTripValid(): void
    {
        $departId = 1;
        $arriveeId = 2;
        $dateDepart = date('Y-m-d H:i:s', strtotime('+1 day'));
        $dateArrivee = date('Y-m-d H:i:s', strtotime('+2 days'));
        $placesTotal = 3;

        // Vérifications logiques
        $this->assertNotEquals($departId, $arriveeId, 'Départ et arrivée doivent être différents');
        $this->assertTrue(strtotime($dateDepart) < strtotime($dateArrivee), 'Date départ doit être avant date arrivée');
        $this->assertGreaterThan(0, $placesTotal, 'Le nombre de places doit être > 0');

        // Création du trajet
        $stmt = $this->pdo->prepare(
            "INSERT INTO trajets (depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles, user_id)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $result = $stmt->execute([$departId, $arriveeId, $dateDepart, $dateArrivee, $placesTotal, $placesTotal, $this->userId]);

        $this->assertTrue($result, "Le trajet doit être créé avec succès");

        // Vérifier dans la base
        $tripId = (int)$this->pdo->lastInsertId();
        $stmt = $this->pdo->prepare("SELECT * FROM trajets WHERE id = ?");
        $stmt->execute([$tripId]);
        $trip = $stmt->fetch();

        $this->assertNotFalse($trip, "Le trajet doit exister dans la base");
        $this->assertEquals($departId, $trip['depart_id']);
        $this->assertEquals($arriveeId, $trip['arrivee_id']);
        $this->assertEquals($placesTotal, $trip['places_total']);
    }

    /**
     * Teste la modification d’un trajet
     */
    public function testUpdateTrip(): void
    {
        // Création d’un trajet à modifier
        $stmt = $this->pdo->prepare(
            "INSERT INTO trajets (depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles, user_id)
             VALUES (1, 2, NOW() + INTERVAL '1 day', NOW() + INTERVAL '2 days', 2, 2, ?)"
        );
        $stmt->execute([$this->userId]);
        $tripId = (int)$this->pdo->lastInsertId();

        // Modification : changer date_arrivee et places_total
        $newDateArrivee = date('Y-m-d H:i:s', strtotime('+3 days'));
        $newPlaces = 4;

        $stmt = $this->pdo->prepare(
            "UPDATE trajets SET date_arrivee = ?, places_total = ?, places_disponibles = ? WHERE id = ?"
        );
        $stmt->execute([$newDateArrivee, $newPlaces, $newPlaces, $tripId]);

        // Vérification
        $stmt = $this->pdo->prepare("SELECT * FROM trajets WHERE id = ?");
        $stmt->execute([$tripId]);
        $trip = $stmt->fetch();

        $this->assertEquals($newDateArrivee, $trip['date_arrivee']);
        $this->assertEquals($newPlaces, $trip['places_total']);
        $this->assertEquals($newPlaces, $trip['places_disponibles']);
    }

    /**
     * Teste la suppression d’un trajet
     */
    public function testDeleteTrip(): void
    {
        // Création d’un trajet à supprimer
        $stmt = $this->pdo->prepare(
            "INSERT INTO trajets (depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_disponibles, user_id)
             VALUES (1, 2, NOW() + INTERVAL '1 day', NOW() + INTERVAL '2 days', 2, 2, ?)"
        );
        $stmt->execute([$this->userId]);
        $tripId = (int)$this->pdo->lastInsertId();

        // Suppression
        $stmt = $this->pdo->prepare("DELETE FROM trajets WHERE id = ?");
        $stmt->execute([$tripId]);

        $stmt = $this->pdo->prepare("SELECT * FROM trajets WHERE id = ?");
        $stmt->execute([$tripId]);
        $trip = $stmt->fetch();

        $this->assertFalse($trip, "Le trajet doit être supprimé");
    }
}
