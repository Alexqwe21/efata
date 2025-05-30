<!DOCTYPE html>
<html lang="pt-br">

<head><?php require_once('templates/head.php'); ?></head>

<body>
    <button id="back-to-top" title="Voltar para o Topo"><img src="assets/img/seta_para_cima.svg" alt="seta"></button>

    <div class="preloader" id="preloader">
        <div id="lottie-container" style="width: 350px; height: 350px;"></div>
    </div>

    <header><?php require_once('templates/header.php'); ?></header>

    <main>
        <a href="https://wa.me/5511999999999" target="_blank" class="whatsapp-fixo"
            aria-label="Fale conosco pelo WhatsApp">
            <img src="assets/img/whatsapp_Flutuante.svg" alt="WhatsApp" />
        </a>


        <section class="banner_sobre">
            <article class="site">
                <div class="ben_vindo">
                    <h2>SOBRE</h2>
                    <h3>CULTURA EFATÁ</h3>
                    <p id="breadcrumb">
                        <a href="/home">Início</a> / <span id="pagina-atual"></span>
                    </p>
                </div>



            </article>
            </div>
        </section>

        <div class="space"></div>

        <section class="sobre_bem_vindo">
            <article class="site">
                <div class="lado_a_lado">
                    <div class="carrossel-hover">
                        <!-- Imagem via background -->
                    </div>

                    <div class="texto_bem_vindo">
                        <hr>
                        <div class="sub_titulo_efata">
                            <h2>BEM-VINDO</h2>
                            <h3>CULTURA EFATA</h3>
                        </div>

                        <div class="equipe">
                            <h4>Equipe Cultura efata</h4>
                        </div>

                        <div class="ong">
                            <h5>Uma ONG dedicada a transformar a paixão pelo vôlei em oportunidades.</h5>
                        </div>

                        <div class="historia_sobre">
                            <p>A equipe da nossa ONG, com o intuito de atender às necessidades dos amantes do vôlei e da
                                comunidade, dedicou-se ao desenvolvimento de um site que oferece mais acessibilidade,
                                clareza e proximidade. Pensando em facilitar o acesso às informações, criamos um espaço
                                digital onde você pode acompanhar atividades, treinos e eventos esportivos com
                                comodidade, direto da sua casa. Com muito carinho e dedicação, nasce o site da nossa ONG
                                de Vôlei — um canal criado especialmente para fortalecer a paixão pelo esporte e
                                promover inclusão, transparência e oportunidades para todos.</p>
                        </div>

                        <div class="equipe_numero">
                            <h6>EQUIPE CULTURA EFATA</h6>
                        </div>

                        <div class="contagem">
                            <div class="contagem_um">
                                <div class="number_um">
                                    <strong>17+</strong>
                                    <hr>
                                    <span>Experiência</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </article>
        </section>
        <!-- Cursor grande -->
        <img src="https://culturaefata.com.br/assets/img/cursor.png" id="cursorCustom">

        <div class="space"></div>

    </main>


    <footer><?php require_once('templates/footer.php') ?></footer>





    <?php require_once('templates/scriptGeral.php') ?>







    <script>
        const cursor = document.getElementById('cursorCustom');
        const area = document.querySelector('.carrossel-hover');

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        area.addEventListener('mouseenter', () => {
            cursor.style.opacity = '1'; // Aparece suavemente
        });

        area.addEventListener('mouseleave', () => {
            cursor.style.opacity = '0'; // Some suavemente
        });
    </script>







    <script>
        const rotas = {
            "/": "Início",
            "/home": "Início",
            "/esporte": "Esporte",
            "/cultura": "Cultura",
            "/eventos": "Eventos",
            "/sobre": "Sobre"
        };

        const path = window.location.pathname;
        const paginaAtual = rotas[path] || "Página";

        // Exibe a parte final da trilha com destaque
        document.getElementById("pagina-atual").textContent = paginaAtual;
    </script>


    <script>
        const redes = document.querySelector('.redes_sociais');
        const como = document.querySelector('.como_funciona');
        const ulMenu = document.querySelector('#menu ul');

        // Guardar o local original
        const originalPaiRedes = redes?.parentElement;
        const originalPaiComo = como?.parentElement;

        function moverParaUL(elemento) {
            if (!ulMenu.contains(elemento)) {
                const li = document.createElement('li');
                li.classList.add('extra-item');
                li.appendChild(elemento);
                ulMenu.appendChild(li);
            }
        }

        function removerDeUL(elemento, originalPai) {
            const liPai = elemento.closest('li.extra-item');
            if (liPai && liPai.parentElement === ulMenu) {
                liPai.remove(); // Remove o <li> todo
                if (originalPai) {
                    originalPai.appendChild(elemento); // Volta o elemento para o lugar original
                }
            }
        }

        function moverElementosSeNecessario() {
            const isMobile = window.matchMedia('(max-width: 500px)').matches;

            if (isMobile) {
                moverParaUL(redes);
                moverParaUL(como);
            } else {
                removerDeUL(redes, originalPaiRedes);
                removerDeUL(como, originalPaiComo);
            }
        }

        window.addEventListener('DOMContentLoaded', moverElementosSeNecessario);
        window.addEventListener('resize', moverElementosSeNecessario);


    </script>


    <script>
        const modal = document.getElementById('modal');
        const openModalBtn = document.getElementById('openModal');
        const closeModalBtn = document.getElementById('closeModal');
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.getElementById('prev');
        const nextBtn = document.getElementById('next');

        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.hidden = i !== index;
            });
        }

        openModalBtn.onclick = function (e) {
            e.preventDefault();
            modal.style.display = 'flex';
            showSlide(currentSlide);
        }

        closeModalBtn.onclick = function () {
            modal.style.display = 'none';
        }

        prevBtn.onclick = function () {
            currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1;
            showSlide(currentSlide);
        }

        nextBtn.onclick = function () {
            currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1;
            showSlide(currentSlide);
        }

        // Fecha o modal se clicar fora da área do conteúdo
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <script>
        const video = document.getElementById('video');
        const source = document.getElementById('videoSource');
        const thumbnail = document.getElementById('thumbnail');

        const videos = [
            'assets/video/cultura_efata.mp4',
            'assets/video/treino.mp4'
        ];

        let current = 0;

        video.addEventListener('ended', function () {
            current = (current + 1) % videos.length;
            source.src = videos[current];
            video.load();
            video.play();
        });

        // Define a função no escopo global
        function playVideo() {
            if (thumbnail) {
                thumbnail.style.display = 'none';
            }
            video.play();
        }

        // Garante que a função esteja disponível globalmente
        window.playVideo = playVideo;
    </script>


    <script>
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
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const termos = ["/ SAQUE /", "/ ATAQUE /", "/ DEFESA /", "/ VITÓRIA /", "/ UNIÃO /"];
            const container = document.querySelector('.carrossel-nomes .conteudo');

            function embaralhar(array) {
                return array.sort(() => Math.random() - 0.5);
            }

            const termosRepetidos = [...embaralhar(termos), ...embaralhar(termos), ...embaralhar(termos)];
            container.innerHTML = termosRepetidos.map(t => `<div>${t}</div>`).join('');

            container.addEventListener('mouseenter', () => {
                container.style.animationPlayState = 'paused';
            });

            container.addEventListener('mouseleave', () => {
                container.style.animationPlayState = 'running';
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            function checkScroll() {
                if ($(window).scrollTop() > 200) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            }

            checkScroll();

            $(window).scroll(function () {
                checkScroll();
            });

            $('#back-to-top').click(function () {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                return false;
            });
        });

    </script>


    <script>
        // Inicia o preload com animação Lottie
        const animation = lottie.loadAnimation({
            container: document.getElementById('lottie-container'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'assets/preloads/preloads.json' // Caminho do seu JSON
        });

        // Esconde o preload após o carregamento
        window.addEventListener('load', () => {
            const preload = document.getElementById('preloader');
            setTimeout(() => {
                preload.style.opacity = '0';
                setTimeout(() => {
                    preload.style.display = 'none';
                }, 600);
            }, 2200);
        });
    </script>



</body>

</html>