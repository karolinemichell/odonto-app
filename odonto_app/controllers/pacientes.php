<?php
session_start();
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action === 'listar') {
    try {
        $stmt = $pdo->query("SELECT * FROM pacientes ORDER BY id DESC");
        echo json_encode($stmt->fetchAll());
    } catch (PDOException $e) {
        echo json_encode([]);
    }
    exit;
}

if ($action === 'guardar') {
    $cedula = trim($_POST['cedula'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento)) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor complete los campos obligatorios.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO pacientes (cedula, nombre, apellido, fecha_nacimiento, telefono, email, direccion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$cedula, $nombre, $apellido, $fecha_nacimiento, $telefono, $email, $direccion]);
        echo json_encode(['status' => 'success', 'message' => 'Paciente registrado con éxito']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: La cédula ya está registrada o hubo un fallo en la base de datos.']);
    }
    exit;
}
?>