<?php
session_start();

if(empty($_SESSION['idUsuario'])){
    header("Location: ../public/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creador de Álbum</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/estilosUsuarios.css">
</head>
<body>

    <div class="container-fluid px-4 profile-section min-vh-100 d-flex align-items-center">
        <div class="profile-card p-4 w-100" style="max-width: 30rem; margin: auto;">
            
            <h1 class="h3 mb-3 text-center">Crear Álbum</h1>
            
            <form action="..\logica\SubirAlbum.php" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="albumTitle" class="form-label">Título del Álbum</label>
                    <input type="text" class="form-control" id="albumTitle" name="albumTitle" required>
                </div>
                
                <div class="mb-3">
                    <label for="albumImages" class="form-label">Imágenes (hasta 20)</label>
                    <input type="file" class="form-control" id="albumImages" name="albumImages[]" multiple required accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Visibilidad de las fotos:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibilidad" id="visibilidadPublico" value="1" checked>
                        <label class="form-check-label" for="visibilidadPublico">
                            Público
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="visibilidad" id="visibilidadPrivado" value="2">
                        <label class="form-check-label" for="visibilidadPrivado">
                            Privado
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Títulos de las fotos:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcionTitulo" id="tituloAlbum" value="album" checked>
                        <label class="form-check-label" for="tituloAlbum">
                            Usar el mismo título del álbum
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcionTitulo" id="tituloNumerar" value="numerar">
                        <label class="form-check-label" for="tituloNumerar">
                            Numerar fotos (Ej: Foto 1, Foto 2...)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opcionTitulo" id="tituloEditar" value="editar">
                        <label class="form-check-label" for="tituloEditar">
                            Editar individualmente el titulo y privacidad de cada imagen
                        </label>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-action btn-secondary">
                         <i class="fas fa-folder-plus"></i> Subir Álbum
                    </button>
                    <a href="perfilUsuario.php" class="btn btn-action btn-primary-custom">
                        <i class="fas fa-arrow-left"></i> Volver a Perfil
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const fileInput = document.getElementById('albumImages');
        const MAX_IMAGES = 20;

        fileInput.addEventListener('change', (event) => {
            const files = event.target.files;
            if (files.length > MAX_IMAGES) {
                alert(`No puedes seleccionar más de ${MAX_IMAGES} imágenes. Has seleccionado ${files.length}.`);
                fileInput.value = '';
            }
        });
    </script>
</body>
</html>