<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Odonto App</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
  
        body.bg-custom {
            background-color: #e3f2fd !important;
        }
    
        .titulo-app {
            font-size: 5.5rem;
            color: #153c61;
            margin-top: -40px;
        }
   
        .logo-img {
        width: 220px;
        height: 220px;
        object-fit: contain;
        display: block;
        margin: 0 auto -85px auto;
    }
        
   
        .cuerpo-verde {
            background-color: #d0f7d3 !important;
        }
    </style>
</head>
<body class="bg-custom d-flex flex-column min-vh-100" style="height: 100vh;">

<div class="container my-auto flex-grow-1 d-flex flex-column justify-content-center py-4">
    <!-- Título y Logo Principal -->
    <div class="row justify-content-center mb-3">
        <div class="col text-center">
            <!-- Aquí se inserta el logo -->
            <img src="img/logo.png" alt="Logo Odonto App" class="logo-img mb-2">
            <h1 class="font-weight-bold titulo-app">Odonto App</h1>
            <p class="text-muted font-weight-bold">SISTEMA DE GESTIÓN ODONTOLÓGICA</p>
            <hr class="w-25 border-primary">
        </div>
    </div>

    <!-- Contenedor del Formulario de Login -->
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa fa-sign-in" aria-hidden="true"></i> Iniciar Sesión</h5>
                </div>
                <div class="card-body p-4 cuerpo-verde">
                    <!-- Formulario con AJAX -->
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="email"><i class="fa fa-user"></i> Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="admin@dental.com" required autocomplete="username">
                        </div>
                        
                        <div class="form-group">
                            <label for="password"><i class="fa fa-lock"></i> Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña..." required autocomplete="current-password">
                        </div>
                        
                        <!-- Alerta dinámica para errores -->
                        <div id="alertMessage" class="alert d-none py-2 text-center" role="alert"></div>
                        
                        <button type="submit" class="btn btn-success btn-block py-2 mt-3 font-weight-bold">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> Ingresar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Pequeño -->
<footer class="bg-white border-top py-3 mt-auto text-center text-muted">
    <div class="container">
        <small><i class="fa fa-code"></i> Odonto App &copy; 2026 — Desarrollado con PHP, AJAX y Bootstrap 4</small>
    </div>
</footer>

<!-- Bootstrap JS Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Script AJAX para procesar el Login sin recargar -->
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = {
                email: $('#email').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: 'controllers/auth.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = 'dashboard.php';
                    } else {
                        $('#alertMessage').removeClass('d-none alert-success').addClass('alert-danger').text(response.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#alertMessage').removeClass('d-none alert-success').addClass('alert-danger').text('Error de conexión con el servidor.');
                }
            });
        });
    });
</script>

</body>
</html>