const Modal = document.getElementById("Modal");
const ModalImg = document.getElementById("Modal-img");
const ModalTitulo = document.getElementById("Modal-titulo");
const ModalAutor = document.getElementById("nombre-autor");
const perfilAutor = document.getElementById("perfil-autor");
const ModalComentarios = document.getElementById("Modal-comentarios");
const nuevoComentarioInput = document.getElementById("nuevo-comentario");
const BtnComentar = document.getElementById("Btn-comentar");
const cerrarBtn = document.querySelector(".cerrar");

// Botón de like en el modal
const BtnLikeModal = document.querySelector(".like-Btn");
BtnLikeModal.addEventListener("click", () => {
    const idImagen = BtnComentar.dataset.idImagen;
    const icon = BtnLikeModal.querySelector("i");
    if (!idImagen) return;

    if (icon.textContent === "favorite_border") {
        icon.textContent = "favorite";
    } else {
        icon.textContent = "favorite_border";
    }


    fetch("../logica/like.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id_imagen=${idImagen}`
    });
});

// Delegación de eventos para todo el body
document.body.addEventListener("click", e => {

    // Botón de like en tarjetas
    const BtnLike = e.target.closest(".Btn.like");
    if (BtnLike) {
        e.stopPropagation();
        const icon = BtnLike.querySelector("i");
        const id = BtnLike.dataset.id;
        if (!id) return;

        fetch("../logica/like.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id_imagen=${id}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
               if (data.action === "liked") {
                    icon.textContent = "favorite";
                } else {
                    icon.textContent = "favorite_border";
                }

            } else {
                console.error("Error en like.php:", data.error);
            }
        })
        .catch(err => console.error(err));
        return;
    }

    // Click en tarjeta de imagen para abrir modal
    const card = e.target.closest(".img-card");
    if (card) {
        const img = card.querySelector("img");
        const titulo = card.querySelector(".img-title")?.textContent || "Sin Titulo";
        const autorNombre = img.dataset.autorNombre;
        const autorId = img.dataset.autorId;
        const idImagen = card.querySelector(".Btn.like")?.dataset.id;

        if (!idImagen) return;

        ModalImg.src = img.src;
        ModalTitulo.textContent = titulo;
        ModalAutor.textContent = autorNombre;
        ModalAutor.href = `../public/perfilUsuarios.php?idUsuarios=${autorId}`;
        perfilAutor.src = img.dataset.autorPerfil;

        // Cargar comentarios
        ModalComentarios.innerHTML = "";
        fetch(`../logica/comentarios.php?id_imagen=${idImagen}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(c => {
                    const div = document.createElement("div");
                    div.className = "comentario";
                    div.textContent = `${c.nombre}: ${c.texto}`;
                    ModalComentarios.appendChild(div);
                });
            });

        BtnComentar.dataset.idImagen = idImagen;
        Modal.classList.add("show");
        document.body.style.overflow = "hidden";
    }
});

// Cerrar Modal
cerrarBtn.addEventListener("click", () => {
    Modal.classList.remove("show");
    document.body.style.overflow = "auto";
});

// Cerrar Modal al hacer clic fuera
Modal.addEventListener("click", e => {
    if (e.target === Modal) cerrarBtn.click();
});


// Botón de comentar en el modal
BtnComentar.addEventListener("click", () => {
    const texto = nuevoComentarioInput.value.trim();
    const idImagen = BtnComentar.dataset.idImagen;

    // Validación básica
    if (!texto || !idImagen) return;

    // Crear el FormData y agregar los valores
    const data = new FormData();
    data.append("id_imagen", idImagen);
    data.append("texto", texto);

    // Enviar comentario al servidor
    fetch("../logica/comentarios.php", {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const div = document.createElement("div");
            div.className = "comentario";
            div.textContent = `${data.nombre}: ${data.texto}`;
            
            ModalComentarios.appendChild(div);

            nuevoComentarioInput.value = "";
        } else {
            console.error("Error al enviar comentario:", data.error);
        }
    })
    .catch(err => console.error("Error en la solicitud:", err));
});

