<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odonto App - Panel Principal</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
       
    <style>

        html, body {
            height: 100%;
        }
        
        /* 1. Fondo general del lado derecho (Azul clarito / celeste) */
        body, main.col-md-9 {
            background-color: #c5e1f5 !important; /* Azul clarito muy suave y profesional */
        }

        .sidebar, .bg-dark, nav.col-md-2 {
            background-color: #91c293 !important;
            min-height: 100vh !important;
        }

        /* Título "Odonto App" del menú */
        .sidebar .brand-text, .sidebar h3, .sidebar .navbar-brand, .sidebar .text-white {
            color: #000000 !important;
            font-size: 5.5rem !important;
            font-weight: bold !important;
        }

        /* Letras del rol de usuario */
        .sidebar small, .sidebar .text-muted, .sidebar span.text-muted {
            color: #000000 !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
        }

        /* Enlaces del menú */
        .sidebar a, .sidebar .nav-link, .sidebar span, .sidebar p, .sidebar h4 {
            color: #000000 !important;
            font-size: 1.15rem !important;
            font-weight: bold !important;
        }

        /* Efecto al pasar el mouse por los enlaces (Celeste suave) */
        .sidebar a:hover, .sidebar .nav-link:hover {
            color: #000000 !important;
            background-color: #b3e5fc !important; /* Celeste suave y elegante */
            border-radius: 5px;
        }

        /* Logo pequeño y ordenado */
        nav.sidebar .text-center img, 
        .sidebar-logo {
            width: 100px !important;
            height: 100px !important;
            min-width: 100px !important;
            min-height: 100px !important;
            max-width: 100px !important;
            max-height: 100px !important;
            object-fit: contain !important;
            display: block !important;
            margin: 0 auto 5px auto !important;
        }
        
        /* Título Odonto App */
        .sidebar-title {
            color: #000000 !important;
            font-size: 5.5rem !important;
            font-weight: bold !important;
        }

        /* 2. Cambiar la cabecera de la tabla (Cédula, Nombre, etc.) a color verde y letras negras */
        .table thead.thead-light, .table thead.thead-light th {
            background-color: #77ad79 !important;
            color: #000000 !important;
            border-color: #0f3b11 !important;
        }
        /* 3. Cambiar los botones principales (Nuevo Paciente / Nuevo Procedimiento) a color verde con texto negro o blanco */
        .btn-primary, .btn-success {
            background-color: #77a379 !important;
            border-color: #7ab57d !important;
            color: #000000 !important;
            font-weight: bold !important;
        }

        /* Efecto al pasar el mouse por los botones verdes */
        .btn-primary:hover, .btn-success:hover {
            background-color: #8fb390 !important;
            border-color: #79a37c !important;
            color: #000000 !important;
        }
        /* Efecto al pasar el mouse por las filas de la tabla en el panel derecho */
        .table-hover tbody tr:hover {
            background-color: #c1e2f1 !important; /* Celeste suave al pasar el cursor */
            color: #000000 !important;
        }

        /* Efecto al pasar el mouse por los botones principales del lado derecho */
        .btn-primary:hover, .btn-success:hover {
            background-color: #a9d6eb !important; /* Un celeste un poco más vivo para los botones */
            border-color: #79bedf !important;
            color: #000000 !important;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
       <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
    <!-- Logo y Título -->
    <div class="text-center mb-3">
    <img src="img/logo.png" alt="Logo" class="sidebar-logo">
    <h4 class="sidebar-title mt-1"><i class="fa fa-stethoscope"></i> Odonto App</h4>
</div>
    
    <div class="small text-muted mb-3 text-center">Dr(a). <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></div>
    
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a class="nav-link active" href="#" id="menu-pacientes"><i class="fa fa-users"></i> Pacientes</a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link" href="#" id="menu-procedimientos"><i class="fa fa-medkit"></i> Procedimientos</a>
        </li>
        <li class="nav-item mt-4">
            <a class="nav-link text-danger" href="logout.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
        </li>
    </ul>
</nav>

        <!-- Contenido Principal -->
        <main class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
            
            <!-- Sección Pacientes -->
            <div id="sec-pacientes">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Gestión de Pacientes</h3>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalPaciente"><i class="fa fa-user-plus"></i> Nuevo Paciente</button>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-hover" id="tabla-pacientes">
                            <thead class="thead-light">
                                <tr>
                                    <th>Cédula</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sección Procedimientos -->
            <div id="sec-procedimientos" style="display:none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Procedimientos Odontológicos</h3>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modalProcedimiento"><i class="fa fa-plus-circle"></i> Nuevo Procedimiento</button>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-hover" id="tabla-procedimientos">
                            <thead class="thead-light">
                                <tr>
                                    <th>Procedimiento</th>
                                    <th>Descripción</th>
                                    <th>Costo</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- Modal Nuevo Paciente -->
<div class="modal fade" id="modalPaciente" tabindex="-1">
  <div class="modal-dialog">
    <form id="form-paciente" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Paciente</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Cédula / Documento</label><input type="text" name="cedula" class="form-control" required></div>
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
        <div class="form-group"><label>Apellido</label><input type="text" name="apellido" class="form-control" required></div>
        <div class="form-group"><label>Fecha Nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control" required></div>
        <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
        <div class="form-group"><label>Correo</label><input type="email" name="email" class="form-control"></div>
        <div class="form-group"><label>Dirección</label><textarea name="direccion" class="form-control" rows="2"></textarea></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar Paciente</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Nuevo Procedimiento -->
<div class="modal fade" id="modalProcedimiento" tabindex="-1">
  <div class="modal-dialog">
    <form id="form-procedimiento" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Procedimiento</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Nombre</label><input type="text" name="nombre" class="form-control" required placeholder="Ej: Limpieza, Blanqueamiento..."></div>
        <div class="form-group"><label>Descripción</label><textarea name="descripcion" class="form-control"></textarea></div>
        <div class="form-group"><label>Costo ($)</label><input type="number" step="0.01" name="costo" class="form-control" required></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar Procedimiento</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Historia Clínica -->
<div class="modal fade" id="modalHistoria" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo-historia">Historia Clínica</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <form id="form-historia" class="bg-light p-3 border rounded mb-4">
            <h6><i class="fa fa-file-text-o"></i> Registrar Nueva Atención</h6>
            <input type="hidden" name="paciente_id" id="historia_paciente_id">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Procedimiento</label>
                    <select name="procedimiento_id" id="select-procedimientos" class="form-control" required></select>
                </div>
                <div class="form-group col-md-6">
                    <label>Diente / Zona Tratada</label>
                    <input type="text" name="diente_zona" class="form-control" placeholder="Ej: Muela 38...">
                </div>
                <div class="form-group col-12">
                    <label>Observaciones Clínicas</label>
                    <textarea name="observaciones" class="form-control" rows="2" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Guardar Atención</button>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6>Historial de Atenciones</h6>
            <a href="#" id="btn-pdf-descargar" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Descargar / Imprimir PDF</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="tabla-historias">
                <thead class="thead-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Procedimiento</th>
                        <th>Zona</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Scripts JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {

    $('#menu-pacientes').click(function(e) {
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        $('#sec-procedimientos').hide();
        $('#sec-pacientes').show();
    });

    $('#menu-procedimientos').click(function(e) {
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        $('#sec-pacientes').hide();
        $('#sec-procedimientos').show();
        cargarProcedimientos();
    });

    function cargarPacientes() {
        $.get('controllers/pacientes.php?action=listar', function(pacientes) {
            let html = '';
            pacientes.forEach(p => {
                html += `
                    <tr>
                        <td>${p.cedula}</td>
                        <td>${p.nombre} ${p.apellido}</td>
                        <td>${p.telefono || '-'}</td>
                        <td>${p.email || '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white" onclick="abrirHistoria(${p.id}, '${p.nombre} ${p.apellido}')">
                                <i class="fa fa-file-text"></i> Historia
                            </button>
                        </td>
                    </tr>`;
            });
            $('#tabla-pacientes tbody').html(html);
        });
    }

    function cargarProcedimientos() {
        $.get('controllers/procedimientos.php?action=listar', function(procedimientos) {
            let htmlTabla = '';
            let htmlSelect = '<option value="">Seleccione procedimiento...</option>';
            procedimientos.forEach(pr => {
                htmlTabla += `
                    <tr>
                        <td><strong>${pr.nombre}</strong></td>
                        <td>${pr.descripcion || '-'}</td>
                        <td>$${parseFloat(pr.costo).toFixed(2)}</td>
                    </tr>`;
                htmlSelect += `<option value="${pr.id}">${pr.nombre} ($${pr.costo})</option>`;
            });
            $('#tabla-procedimientos tbody').html(htmlTabla);
            $('#select-procedimientos').html(htmlSelect);
        });
    }

    $('#form-paciente').submit(function(e) {
        e.preventDefault();
        $.post('controllers/pacientes.php?action=guardar', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                $('#modalPaciente').modal('hide');
                $('#form-paciente')[0].reset();
                cargarPacientes();
            } else {
                alert(res.message);
            }
        });
    });

    $('#form-procedimiento').submit(function(e) {
        e.preventDefault();
        $.post('controllers/procedimientos.php?action=guardar', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                $('#modalProcedimiento').modal('hide');
                $('#form-procedimiento')[0].reset();
                cargarProcedimientos();
            }
        });
    });

    window.abrirHistoria = function(id, nombreCompleto) {
        $('#historia_paciente_id').val(id);
        $('#titulo-historia').text('Historia Clínica: ' + nombreCompleto);
        $('#btn-pdf-descargar').attr('href', 'pdf_historia.php?id=' + id);
        cargarProcedimientos();
        cargarHistorialAtenciones(id);
        $('#modalHistoria').modal('show');
    };

    function cargarHistorialAtenciones(pacienteId) {
        $.get('controllers/historias.php?action=obtener&paciente_id=' + pacienteId, function(historias) {
            let html = '';
            historias.forEach(h => {
                html += `
                    <tr>
                        <td><small>${h.fecha_atencion}</small></td>
                        <td><strong>${h.procedimiento}</strong></td>
                        <td>${h.diente_zona || '-'}</td>
                        <td>${h.observaciones}</td>
                    </tr>`;
            });
            if(historias.length === 0) {
                html = '<tr><td colspan="4" class="text-center text-muted">Sin atenciones registradas</td></tr>';
            }
            $('#tabla-historias tbody').html(html);
        });
    }

    $('#form-historia').submit(function(e) {
        e.preventDefault();
        let pacienteId = $('#historia_paciente_id').val();
        $.post('controllers/historias.php?action=guardar', $(this).serialize(), function(res) {
            if(res.status === 'success') {
                $('#form-historia')[0].reset();
                $('#historia_paciente_id').val(pacienteId);
                cargarHistorialAtenciones(pacienteId);
            }
        });
    });

    cargarPacientes();
});
</script>
</body>
</html>