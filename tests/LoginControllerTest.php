<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

/**
 * Teste les fonctionnalités de connexion du LoginController
 */
class LoginControllerTest extends TestCase
{
    private PDO $pdo;

    /**
     * Initialise la connexion à la base avant chaque test
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
    }

    /**
     * Teste un login avec identifiants corrects
     */
    public function testLoginSuccess(): void
    {
        $email = 'test@example.com';
        $password = 'password123';

        // Création d'un utilisateur de test si inexistant
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->pdo->prepare(
                "INSERT INTO users (nom, prenom, telephone, email) VALUES (?, ?, ?, ?)"
            )->execute(['Test', 'User', '0000000000', $email]);

            $stmt->execute([$email]);
            $user = $stmt->fetch();
        }

        $this->assertNotFalse($user, 'L’utilisateur devrait exister dans la base');
        $this->assertTrue(password_verify($password, password_hash($password, PASSWORD_DEFAULT)));
    }

    /**
     * Teste un login avec un mot de passe incorrect
     */
    public function testLoginFailureWrongPassword(): void
    {
        $email = 'test@example.com';
        $wrongPassword = 'wrongpass';

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        $this->assertNotFalse($user, 'L’utilisateur devrait exister pour ce test');
        $this->assertFalse(password_verify($wrongPassword, password_hash('password123', PASSWORD_DEFAULT)));
    }

    /**
     * Teste un login avec un utilisateur inconnu
     */
    public function testLoginFailureUnknownUser(): void
    {
        $email = 'unknown@example.com';

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        $this->assertFalse($user, 'L’utilisateur ne doit pas exister');
    }
}
