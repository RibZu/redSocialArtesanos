
let inputLoginMail=document.getElementById('gmailVerificarLogin');
let inputLoginContraseña=document.getElementById('contraseñaVerificarLogin');

let alertaLoginMail=document.querySelector('.alerta-gmail-login');
let alertaLoginContraseña=document.querySelector('.alerta-contraseña-login');

let formularioL=document.getElementById('formularioLogin');
let enviarL=document.getElementById('btn-iniciarSesion');


enviarL.addEventListener('click', ()=>{

    let errorMail=document.getElementById('error-gmail-login');
    let errorContraseña=document.getElementById('error-contraseña-login');

    let valido=formularioL.checkValidity();

    if(valido){
        formularioL.submit();
    }else{

        if(inputLoginMail.validity.valueMissing){
            alertaLoginMail.style.display="block";
            errorMail.innerHTML="Debe ingresar el mail";
        }else if(inputLoginMail.validity.typeMismatch){
            alertaLoginMail.style.display="block";
            errorMail.innerHTML="Ingrese bien los datos del mail";
        } else {
            alertaLoginMail.style.display="none";
        }

        if(inputLoginContraseña.validity.valueMissing){
            alertaLoginContraseña.style.display="block";
            errorContraseña.innerHTML="Debe ingresar la contraseña";
        }else if(inputLoginContraseña.validity.patternMismatch){
            alertaLoginContraseña.style.display="block";
            errorContraseña.innerHTML="La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número";
        } else {
            alertaLoginContraseña.style.display="none";
        }

    }

});