
  
  $(document).ready(function () {
    const links = $('#menu a');
    const currentPath = window.location.pathname;

    // Remove qualquer classe ativa
    links.removeClass('active');

    // Marca como ativo o link que corresponde à URL
    links.each(function () {
      const linkPath = $(this).attr('href');

      if (linkPath === currentPath) {
        $(this).addClass('active');
      }
    });

    // Ao clicar em qualquer link, define como ativo visualmente (em tempo real)
    links.on('click', function () {
      links.removeClass('active');
      $(this).addClass('active');
    });
  });

