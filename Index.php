<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Gestor Financiero - Iniciar Sesión</title>
    <link rel="stylesheet" href="Assets/Librerias/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Assets/Css/Style.css">

    <script src="Assets/Librerias/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="Assets/Librerias/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
</head>
<body>
<div class="finance-bg"></div>
    <div class="finance-icons" id="financeIcons"></div>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <div class="logo-finance">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>Gestor de Finanzas Pro</h3>
                <p>Tu solución integral para el control financiero</p>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Iniciar sesión</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Registrarse</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="text" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="button" onclick="IniciarSesion();" class="btn btn-primary">Iniciar sesión</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form id="registerForm" onsubmit="RegistrarUsuario(); return false;">
                            <div class="mb-3">
                                <label for="newUsername" class="form-label">Nuevo Usuario<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="text" class="form-control" id="newUsername" name="newUsername" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailRegistro" class="form-label">Correo Electrónico<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="email" class="form-control" id="emailRegistro" name="emailRegistro" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Nueva Contraseña<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmar Contraseña<span Style="color: red; font-size: 25px;">*</span>:</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary">Registrarse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="Assets/Librerias/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Assets/Librerias/Font-Awesome/8567312853.js"></script>
    <script src="Assets/Js/Script.js"></script>
    <script src="Assets/Js/Usuarios/Usuario.js"></script>
</body>
</html>