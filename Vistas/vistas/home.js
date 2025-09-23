const container = document.querySelector(".container");
const btnLogin = document.getElementById("btn-Login");
const btnRegister = document.getElementById("btn-Register");

btnLogin.addEventListener("click",()=>{
    container.classList.remove("toggle");
});

btnRegister.addEventListener("click",()=>{
    container.classList.add("toggle");
});