


let inputNombre=document.getElementById('nombreVerificar');
let inputMail=document.getElementById('gmailVerificar');
let inputContraseña=document.getElementById('contraseñaVerificar');
let formularioR=document.getElementById('formularioRegistro');
let enviar=document.getElementById('btn-registrarse');

let alertaNombre=document.querySelector('.alerta-nombre');
let alertaContraseña=document.querySelector('.alerta-contraseña');
let alertaMail=document.querySelector('.alerta-gmail');

enviar.addEventListener('click', ()=>{

    console.log("click");

   let valido=formularioR.checkValidity();

   let nombre=document.getElementById('error-nombre');
   let mail=document.getElementById('error-gmail');
   let contraseña=document.getElementById('error-contraseña');

    if(valido){
        formularioR.submit();
    }else{
          console.log("click else");

          
        if(inputNombre.validity.valueMissing){
            alertaNombre.style.display="block";
             nombre.innerHTML="Debe ingresar el nombre";
        }else if(inputNombre.validity.patternMismatch){
             alertaNombre.style.display="block";
             nombre.innerHTML="Ingrese bien los datos del nombre";
        } else {
            alertaNombre.style.display="none";
        }


        if(inputMail.validity.valueMissing){
            alertaMail.style.display="block";
             mail.innerHTML="Debe ingresar el mail";
        }else if(inputMail.validity.typeMismatch){
             alertaMail.style.display="block";
             mail.innerHTML="Ingrese bien los datos del mail";
        } else {
            alertaMail.style.display="none";
        }

        if(inputContraseña.validity.valueMissing){
            alertaContraseña.style.display="block";
            contraseña.innerHTML="Debe ingresar la contraseña";
        }else if(inputContraseña.validity.patternMismatch){
            alertaContraseña.style.display="block";
            contraseña.innerHTML="La contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número";
         }else{
            alertaContraseña.style.display="none";
          
         }
    }
});