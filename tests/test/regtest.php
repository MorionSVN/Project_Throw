<?php

use PHPUnit\Framework\TestCase;

class RegTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        $dsn = 'mysql:host=localhost;dbname=reverendo_throw;charset=utf8';
        $username = 'reverendo_throw';
        $password = 'Synyster7';

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            $this->markTestSkipped('Не удалось подключиться к базе данных: ' . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        if ($this->db) {
            $stmt = $this->db->prepare("DELETE FROM USERS WHERE Mail LIKE 'test@example.com%'");
            $stmt->execute();
            $this->db = null;
        }
    }

    public function testSuccessfulRegistration()
    {
        if (!$this->db) {
            $this->markTestSkipped('Database connection not established.');
        }

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['Mail'] = 'test@example.com';
        $_POST['Password'] = 'password123';

        ob_start();
        include '../reg.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        $stmt = $this->db->prepare("SELECT * FROM USERS WHERE Mail = :mail");
        $stmt->execute(['mail' => 'test@example.com']);
        $this->assertEquals(1, $stmt->rowCount());
    }

    public function testRegistrationError()
    {
        if (!$this->db) {
            $this->markTestSkipped('Database connection not established.');
        }

        $stmt = $this->db->prepare("INSERT INTO USERS (Mail, Password) VALUES (:mail, :password)");
        $stmt->execute(['mail' => 'test@example.com', 'password' => password_hash('password123', PASSWORD_BCRYPT)]);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['Mail'] = 'test@example.com';
        $_POST['Password'] = 'password123';

        ob_start();
        include '../reg.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);
        $this->assertArrayHasKey('error', $response);
        $this->assertStringContainsString('Ошибка:', $response['error']);
    }

    public function testConnectionError()
    {
        $dsn = 'mysql:host=localhost;dbname=wrong_database;charset=utf8';
        $username = 'wrong_user';
        $password = 'wrong_password';

        try {
            $wrongDb = new PDO($dsn, $username, $password);
            $wrongDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->fail('Соединение с неверными учетными данными не должно быть успешным');
        } catch (PDOException $e) {
            $_SERVER['REQUEST_METHOD'] = 'POST';
            $_POST['Mail'] = 'test@example.com';
            $_POST['Password'] = 'password123';

            ob_start();
            include '../reg.php';
            $output = ob_get_clean();

            $response = json_decode($output, true);
            $this->assertArrayHasKey('error', $response);
            $this->assertStringContainsString('Ошибка соединения', $response['error']);
        }
    }
}