<?php
session_start();
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action === 'guardar') {
    $paciente_id = $_POST['paciente_id'] ?? 0;
    $procedimiento_id = $_POST['procedimiento_id'] ?? 0;
    $diente_zona = trim($_POST['diente_zona'] ?? '');
    $observaciones = trim($_POST['observaciones'] ?? '');

    if (empty($paciente_id) || empty($procedimiento_id) || empty($observaciones)) {
        echo json_encode(['status' => 'error', 'message' => 'Complete todos los campos obligatorios.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO historias_clinicas (paciente_id, procedimiento_id, diente_zona, observaciones) VALUES (?, ?, ?, ?)");
        $stmt->execute([$paciente_id, $procedimiento_id, $diente_zona, $observaciones]);
        echo json_encode(['status' => 'success', 'message' => 'Atención registrada con éxito.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar en la base de datos: ' . $e->getMessage()]);
    }
    exit;
}

if ($action === 'obtener') {
    $paciente_id = $_GET['paciente_id'] ?? 0;
    try {
        $stmt = $pdo->prepare("
            SELECT h.*, p.nombre AS procedimiento, p.costo 
            FROM historias_clinicas h
            JOIN procedimientos p ON h.procedimiento_id = p.id
            WHERE h.paciente_id = ?
            ORDER BY h.id DESC
        ");
        $stmt->execute([$paciente_id]);
        echo json_encode($stmt->fetchAll());
    } catch (PDOException $e) {
        echo json_encode([]);
    }
    exit;
}
?>