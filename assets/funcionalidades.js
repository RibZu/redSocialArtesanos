
const body = document.body;
let formulario = body.dataset.formulario;






const btnSignIn = document.getElementById("sign-in"),
      btnSignUp = document.getElementById("sign-up"),
      containerFormRegister = document.querySelector(".register"),
      containerFormLogin = document.querySelector(".login");



btnSignIn.addEventListener("click", e => {
    containerFormRegister.classList.add("hide");
    containerFormLogin.classList.remove("hide")
})


btnSignUp.addEventListener("click", e => {
    containerFormLogin.classList.add("hide");
    containerFormRegister.classList.remove("hide")
})


if(formulario === 'login'){
    containerFormRegister.classList.add("hide");
    containerFormLogin.classList.remove("hide");
} else {
    containerFormRegister.classList.remove("hide");
    containerFormLogin.classList.add("hide");
}

