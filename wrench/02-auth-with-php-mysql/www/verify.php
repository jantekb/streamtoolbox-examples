<?php
declare(strict_types=1);

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/database.inc.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header('Location: login.php?error=missing');
    exit;
}

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare('SELECT username, password FROM wtb_user WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['username'] = $user['username'];
        $_SESSION['logged'] = true;

        error_log('Login successful: ' . $username);
        header('Location: video.php');
        exit;
    } else {
        header('Location: login.php?error=invalid');
        exit;
    }

} catch (PDOException $e) {
    error_log('DB Error: ' . $e->getMessage());
    header('Location: login.php?error=server');
    exit;
}