<!DOCTYPE html>
<html lang="pt-br">

<head><?php require_once('templates/head.php');?></head>

<body>
    <button id="back-to-top" title="Voltar para o Topo"><img src="assets/img/seta_para_cima.svg" alt="seta"></button>

    <div class="preloader" id="preloader">
        <div id="lottie-container" style="width: 350px; height: 350px;"></div>
    </div>

    <header><?php require_once('templates/header.php');?></header>

    <main>
        <a href="https://wa.me/5511999999999" target="_blank" class="whatsapp-fixo"
            aria-label="Fale conosco pelo WhatsApp">
            <img src="assets/img/whatsapp_Flutuante.svg" alt="WhatsApp" />
        </a>


        <section class="banner">
            <div class="bg-transition"></div>
            <article class="site">
                <div class="ben_vindo">
                    <h2>BEM-VINDO</h2>
                    <h3>CULTURA EFATÁ</h3>
                    <p>Cultura Efatá é um projeto dedicado ao vôlei de quadra, com um propósito maior: usar o esporte
                        como uma ferramenta para compartilhar a Palavra do Senhor.
                        Acreditamos que o esporte vai além da competição — ele é um meio de união, crescimento e
                        transformação de vidas.</p>
                    <div class="sobre_mais">
                        <a href="#" class="saiba_mais ">Saiba mais</a>
                        <a href="#" class="sobre_nos" id="openModal">Galeria</a>
                    </div>

                </div>

                <div class="escolha_categoria">

                    <div class="container_escolha">
                        <a href="#"> <img src="assets/img/esporte.svg" alt="esporte"> <strong>ESPORTES</strong></a>
                    </div>

                    <div class="container_escolha_cul">
                        <a href="#"> <img src="assets/img/duas_cara.svg" alt="esporte"> <strong>CULTURA</strong></a>
                    </div>

                    <div class="container_escolha_even">
                        <a href="#"> <img src="assets/img/eventos.svg" alt="esporte"><strong>EVENTOS</strong></a>
                    </div>

                </div>


            </article>
            </div>
        </section>

        <div class="space">

        </div>

        <section class="video">
            <article class="site">
                <div class="centro">
                    <div class="video-wrapper">
                        <div class="video-thumbnail" id="thumbnail">
                            <div class="play-button" onclick="playVideo()">
                                <div class="play-icon"></div>
                            </div>
                        </div>

                        <video id="video" controls>
                            <source id="videoSource" src="assets/video/cultura_efata.mp4" type="video/mp4">
                            Seu navegador não suporta vídeo.
                        </video>
                    </div>

                    <div class="conhecer_efata">
                        <div>
                            <h3>Sobre o Cultura Efatá</h3>
                            <p>Nossa missão é criar um ambiente onde atletas possam desenvolver suas habilidades
                                esportivas, enquanto fortalecem sua fé e seus princípios cristãos.
                                Aqui, cada treino e cada jogo são oportunidades de aprendizado, comunhão e testemunho do
                                amor de Deus.
                            </p>
                            <div>
                                <a href="#" class="saiba_mais">Saiba mais</a>
                                <button class="sobre_nos" onclick="playVideo()">Play Video</button>

                            </div>


                        </div>
                    </div>
                </div>

            </article>
        </section>

        <section class="carrossel-nomes">
            <article class="conteudo">
                <div class="carrossel-nomes">
                    <div class="conteudo">
                        <div>/ SAQUE /</div>
                        <div>/ ATAQUE /</div>
                        <div>/ DEFESA /</div>
                        <div>/ VITÓRIA /</div>
                        <div>/ UNIÃO /</div>

                        <!-- Repetição para looping contínuo -->
                        <div>/ SAQUE /</div>
                        <div>/ ATAQUE /</div>
                        <div>/ DEFESA /</div>
                        <div>/ VITÓRIA /</div>
                        <div>/ UNIÃO /</div>

                        <div>/ SAQUE /</div>
                        <div>/ ATAQUE /</div>
                        <div>/ DEFESA /</div>
                        <div>/ VITÓRIA /</div>
                        <div>/ UNIÃO /</div>
                    </div>
                </div>

            </article>
        </section>

        <section class="jogos">
            <article class="site">
                <h3>Jogos Cultura Efatá</h3>
                <div class="lado_a_lado">
                    <div class="jogo">
                        <h4>Agosto 25,2023</h4>
                        <div class="times">
                            <img src="assets/img/time_spike.png" alt="time">
                            <p>3 - 2</p>
                            <img src="assets/img/time_centaurus.png" alt="time">

                        </div>
                        <h5>Campeonato Efatá</h5>
                        <p>Ceu são Miguel</p>
                    </div>

                    <div class="jogo">
                        <h4>Agosto 25,2023</h4>
                        <div class="times">
                            <img src="assets/img/time_spike.png" alt="time">
                            <p>3 - 2</p>
                            <img src="assets/img/time_cepheus.png" alt="time">

                        </div>
                        <h5>Campeonato Efatá</h5>
                        <p>Ceu são Miguel</p>
                    </div>


                </div>

                <div class="space"></div>

                <div class="lado_a_lado">
                    <div class="jogo">
                        <h4>Agosto 25,2023</h4>
                        <div class="times">
                            <img src="assets/img/time_spike.png" alt="time">
                            <p>3 - 2</p>
                            <img src="assets/img/time_cygnus.png" alt="time">

                        </div>
                        <h5>Campeonato Efatá</h5>
                        <p>Ceu são Miguel</p>
                    </div>

                    <div class="jogo">
                        <h4>Agosto 25,2023</h4>
                        <div class="times">
                            <img src="assets/img/time_volleyball.png" alt="time">
                            <p>3 - 2</p>
                            <img src="assets/img/time_cygnus.png " alt="time">

                        </div>
                        <h5>Campeonato Efatá</h5>
                        <p>Ceu são Miguel</p>
                    </div>


                </div>

            </article>
        </section>


        <div class="space"></div>

        <section class="eventos_prox">
            <div class="largura_total">
                <h2>PONTOS DE ENCONTRO</h2>
            </div>

            <div class="space"></div>

            <article class="site">
                <div class="eventos_esporte_cultura">
                    <div class="carrosel_encontro">


                        <div class="evento_esporte_cultura">
                            <a href="#">
                                <img src="assets/img/encontro_ceu.png" alt="Ceu são miguel">
                                <div>
                                    <strong>CEU SÃO MIGUEL</strong>
                                </div>

                            </a>
                        </div>

                        <div class="evento_esporte_cultura">
                            <a href="#">
                                <img src="assets/img/encontro_reverendo.png" alt="Escola reverendo tercio">
                                <div>
                                    <strong>REVERENDO TERCIO</strong>
                                </div>

                            </a>
                        </div>

                        <div class="evento_esporte_cultura">
                            <a href="#">
                                <img src="assets/img/encontro_parigot.png" alt="Parigot">
                                <div>
                                    <strong>PARIGOT</strong>
                                </div>

                            </a>
                        </div>

                        <div class="evento_esporte_cultura">
                            <a href="#">
                                <img src="assets/img/encontro_reverendo.png" alt="">
                                <div>
                                    <strong>REVERENDO TERCIO</strong>
                                </div>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="centro">
                    <a href="#" class="ver_atividades">Saiba mais</a>
                </div>

            </article>
        </section>



        <section class="eventos_espor">
            <div class="inverter">
                <div class="largura_total">
                    <h2>TREINOS</h2>
                </div>
            </div>


            <div class="space"></div>

            <article class="site">
                <div class="eventos_esporte_cultura">

                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/foto_treino.png" alt="Treinos Efatá">
                            <div>
                                <h3>Treinos</h3>
                                <p>Aulas com fundamentos técnicos, táticos e devocionais, unindo esporte e
                                    espiritualidade em cada encontro.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>

                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/foto_treino_dois.png" alt="Jogos e Competições">
                            <div>
                                <h3>Jogos e Competições</h3>
                                <p>Participação em torneios e campeonatos, sempre levando a mensagem do Evangelho dentro
                                    e fora das quadras.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>

                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/foto_treino_tres.png" alt="Momentos de Fé">
                            <div>
                                <h3>Oração e Palavra</h3>
                                <p>Momentos dedicados à oração, reflexão e ensino bíblico, fortalecendo a fé e a
                                    comunhão entre os atletas.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>


                </div>
                <div class="space"></div>
                <div class="centro">
                    <a href="#" class="ver_atividades">Veja todas as atividades esportivas</a>
                </div>

            </article>
        </section>



        <section class="eventos_cul">

            <div class="largura_total">
                <h2>OBJETIVO</h2>
            </div>



            <div class="space"></div>

            <article class="site">
                <div class="eventos_esporte_cultura">
                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/objetivo_um.png" alt="vôlei com excelência">
                            <div>
                                <h3>VÔLEI COM EXCELÊNCIA</h3>
                                <p>Ensinamos e praticamos o vôlei com dedicação, promovendo desenvolvimento técnico e
                                    espiritual em cada atleta.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>

                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/objetivo_dois.png" alt="Evangelismo Esportivo">
                            <div>
                                <h3>EVANGELISMO ESPORTIVO</h3>
                                <p>Utilizamos o esporte como ferramenta para anunciar o evangelho de Cristo e impactar
                                    vidas dentro e fora das quadras.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>

                    <div class="evento_esporte_cultura">
                        <a href="#">
                            <img src="assets/img/objetivo_tres.png" alt="Formação de Atletas">
                            <div>
                                <h3>FORMAÇÃO DE ATLETAS</h3>
                                <p>Buscamos formar atletas que sejam referência em caráter, liderança e fé, vivendo os
                                    valores cristãos no dia a dia.</p>
                                <span>SAIBA MAIS</span>
                            </div>
                        </a>
                    </div>
                </div>


                </div>
                <div class="space"></div>
                <div class="centro">
                    <a href="#" class="ver_atividades">Veja todas as atividades culturais</a>
                </div>

            </article>
        </section>


        <section class="sobre_foto">
            <article class="site">
                <div class="lado_a_lado">
                    <div class="columns">
                        <div class="info_sobre">
                            <h2>A Equipe do Projeto</h2>
                            <h3>Quem faz tudo acontecer</h3>
                            <h4>Cada membro tem um papel essencial no propósito do Cultura Efatá.</h4>
                            <p>
                                Nossa equipe é formada por pessoas comprometidas com excelência e propósito:
                                <br><br>
                                🏐 <strong>Allan</strong> — professor de Educação Física, responsável pelos treinos
                                técnicos.
                                <br>
                                🏐 <strong>Katiane</strong> — organiza os treinos e campeonatos, garantindo que tudo
                                funcione bem.
                                <br>
                                🏐 <strong>Pastora Gislene</strong> — cuida da parte espiritual e da organização dos
                                eventos.
                            </p>
                        </div>


                        <div class="space"></div>

                        <div class="sobre_nos_tel">
                            <div class="lado_a_lado">
                                <div class="ancora_sobre">
                                    <a href="#">SOBRE NOS</a>
                                </div>

                                <div class="tel_sobre">
                                    <img src="assets/img/tel_sobre.svg" alt="telefone">
                                    <p>11 96458-4570</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="foto_volei">
                        <img src="assets/img/volei_foto.png" alt="fotos_volei">
                    </div>
                </div>
            </article>
        </section>

        <div class="space"></div>
        <div class="space"></div>


        <section class="patrocinadores">
            <article class="site">
                <h2>Nossos Patrocinadores</h2>

                <div class="lado_a_lado_patrocinador">
                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_1.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Cygnus</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_cepheus.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Cepheus</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_centarius.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Centarius</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_centarius.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Centarius</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_centarius.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Centarius</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="#">
                                <img src="assets/img/patrocinador_centarius.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Centarius</h6>
                                <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas pariatur enim
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </section>

        <div class="space"></div>


        <section class="galeria_volei">
            <article class="site">
                <div class="atividades_volei">
                    <h4>Atividades na Quadra</h4>
                    <h5>Nossa galeria de fotos</h5>
                </div>

                <div class="galeria">
                    <div class="galeria_um">
                        <div class="foto_um">
                            <a href="assets/img/foto_um.png" data-fancybox="galeria_volei" data-width="1000" data-height="700">
                                <img src="assets/img/foto_um.png" alt="foto_galeria">
                            </a>
                        </div>
                        <div class="foto_dois">
                            <a href="assets/img/foto_dois.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_dois.png" alt="foto_galeria">
                            </a>
                        </div>
                    </div>

                    <div class="galeria_um">
                        <div class="foto_tres">
                            <a href="assets/img/foto_tres.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_tres.png" alt="foto_galeria">
                            </a>
                        </div>
                        <div class="foto_quatro">
                            <a href="assets/img/foto_quatro.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_quatro.png" alt="foto_galeria">
                            </a>
                        </div>
                    </div>

                    <div class="galeria_um">
                        <div class="foto_cinco">
                            <a href="assets/img/foto_cinco.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_cinco.png" alt="foto_galeria">
                            </a>
                        </div>
                        <div class="foto_seis">
                            <a href="assets/img/foto_seis.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_seis.png" alt="foto_galeria">
                            </a>
                        </div>
                    </div>

                    <div class="galeria_dois">
                        <div class="foto_sete">
                            <a href="assets/img/foto_sete.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_sete.png" alt="foto_galeria">
                            </a>
                        </div>
                        <div class="foto_oito">
                            <a href="assets/img/foto_oito.png" data-fancybox="galeria_volei" data-width="1000"
                                data-height="700">
                                <img src="assets/img/foto_oito.png" alt="foto_galeria">
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </section>


        <div class="space"></div>

        <section class="efeito_paralax">
            <article class="site">
                <div class="content">
                    <div class="columns">
                        <div class="texto">
                            <h2>Venha participar do nosso time</h2>
                            <div class="hr">
                                <hr>
                            </div>
                            <div class="paragrafro">
                                <p>
                                    Nosso time é dedicado e comprometido.
                                    Luan cuida da comunicação e marketing, enquanto Fidel e Almir organizam e apoiam as
                                    atividades.
                                    Juntos, transformamos vidas pelo esporte e pela fé.
                                </p>
                            </div>

                            <div class="cadastre">
                                <a href="#" class="cadastre-se">CADASTRE-SE</a>
                            </div>
                        </div>


                    </div>
                </div>
            </article>
        </section>


    </main>


    <footer><?php require_once('templates/footer.php') ?></footer>

    <!-- Modal -->
    <div id="modal" class="modal" style="display:none;">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>

            <!-- Slideshow -->
            <div class="slideshow-container">
                <img src="assets/img/galeria_um.png" style="width:100%" class="slide">
                <img src="assets/img/galeria_dois.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_tres.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_quatro.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_cinco.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_seis.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_sete.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_oito.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_nove.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_dez.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_onze.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_doze.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_treze.png" style="width:100%" class="slide" hidden>
                <img src="assets/img/galeria_quatorze.png" style="width:100%" class="slide" hidden>


                <button class="modal_button" id="prev">&#10094;</button>
                <button class="modal_button" id="next">&#10095;</button>
            </div>
        </div>
    </div>



<?php require_once('templates/scriptGeral.php') ?>


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