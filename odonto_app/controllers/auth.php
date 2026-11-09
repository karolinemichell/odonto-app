<?php
session_start();
require_once '../config/db.php';

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor complete todos los campos.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verificación directa en texto plano para evitar bloqueos
    if ($user && $password === $user['password']) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Correo o contraseña incorrectos.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>