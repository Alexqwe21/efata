document.addEventListener("DOMContentLoaded", function () {
  const carrossel = document.querySelector('.carrossel-hover');

  const imagensCarrossel = [
    'assets/img/ben_vindo_sobre.png',
    'assets/img/bem_vindo_um.png',
    'assets/img/bem_vindo_dois.png'
  ];

  let indexCarrossel = 0;

  function trocarImagemCarrossel() {
    carrossel.style.backgroundImage = `url(${imagensCarrossel[indexCarrossel]})`;
    indexCarrossel = (indexCarrossel + 1) % imagensCarrossel.length;
  }

  // Inicializa a primeira imagem
  trocarImagemCarrossel();


  carrossel.addEventListener('click', trocarImagemCarrossel);

  // Troca a cada 5 segundos (5000ms)
  setInterval(trocarImagemCarrossel, 10000);
});