<?php



include "../controller/register_login.php";



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
     
  
   <link rel="stylesheet" href="../assets/estilos.css?v=<?php echo time(); ?>">
    <title>FORMULARIO DE REGISTRO E INICIO SESIÓN</title>

</head>
<body data-formulario="<?php echo $_SESSION['mostrar_formulario'] ?? 'registro'; ?>">
    <?php unset($_SESSION['mostrar_formulario']); ?>
    <div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido a nuestra comunidad</h2>
                <h5>Red Social para Artesanos</h5>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una Cuenta</h2>
                <p>o usa tu email para registrarte</p>
               <?php if(isset($_SESSION['error_mail'])): ?>
                    <div class="alert alert-danger" role="alert"><?php echo $_SESSION['error_mail']; ?></div>
                    <?php unset($_SESSION['error_mail']); ?>
                <?php endif; ?>
                <?php if(isset($_SESSION['exito_registro'])): ?>
                        <div class="alert alert-success" role="alert"><?php echo $_SESSION['exito_registro']; ?></div>
                         <?php unset($_SESSION['exito_registro']); ?>
                <?php endif; ?>
                <form class="form form-register" method="post" id="formularioRegistro">
                    <div>
                        <label>
                            <i class='bx bx-user' ></i>
                            <input type="text" placeholder="Nombre" name="nombre"  required pattern="^[A-Za-zÀ-ÿÑñ]+(?:\s[A-Za-zÀ-ÿÑñ]+)*$" id="nombreVerificar" value="<?php echo isset($_SESSION['datos_correctos']['nombre']) ? $_SESSION['datos_correctos']['nombre']: ''; ?>">
                           
                        </label>
                        <div class="alerta-nombre" style="display: <?php echo isset($_SESSION['errores_registro']['nombre']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-nombre">
                                    <?php 
                                     if(isset($_SESSION['errores_registro']['nombre'])) {
                                        echo "".$_SESSION['errores_registro']['nombre']; 
                                        unset($_SESSION['errores_registro']['nombre']);
                                        }
                                     ?>
                                </span>
                            </div>
                        </div>
                        
                     
                    </div>
                    
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electronico" name="gmail" required  pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" id="gmailVerificar" value="<?php echo isset($_SESSION['datos_correctos']['gmail']) ? $_SESSION['datos_correctos']['gmail']: ''; ?>">
                        </label>

                          <div class="alerta-gmail"  style="display: <?php echo isset($_SESSION['errores_registro']['gmail']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert"  >
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-gmail">
                                    <?php 
                                     if(isset($_SESSION['errores_registro']['gmail'])) {
                                        echo "".$_SESSION['errores_registro']['gmail']; 
                                        unset($_SESSION['errores_registro']['gmail']);
                                        }
                                     ?>
                                </span>
                            </div>
                        </div>
                    </div>
                   <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="contraseña" required  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" id="contraseñaVerificar">
                        </label>
                          <div class="alerta-contraseña"  style="display: <?php echo isset($_SESSION['errores_registro']['contraseña']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert" >
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-contraseña">
                                      <?php 
                                     if(isset($_SESSION['errores_registro']['contraseña'])) {
                                        echo "".$_SESSION['errores_registro']['contraseña']; 
                                        unset($_SESSION['errores_registro']['contraseña']);
                                        }
                                     ?>
                                </span>
                            </div>
                        </div>
                   </div>

                   
                   
                    <input type="submit" value="Registrarse" name="enviarRegistro" id="btn-registrarse">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                   
                   
                </form>

             
            </div>
        </div>
    </div>
                       

    <div class="container-form login hide">
        <div class="information">
            <div class="info-childs">
                <h2>¡¡Bienvenido nuevamente!!</h2>
                <h5>Red Social para Artesanos</h5>
                <p>Para unirte a nuestra comunidad por favor Inicia Sesión con tus datos</p>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesión</h2>
               
                <p>o Iniciar Sesión con una cuenta</p>

                <?php if(isset($_SESSION['error_login'])): ?>
                 <div  class="alert alert-danger" role="alert"><?php echo $_SESSION['error_login']; ?></div>
                    <?php unset($_SESSION['error_login']); ?>
                <?php endif; ?>
                 <?php if(isset($_SESSION['error_sesion'])): ?>
                 <div  class="alert alert-danger" role="alert"><?php echo $_SESSION['error_sesion']; ?></div>
                    <?php unset($_SESSION['error_sesion']); ?>
                <?php endif; ?>
                <form class="form form-login" method="post" id="formularioLogin">
                    <div>
                        <label >
                            <i class='bx bx-envelope' ></i>
                            <input type="email" placeholder="Correo Electronico" name="gmailLogin" id="gmailVerificarLogin" required  pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" >
                        </label>
                        <div class="alerta-gmail-login" style="display: <?php echo isset($_SESSION['errores_login']['gmail']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert"  >
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-gmail-login">
                                    <?php
                                        if(isset($_SESSION['errores_login']['gmail'])) {
                                        echo $_SESSION['errores_login']['gmail']; 
                                        unset($_SESSION['errores_login']['gmail']);
                                        }
                                     ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label>
                            <i class='bx bx-lock-alt' ></i>
                            <input type="password" placeholder="Contraseña" name="contraseñaLogin"  required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" id="contraseñaVerificarLogin"> 
                        </label>
                         <div class="alerta-contraseña-login" style="display: <?php echo isset($_SESSION['errores_registro']['contraseña']) ? 'block' : 'none'; ?>;">
                            <div class="alerta alert alert-danger py-1 px-2 d-flex align-items-center" role="alert" >
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <span id="error-contraseña-login">
                                    <?php
                                        if(isset($_SESSION['errores_login']['contraseña'])) {
                                        echo $_SESSION['errores_login']['contraseña']; 
                                        unset($_SESSION['errores_login']['contraseña']);
                                        }
                                     ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Iniciar Sesión" name="enviarLogin" id="btn-iniciarSesion">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <a href="recuperarContraseña.php" class="d-block text-center mt-3 text-decoration-none fw-semibold text-primary">
                         <i class='bx bx-lock-open me-1'></i>¿Olvidaste tu contraseña?
                    </a>
                   
                </form>
            </div>
        </div>
    </div>
    <script src="../assets/funcionalidades.js"></script>
    <script src="../assets/validacionFormulario.js"></script>
    <script src="../assets/validacionLogin.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   
</body>
</html>
