<?php
include "../controller/register_login.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="../assets/estilosRecuperarContraseña.css?v=<?php echo time(); ?>">
    <title>Recuperar Contraseña</title>

</head>
<body data-paso="<?php echo $_SESSION['paso_recuperacion'] ?? 'solicitar'; ?>">
    <?php unset($_SESSION['paso_recuperacion']); ?>
    
    <!-- PASO 1: Solicitar email -->
    <div class="container-form solicitar-email">
        <div class="information">
            <div class="info-childs">
                <h2>¿Olvidaste tu contraseña?</h2>
                <p>No te preocupes, te ayudaremos a recuperarla. Ingresa tu email y te enviaremos un código de verificación</p>
                <input type="button" value="Volver al Login" id="btn-volver-login">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Recuperar Contraseña</h2>
                <p>Paso 1: Ingresa tu correo electrónico</p>
                
                <?php if(isset($_SESSION['error_email'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $_SESSION['error_email']; ?></div>
                    <?php unset($_SESSION['error_email']); ?>
                <?php endif; ?>
                
                <form class="form" method="post" action="../controller/enviarGmail.php" id="formSolicitarCodigo">
                    <div>
                        <label>
                            <i class='bx bx-envelope'></i>
                            <input type="email" placeholder="Correo Electrónico" name="emailRecuperar" 
                                   required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                                   id="emailVerificar">
                        </label>
                        <div class="alerta-gmail" style="display: <?php echo isset($_SESSION['error_mail']['email']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-gmail">
                                    <?php
                                        if(isset($_SESSION['error_mail']['email'])) {
                                        echo $_SESSION['error_mail']['email']; 
                                        unset($_SESSION['error_mail']['email']);
                                        }
                                    
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="submit" value="Enviar Código" name="enviarCodigo" id="btn-enviar-codigo">
                    
                    <div class="back-link">
                        <a href="login.php">← Volver al inicio de sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PASO 2: Verificar código -->
    <div class="container-form verificar-codigo hide">
        <div class="information">
            <div class="info-childs">
                <h2>Verificación</h2>
                <p>Te hemos enviado un código de verificación a tu correo electrónico. Por favor ingrésalo para continuar</p>
                <input type="button" value="Reintentar" id="btn-reintentar">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Verificar Código</h2>
                <p>Paso 2: Ingresa el código recibido</p>
                
                <?php if(isset($_SESSION['error_codigo'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $_SESSION['error_codigo']; ?></div>
                    <?php unset($_SESSION['error_codigo']); ?>
                <?php endif; ?>
                
                <form class="form" method="post" action="../controller/enviarGmail.php" id="formVerificarCodigo">
                    <div>
                        <label>
                            <i class='bx bx-key'></i>
                            <input type="text" placeholder="Código de Verificación" name="codigoVerificacion" 
                                   required pattern="^[0-9]{6}$" id="codigoVerificar" maxlength="6">
                        </label>
                        <div class="alerta-codigo" style="display: <?php echo isset($_SESSION['errorCodigo']['error_codigo_sinI']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-codigo">
                                     <?php
                                        if(isset($_SESSION['errorCodigo']['error_codigo_sinI'])) {
                                        echo $_SESSION['errorCodigo']['error_codigo_sinI']; 
                                        unset($_SESSION['errorCodigo']['error_codigo_sinI']);
                                        }
                                    
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <input type="submit" value="Verificar Código" name="verificarCodigo" id="btn-verificar-codigo">
                    
                    <div class="back-link">
                        <a href="?paso=solicitar">← No recibí el código</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PASO 3: Nueva contraseña -->
    <div class="container-form nueva-contraseña hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡Último Paso!</h2>
                <p>Tu identidad ha sido verificada. Ahora puedes establecer una nueva contraseña segura para tu cuenta</p>
                <input type="button" value="Ir al Login" id="btn-ir-login">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Nueva Contraseña</h2>
                <p>Paso 3: Crea una contraseña segura</p>
                
                <?php if(isset($_SESSION['error_password'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $_SESSION['error_password']; ?></div>
                    <?php unset($_SESSION['error_password']); ?>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['exito_recuperacion'])): ?>
                    <div class="alert alert-success" role="alert"><?php echo $_SESSION['exito_recuperacion']; ?></div>
                    <?php unset($_SESSION['exito_recuperacion']); ?>
                <?php endif; ?>
                
                <form class="form" method="post" action="../controller/enviarGmail.php" id="formNuevaContraseña">
                    <div>
                        <label>
                            <i class='bx bx-lock-alt'></i>
                            <input type="password" placeholder="Nueva Contraseña" name="nuevaContraseña" 
                                   required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" 
                                   id="nuevaContraseñaVerificar">
                        </label>
                        <div class="alerta-nueva-contraseña" style="display: <?php echo isset($_SESSION['erroresC']['contraseña_incorrecta']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-nueva-contraseña">
                                      <?php
                                        if(isset($_SESSION['erroresC']['contraseña_incorrecta'])) {
                                        echo $_SESSION['erroresC']['contraseña_incorrecta']; 
                                        unset($_SESSION['erroresC']['contraseña_incorrecta']);
                                        }
                                    
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label>
                            <i class='bx bx-lock-alt'></i>
                            <input type="password" placeholder="Confirmar Contraseña" name="confirmarContraseña" 
                                   required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" 
                                   id="confirmarContraseñaVerificar">
                        </label>
                    </div>
                    
                    <input type="submit" value="Cambiar Contraseña" name="cambiarContraseña" id="btn-cambiar-contraseña">
                    
                    <div class="back-link">
                        <a href="login.php">← Cancelar y volver al login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="../assets/funcionalidadesRC.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>