const toggle = document.getElementById("menu-toggle");
const menu = document.querySelector("nav ul");

toggle.addEventListener("click", () => {
  toggle.classList.toggle("active"); // transforma o botão em X
  menu.classList.toggle("open"); // abre/fecha o menu
});
