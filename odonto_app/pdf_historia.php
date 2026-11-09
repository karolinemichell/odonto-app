<?php
session_start();
require_once 'config/db.php';

$paciente_id = $_GET['id'] ?? 0;

// Obtener Paciente
$stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt->execute([$paciente_id]);
$paciente = $stmt->fetch();

if (!$paciente) { 
    die("<h3 style='text-align:center; margin-top:50px; font-family:sans-serif;'>Paciente no encontrado o ID inválido.</h3>"); 
}

// Obtener Historia Clínica del paciente
$stmtH = $pdo->prepare("
    SELECT h.*, p.nombre AS procedimiento, p.costo 
    FROM historias_clinicas h
    JOIN procedimientos p ON h.procedimiento_id = p.id
    WHERE h.paciente_id = ?
    ORDER BY h.id DESC
");
$stmtH->execute([$paciente_id]);
$historias = $stmtH->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia Clínica - <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff; font-size: 14px; padding: 30px; }
        .header-print { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print mb-4 text-right">
        <button onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir / Guardar como PDF</button>
        <a href="dashboard.php" class="btn btn-secondary">Volver al Panel</a>
    </div>

    <div class="header-print d-flex justify-content-between align-items-center">
        <div>
            <h3 class="text-primary m-0 font-weight-bold">Odonto App</h3>
            <small class="text-muted">Sistema de Gestión Odontológica</small>
        </div>
        <div class="text-right">
            <strong>Historia Clínica N°:</strong> HC-<?= str_pad($paciente['id'], 5, '0', STR_PAD_LEFT) ?><br>
            <strong>Fecha de Emisión:</strong> <?= date('d/m/Y') ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light"><strong>Datos Personales del Paciente</strong></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2"><strong>Nombre Completo:</strong> <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></div>
                <div class="col-md-6 mb-2"><strong>Cédula / Documento:</strong> <?= htmlspecialchars($paciente['cedula']) ?></div>
                <div class="col-md-6 mb-2"><strong>Fecha de Nacimiento:</strong> <?= $paciente['fecha_nacimiento'] ?></div>
                <div class="col-md-6 mb-2"><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono'] ?: 'N/A') ?></div>
                <div class="col-md-6 mb-2"><strong>Correo Electrónico:</strong> <?= htmlspecialchars($paciente['email'] ?: 'N/A') ?></div>
                <div class="col-md-6 mb-2"><strong>Dirección:</strong> <?= htmlspecialchars($paciente['direccion'] ?: 'N/A') ?></div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Registro de Procedimientos y Evolución</h5>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Fecha y Hora</th>
                <th>Procedimiento</th>
                <th>Diente / Zona</th>
                <th>Observaciones / Diagnóstico</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($historias) > 0): ?>
                <?php foreach ($historias as $h): ?>
                    <tr>
                        <td><?= htmlspecialchars($h['fecha_atencion']) ?></td>
                        <td><strong><?= htmlspecialchars($h['procedimiento']) ?></strong></td>
                        <td><?= htmlspecialchars($h['diente_zona'] ?: 'N/A') ?></td>
                        <td><?= nl2br(htmlspecialchars($h['observaciones'])) ?></td>
                        <td>$<?= number_format($h['costo'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay procedimientos registrados en la historia de este paciente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-5 pt-5 text-center">
        <div class="d-inline-block border-top border-dark px-5 pt-2">
            <strong>Firma y Sello del Odontólogo</strong>
        </div>
    </div>
</body>
</html>