<?php
session_start();
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action === 'listar') {
    try {
        $stmt = $pdo->query("SELECT * FROM procedimientos ORDER BY nombre ASC");
        echo json_encode($stmt->fetchAll());
    } catch (PDOException $e) {
        echo json_encode([]);
    }
    exit;
}

if ($action === 'guardar') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $costo = $_POST['costo'] ?? 0;

    if (empty($nombre) || empty($costo)) {
        echo json_encode(['status' => 'error', 'message' => 'Complete los campos requeridos.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO procedimientos (nombre, descripcion, costo) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $costo]);
        echo json_encode(['status' => 'success', 'message' => 'Procedimiento agregado con éxito']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar el procedimiento.']);
    }
    exit;
}
?>