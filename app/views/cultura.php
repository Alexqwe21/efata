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


        <a href="https://api.whatsapp.com/send?phone=5511912345494" target="_blank" class="whatsapp-fixo"
            aria-label="Fale conosco pelo WhatsApp">
            <img src="assets/img/whatsapp_Flutuante.svg" alt="WhatsApp"/>
        </a>


        <section class="banner_sobre cultura">
            <article class="site">
                <div class="ben_vindo">
                    <h2>TRADIÇÃO</h2>
                    <h3>CULTURA EFATÁ</h3>
                    <p id="breadcrumb">
                        <a href="/home">Início</a> / <span id="pagina-atual"></span>
                    </p>
                </div>



            </article>
            </div>
        </section>

        <div class="space"></div>

        <section class="treino">
            <article class="site">
                <div class="ladoAlado">
                    <div class="foto">
                        <img src="/assets/img/cultura_socio.png" alt="foto treino">
                    </div>
                    <div class="treinos_texto treino_texto_cultura">
                        <h2>SOCIOEDUCATIVO</h2>
                        <h3>Nosso projeto vai além das quadras.</h3>
                        <p>Através de
                            Por meio de atividades
                            socioeducativas, promovemos valores como respeito, disciplina,
                            responsabilidade e solidariedade. Buscamos formar cidadãos
                            conscientes, oferecendo um ambiente seguro e acolhedor para
                            o desenvolvimento integral dos participantes.
                            Provendo cursos para qualificação e suporte na entrega de
                            cestas básicas.</p>
                        <div class="foto">
                            <img src="/assets/img/foto_cultura_quatro.png" alt="foto volei">
                        </div>
                    </div>
                </div>
            </article>
        </section>

        <div class="space"></div>

        <section class="jogo_esporte">
            <article class="site">
                <div class="ladoAlado">

                    <div class="treinos_texto treino_texto_cultura">
                        <h2>PALESTRAS</h2>
                        <h3>Realizamos palestras com temas para a juventude.</h3>
                        <p>Abordando princípios cristãos, ética, prevenção às drogas,
                            cidadania e fortalecimento da fé. São momentos de reflexão e
                            crescimento, que contribuem para a transformação de vidas
                            através da mensagem do Evangelho.</p>
                        <div class="foto">
                            <img src="/assets/img/cultura_palestra_dois.png" alt="foto volei">
                        </div>
                    </div>

                    <div class="foto responsivodiv">
                        <img src="/assets/img/cultura_palestra.png" alt="foto treino" class="responsivo">
                    </div>
                </div>
            </article>
        </section>

        <div class="space"></div>


        <section class="lista_esporte">
            <article class="site">
                <div class="lado_a_ladoEsporte">


                    <div class="foto_lista">

                        <!-- Imagem com Fancybox -->
                        <a href="/assets/img/DESENVOLVIMENTO_PESSOAL.png" data-fancybox="galeria_esporte" data-caption="Amistoso - Cultura Efatá">
                            <img src="/assets/img/DESENVOLVIMENTO_PESSOAL.png" alt="amistoso">
                        </a>

                        <!-- Vídeo com Fancybox -->
                        <a href="" data-fancybox data-caption="Vídeo do Amistoso">
                            <div class="video_e_texto">
                                <p>DESENVOLVIMENTO</p>
                                <div>
                                    <img src="/assets/img/video_cultura.svg" alt="vídeo">
                                    <span>REPRODUZIR VÍDEO</span>
                                </div>

                            </div>
                        </a>

                        <div class="venha_jogar venha_cultura">

                            <strong>JUNTE-SE AO NOSSO TIME! FAÇA SUA MATRÍCULA E VENHA JOGAR VÔLEI.</strong>
                        </div>

                        <div class="maps">
                            <div>
                                <img src="/assets/img/maps_cultura.svg" alt="maps">
                                <p>CULTURA EFATÁ</p>
                            </div>
                        </div>

                        <div class="descricaoTexto">
                            <p>Realizamos oficinas voltadas ao autoconhecimento, comunicação, liderança e resolução de conflitos, preparando os participantes para os desafios da vida em sociedade.</p>
                        </div>

                    </div>

                    <div class="foto_lista">

                        <!-- Imagem com Fancybox -->
                        <a href="/assets/img/IDENTIDADE_CULTURAL.png" data-fancybox="galeria_esporte" data-caption="IDENTIDADE CULTURAL.png- Cultura Efatá">
                            <img src="/assets/img/IDENTIDADE_CULTURAL.png" alt="amistoso">
                        </a>

                        <!-- Vídeo com Fancybox -->
                        <a href="" data-fancybox data-caption="Vídeo do Amistoso">
                            <div class="video_e_texto">
                                <p>IDENTIDADE CULTURAL</p>
                                <div>
                                    <img src="/assets/img/video_cultura.svg" alt="vídeo">
                                    <span>REPRODUZIR VÍDEO</span>
                                </div>

                            </div>
                        </a>

                        <div class="venha_jogar venha_cultura">

                            <strong>JUNTE-SE AO NOSSO TIME! FAÇA SUA MATRÍCULA E VENHA JOGAR VÔLEI.</strong>
                        </div>

                        <div class="maps">
                            <div>
                                <img src="/assets/img/maps_cultura.svg" alt="maps">
                                <p>CULTURA EFATÁ</p>
                            </div>
                        </div>

                        <div class="descricaoTexto">
                            <p>Valorizamos as raízes culturais locais e a diversidade étnica e religiosa. Por meio de ações que celebram essas diferenças, incentivamos o respeito mútuo, o diálogo e a construção de uma cultura de paz.</p>
                        </div>

                    </div>




                </div>
            </article>
        </section>


        <div class="space"></div>
        <!-- Cursor grande -->
        <img src="https://culturaefata.com.br/assets/img/cursor.png" id="cursorCustom">
    </main>


    <footer><?php require_once('templates/footer.php') ?></footer>





    <?php require_once('templates/scriptGeral.php') ?>



    <script>
        function animarContador(elemento, final) {
            let contador = 0;
            const duracao = 2000; // duração total em milissegundos (2 segundos)
            const fps = 30; // frames por segundo
            const totalPassos = Math.round(duracao / (1000 / fps));
            const incremento = final / totalPassos;

            const intervalo = setInterval(() => {
                contador += incremento;

                if (contador >= final) {
                    elemento.textContent = final + "+";
                    clearInterval(intervalo);
                } else {
                    elemento.textContent = Math.floor(contador);
                }
            }, 1000 / fps);
        }

        // Detectar se a seção está visível
        function isVisible(el) {
            const rect = el.getBoundingClientRect();
            return rect.top >= 0 && rect.top <= window.innerHeight;
        }

        // Controlar se já foi animado
        let animado = false;

        window.addEventListener('scroll', () => {
            if (animado) return;

            const numeros = document.querySelectorAll('.number strong');
            if (numeros.length && isVisible(numeros[0])) {
                numeros.forEach(num => {
                    const final = parseInt(num.dataset.numero);
                    animarContador(num, final);
                });
                animado = true;
            }
        });
    </script>

    <script>
        // Evita redefinir múltiplas vezes
        if (!window.cursorCustomHandlerInitialized) {
            const cursor = document.getElementById('cursorCustom');
            const areas = document.querySelectorAll('.carrossel-hover, .carrosel , .jogadoras'); // seleciona todas as áreas desejadas

            if (cursor && areas.length > 0) {
                document.addEventListener('mousemove', (e) => {
                    cursor.style.left = e.clientX + 'px';
                    cursor.style.top = e.clientY + 'px';
                });

                areas.forEach(area => {
                    area.addEventListener('mouseenter', () => {
                        cursor.style.opacity = '1';
                    });

                    area.addEventListener('mouseleave', () => {
                        cursor.style.opacity = '0';
                    });
                });
            }

            // Marca como inicializado
            window.cursorCustomHandlerInitialized = true;
        }
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

        openModalBtn.onclick = function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
            showSlide(currentSlide);
        }

        closeModalBtn.onclick = function() {
            modal.style.display = 'none';
        }

        prevBtn.onclick = function() {
            currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1;
            showSlide(currentSlide);
        }

        nextBtn.onclick = function() {
            currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1;
            showSlide(currentSlide);
        }

        // Fecha o modal se clicar fora da área do conteúdo
        window.onclick = function(event) {
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

        video.addEventListener('ended', function() {
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
        $(document).ready(function() {
            const links = $('#menu a');
            const currentPath = window.location.pathname;

            // Remove qualquer classe ativa
            links.removeClass('active');

            // Marca como ativo o link que corresponde à URL
            links.each(function() {
                const linkPath = $(this).attr('href');

                if (linkPath === currentPath) {
                    $(this).addClass('active');
                }
            });

            // Ao clicar em qualquer link, define como ativo visualmente (em tempo real)
            links.on('click', function() {
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
        $(document).ready(function() {
            function checkScroll() {
                if ($(window).scrollTop() > 200) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            }

            checkScroll();

            $(window).scroll(function() {
                checkScroll();
            });

            $('#back-to-top').click(function() {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
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