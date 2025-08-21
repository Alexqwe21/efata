document.addEventListener("DOMContentLoaded", () => {
  const videoSite = document.querySelector(".video .site");

  function checkFade() {
    const rect = videoSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 350) {
      videoSite.classList.add("visible");
      // opcional: remover o listener se quiser que só aconteça uma vez
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // ativar ao carregar, caso já esteja visível
});

document.addEventListener("DOMContentLoaded", () => {
  const videoSite = document.querySelector(".lista_esporte .site");

  function checkFade() {
    const rect = videoSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 350) {
      videoSite.classList.add("visible");
      // opcional: remover o listener se quiser que só aconteça uma vez
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // ativar ao carregar, caso já esteja visível
});

document.addEventListener("DOMContentLoaded", () => {
  const eventosSite = document.querySelector(".eventos_prox .site ");

  function checkFade() {
    const rect = eventosSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      eventosSite.classList.add("visible");
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // checa no carregamento
});

document.addEventListener("DOMContentLoaded", () => {
  const eventosSite = document.querySelector(".eventos_espor .site");

  function checkFade() {
    const rect = eventosSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      eventosSite.classList.add("visible");
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // checa no carregamento
});

document.addEventListener("DOMContentLoaded", () => {
  const eventosSite = document.querySelector(".eventos_cul .site");

  function checkFade() {
    const rect = eventosSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      eventosSite.classList.add("visible");
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // checa no carregamento
});

document.addEventListener("DOMContentLoaded", () => {
  const eventosSite = document.querySelector(".jogo_esporte .site ");

  function checkFade() {
    const rect = eventosSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      eventosSite.classList.add("visible");
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // checa no carregamento
});

document.addEventListener("DOMContentLoaded", () => {
  const eventosSite = document.querySelector(".treino .site");

  function checkFade() {
    const rect = eventosSite.getBoundingClientRect();
    if (rect.top < window.innerHeight - 100) {
      eventosSite.classList.add("visible");
      window.removeEventListener("scroll", checkFade);
    }
  }

  window.addEventListener("scroll", checkFade);
  checkFade(); // checa no carregamento
});
