<?php
declare(strict_types=1);

/**
 * Tests unitaires du modèle User.
 *
 * Vérifie le bon fonctionnement de la méthode findByEmail()
 * à l’aide de mocks PDO.
 */


use PHPUnit\Framework\TestCase;


final class UserTest extends TestCase
{
public function testFindByEmailReturnsArray(): void
{
// On mocke PDO + statement
$mockStmt = $this->createMock(PDOStatement::class);
$mockStmt->method('execute')->willReturn(true);
$mockStmt->method('fetch')->willReturn(['id' => 1, 'email' => 'a@b.com', 'password' => password_hash('secret', PASSWORD_DEFAULT)]);


$mockPdo = $this->createMock(PDO::class);
$mockPdo->method('prepare')->willReturn($mockStmt);


$userModel = new User($mockPdo);
$result = $userModel->findByEmail('a@b.com');


$this->assertIsArray($result);
$this->assertSame('a@b.com', $result['email']);
}
}