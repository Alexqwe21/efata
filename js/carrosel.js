
document.addEventListener("DOMContentLoaded", function () {
    const banner = document.querySelector('.banner');

    const imagens = [
        'img/baner_home.png',
        'img/banner_dois.png',
        'img/banner_tres.png'
    ];

    let index = 0;

    function trocarImagem() {
        banner.style.backgroundImage = `url(${imagens[index]})`;
        index = (index + 1) % imagens.length;
    }

    // Inicia com a primeira imagem
    trocarImagem();

    // Troca a cada 5 segundos (5000ms)
    setInterval(trocarImagem, 5000);
});


 