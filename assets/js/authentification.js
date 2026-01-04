const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const creerCompteBtn = document.getElementById('creerCompte');
const dejaCompteBtn = document.getElementById('dejaCompte');

registerBtn.addEventListener('click', ()=>{
    container.classList.add("active");
});

dejaCompteBtn.addEventListener('click', ()=>{
    container.classList.remove('active');
});

loginBtn.addEventListener('click', ()=>{
    container.classList.remove("active");
});

creerCompteBtn.addEventListener('click', ()=>{
    container.classList.add('active');
});