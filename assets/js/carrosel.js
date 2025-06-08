
document.addEventListener("DOMContentLoaded", function () {
  const banner = document.querySelector('.banner');

  const imagens = [
    'assets/img/baner_home.png',
    'assets/img/banner_dois.png',
    'assets/img/banner_tres.png'
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
  slidesToShow: 2,
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



$('.lado_a_lado_patrocinador, .coordenadores').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});


$(document).ready(function () {
  const $carrosel = $('.carrosel');

  $carrosel.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 10000,
    arrows: false,
    dots: false,
    centerMode: false,
    variableWidth: false
  });

  // Atualiza contador ao trocar slide
  $carrosel.on('afterChange', function (event, slick, currentSlide) {
    const totalSlides = slick.slideCount;
    $('.contador-carrossel').text(`${currentSlide + 1} / ${totalSlides}`);
  });
});




function iniciarBarraProgressoPorSlides($carousel, tempo) {
  const $barra = $carousel.closest('.carrossel-jogadoras').find('.progresso-fill');
  const duracaoPorSlide = tempo;

  let totalSlides;
  let timeoutReset;

  function atualizarTotal() {
    totalSlides = $carousel.find('.slick-slide:not(.slick-cloned)').length;
  }

  function atualizarBarra(index) {
    const porcentagem = ((index + 1) / totalSlides) * 100;
    $barra.css({
      width: `${porcentagem}%`,
      transition: `width ${duracaoPorSlide}ms linear`
    });

    // Se for o último slide, reinicia após o tempo
    if (index + 1 >= totalSlides) {
      clearTimeout(timeoutReset);
      timeoutReset = setTimeout(() => {
        $barra.css({
          width: '0%',
          transition: 'none'
        });
      }, duracaoPorSlide);
    }
  }

  // Evento para qualquer troca de slide
  $carousel.on('afterChange', function (event, slick, currentSlide) {
    atualizarBarra(currentSlide);
  });

  atualizarTotal();
  atualizarBarra(0); // inicia no slide 0
}

$(document).ready(function () {
  const $jogadoras = $('.jogadoras');

  $jogadoras.slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 10000,
    arrows: true, // pode ativar para testar com clique
    dots: false,
    infinite: true, // mesmo com loop, o script funciona
    responsive: [{
      breakpoint: 800,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    ]
  });

  iniciarBarraProgressoPorSlides($jogadoras, 2000);
});



$(document).ready(function () {
  $('.carrosel_foto_evento').slick({
    centerMode: true,
    centerPadding: '0px',
    slidesToShow: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 9000,
    speed: 800,
    cssEase: 'ease-in-out',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 1,
          autoplay: true,
          autoplaySpeed: 10000
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
          autoplaySpeed: 10000
        }
      }
    ]
  });

  // ✅ Marcar o <strong> ativo ao trocar slide
  $('.carrosel_foto_evento').on('afterChange', function (event, slick, currentSlide) {
    $('.selecao_texto strong').removeClass('ativo');
    $(`.selecao_texto strong[data-slide="${currentSlide}"]`).addClass('ativo');
  });

  // ✅ Ir para o slide ao clicar no <strong>
  $('.selecao_texto strong').on('click', function () {
    const index = $(this).data('slide');
    $('.carrosel_foto_evento').slick('slickGoTo', index);
  });

  // ✅ Ativar o primeiro item ao carregar
  $('.selecao_texto strong[data-slide="0"]').addClass('ativo');
});





