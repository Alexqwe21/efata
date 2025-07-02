document.addEventListener("DOMContentLoaded", function () {
  const carrossel = document.querySelector('.carrossel-hover');

  const imagensCarrossel = [
    '/assets/img/foto_sobre_luan.png',
    '/assets/img/foto_sobre_dois.png',
    '/assets/img/foto_sobre_tres.png'
  ];

  let indexCarrossel = 0;

  function trocarImagemCarrossel() {
    const timestamp = new Date().getTime(); // gera novo valor a cada execução
    const imagemComVersao = `${imagensCarrossel[indexCarrossel]}?v=${timestamp}`;

    carrossel.style.backgroundImage = `url(${imagemComVersao})`;
    indexCarrossel = (indexCarrossel + 1) % imagensCarrossel.length;
  }

  trocarImagemCarrossel(); // carrega a primeira imagem

  carrossel.addEventListener('click', trocarImagemCarrossel);

  setInterval(trocarImagemCarrossel, 10000); // troca a cada 10s
});
