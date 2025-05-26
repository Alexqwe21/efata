
document.addEventListener("DOMContentLoaded", function () {
    const banner = document.querySelector('.banner');

    const imagens = [
        'https://culturaefata.com.br/assets/img/baner_home.png',
        '../assets/img/banner_dois.png',
        '../assets/img/banner_tres.png'
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



$('.carrosel_encontro').slick({
    centerMode: true,
    centerPadding: '0px',
    slidesToShow: 1,
    arrows: true,
    autoplay: true,             // Ativa o autoplay
    autoplaySpeed: 3000,        // Tempo entre slides (3000ms = 3 segundos)
    responsive: [
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 3000
            }
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '20px',
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 3000
            }
        }
    ]
});



$('.lado_a_lado_patrocinador').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 800, // Menor que 800px
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480, // Menor que 480px
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});



