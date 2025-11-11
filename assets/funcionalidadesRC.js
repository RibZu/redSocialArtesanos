
        const body = document.body;
        let pasoActual = body.dataset.paso;
        
        const btnVolverLogin = document.getElementById("btn-volver-login");
        const btnReintentar = document.getElementById("btn-reintentar");
        const btnIrLogin = document.getElementById("btn-ir-login");
        
        const containerSolicitar = document.querySelector(".solicitar-email");
        const containerVerificar = document.querySelector(".verificar-codigo");
        const containerNuevaPassword = document.querySelector(".nueva-contraseña");
        
        // Botón volver al login desde paso 1
        btnVolverLogin.addEventListener("click", () => {
            window.location.href = "login.php";
        });
        
        // Botón reintentar desde paso 2
        btnReintentar.addEventListener("click", () => {
            containerVerificar.classList.add("hide");
            containerSolicitar.classList.remove("hide");
        });
        
        // Botón ir al login desde paso 3
        btnIrLogin.addEventListener("click", () => {
            window.location.href = "login.php";
        });
        
        // Mostrar el paso correcto según el data-paso
        if(pasoActual === 'verificar'){
            containerSolicitar.classList.add("hide");
            containerVerificar.classList.remove("hide");
            containerNuevaPassword.classList.add("hide");
        } else if(pasoActual === 'nueva_contraseña'){
            containerSolicitar.classList.add("hide");
            containerVerificar.classList.add("hide");
            containerNuevaPassword.classList.remove("hide");
        } else {
            containerSolicitar.classList.remove("hide");
            containerVerificar.classList.add("hide");
            containerNuevaPassword.classList.add("hide");
        }
        
        // Validación en tiempo real del email
        const emailInput = document.getElementById('emailVerificar');
        const alertaGmail = document.querySelector('.alerta-gmail');
        const errorGmail = document.getElementById('error-gmail');
        
        if(emailInput) {
            emailInput.addEventListener('blur', function() {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if(!emailPattern.test(this.value) && this.value !== '') {
                    alertaGmail.style.display = 'block';
                    errorGmail.textContent = 'Por favor ingresa un correo válido';
                } else {
                    alertaGmail.style.display = 'none';
                }
            });
        }
        
        // Validación del código de verificación
        const codigoInput = document.getElementById('codigoVerificar');
        const alertaCodigo = document.querySelector('.alerta-codigo');
        const errorCodigo = document.getElementById('error-codigo');
        
        if(codigoInput) {
            codigoInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            codigoInput.addEventListener('blur', function() {
                if(this.value.length !== 6 && this.value !== '') {
                    alertaCodigo.style.display = 'block';
                    errorCodigo.textContent = 'El código debe tener 6 dígitos';
                } else {
                    alertaCodigo.style.display = 'none';
                }
            });
        }
        
        // Validación de la nueva contraseña
        const nuevaPasswordInput = document.getElementById('nuevaContraseñaVerificar');
        const confirmarPasswordInput = document.getElementById('confirmarContraseñaVerificar');
        const alertaNuevaPassword = document.querySelector('.alerta-nueva-contraseña');
        const errorNuevaPassword = document.getElementById('error-nueva-contraseña');
        
        if(nuevaPasswordInput) {
            nuevaPasswordInput.addEventListener('blur', function() {
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
                if(!passwordPattern.test(this.value) && this.value !== '') {
                    alertaNuevaPassword.style.display = 'block';
                    errorNuevaPassword.textContent = 'Mínimo 8 caracteres, una mayúscula, una minúscula y un número';
                } else {
                    alertaNuevaPassword.style.display = 'none';
                }
            });
        }
        
        // Validar que las contraseñas coincidan
        if(confirmarPasswordInput) {
            confirmarPasswordInput.addEventListener('blur', function() {
                if(this.value !== nuevaPasswordInput.value && this.value !== '') {
                    alertaNuevaPassword.style.display = 'block';
                    errorNuevaPassword.textContent = 'Las contraseñas no coinciden';
                } else if(nuevaPasswordInput.value !== '') {
                    alertaNuevaPassword.style.display = 'none';
                }
            });
        }
    