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
        <a href="https://api.whatsapp.com/send?phone=5511944748900" target="_blank" class="whatsapp-fixo"
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
                        <a href="/sobre" class="saiba_mais ">Saiba mais</a>
                        <a href="#" class="sobre_nos" id="openModal">Galeria</a>
                    </div>

                </div>

                <div class="escolha_categoria">

                    <div class="container_escolha">
                        <a href="/esporte"> <img src="assets/img/esporte.svg" alt="esporte"> <strong>ESPORTES</strong></a>
                    </div>

                    <div class="container_escolha_cul">
                        <a href="/cultura"> <img src="assets/img/duas_cara.svg" alt="esporte"> <strong>CULTURA</strong></a>
                    </div>

                    <div class="container_escolha_even">
                        <a href="/eventos"> <img src="assets/img/eventos.svg" alt="esporte"><strong>EVENTOS</strong></a>
                    </div>

                </div>


            </article>
            </div>
        </section>

        <div class="space"></div>

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
                                <a href="/sobre" class="saiba_mais">Saiba mais</a>
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
                <div class="jogos_carrosel">



                    <div class="lado_a_lado_jogos">

                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/vibes.png" alt="vibes">
                                <p>2 - 1</p>
                                <img src="assets/img/thudercats.png" alt="time">

                            </div>
                            <h5>Amistoso</h5>
                            <p>Amistoso</p>
                        </div>


                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/Logo_Cultura.png" alt="time">
                                <p>5 - 0</p>
                                <img src="assets/img/sesi.webp" alt="time">

                            </div>
                            <h5>Amistoso</h5>
                            <p>Amistoso</p>
                        </div>

                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/dragao_time.png" alt="time">
                                <p>3 - 1</p>
                                <img src="assets/img/vibes.png" alt="vibes">

                            </div>
                            <h5>Amistoso</h5>
                            <p>Amistoso</p>
                        </div>


                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/circulo_phoenix.png" alt="time">
                                <p>1 - 0</p>
                                <img src="assets/img/circulo_setFinal.png" alt="vibes">

                            </div>
                            <h5>22/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/circulo_phoenix.png" alt="time">
                                <p>1 - 0</p>
                                <img src="assets/img/vibes.png" alt="vibes">

                            </div>
                            <h5>22/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/circulo_phoenix.png" alt="time">
                                <p>1 - 0</p>
                                <img src="assets/img/circulo_setFinal.png" alt="time">

                            </div>
                            <h5>22/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Amistoso</h4>
                            <div class="times">
                                <img src="assets/img/circulo_setFinal.png" alt="time">
                                <p>1 - 0</p>
                                <img src="assets/img/vibes.png" alt="time">

                            </div>
                            <h5>22/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/time_choppers.png" alt="time">
                                <p>2 - 1</p>
                                <img src="assets/img/time_theLast.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/circulo_setFinal.png" alt="time">
                                <p>2 - 1</p>
                                <img src="assets/img/impacto_time.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/vibes.png" alt="time">
                                <p>2 - 0</p>
                                <img src="assets/img/time_baska.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/time_trentino_volley.png" alt="time">
                                <p>2 - 1</p>
                                <img src="assets/img/time_cptms.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/time_cptms.png" alt="time">
                                <p>2 - 1</p>
                                <img src="assets/img/impacto_time.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/vibes.png" alt="time">
                                <p>2 - 0</p>
                                <img src="assets/img/time_grito_baixo.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/time_trentino_volley.png" alt="time">
                                <p>2 - 0</p>
                                <img src="assets/img/time_baska.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/vibes.png" alt="time">
                                <p>2 - 0</p>
                                <img src="assets/img/circulo_setFinal.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/circulo_setFinal.png" alt="time">
                                <p> W - O </p>
                                <img src="assets/img/time_cptms.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>

                        <div class="jogo">
                            <h4>Campeonato Efatá</h4>
                            <div class="times">
                                <img src="assets/img/time_trentino_volley.png" alt="time">
                                <p> 2 - 0 </p>
                                <img src="assets/img/vibes.png" alt="time">

                            </div>
                            <h5>29/06/2025</h5>
                            <p>Cultura Efatá</p>
                        </div>


                    </div>

                    <div class="space"></div>
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
                            <a href="https://maps.app.goo.gl/tdaki6jwBR1h8Kaj7" target="_blank">
                                <img src="assets/img/encontro_ceu.png" alt="Ceu são miguel">
                                <div>

                                    <span>CEU SÃO MIGUEL</span>
                                </div>

                            </a>
                        </div>

                        <div class="evento_esporte_cultura">
                            <a href="https://maps.app.goo.gl/DQXXSuREcPJ76DVL9" target="_blank">
                                <img src="assets/img/encontro_reverendo.png" alt="Escola reverendo tercio">
                                <div>

                                    <span>REVERENDO TERCIO</span>
                                </div>

                            </a>
                        </div>

                        <!-- <div class="evento_esporte_cultura">
                            <a href="https://maps.app.goo.gl/axJY8jmV8axrNJRQA" target="_blank">
                                <img src="assets/img/treino_parigot.png" alt="Parigot">
                                <div>

                                    <span>PARIGOT</span>
                                </div>

                            </a>
                        </div> -->

                          <div class="evento_esporte_cultura">
                            <a href="https://maps.app.goo.gl/tdaki6jwBR1h8Kaj7" target="_blank">
                                <img src="assets/img/encontro_ceu.png" alt="Ceu são miguel">
                                <div>

                                    <span>CEU SÃO MIGUEL</span>
                                </div>

                            </a>
                        </div>


                        <div class="evento_esporte_cultura">
                            <a href="https://maps.app.goo.gl/DQXXSuREcPJ76DVL9" target="_blank">
                                <img src="assets/img/encontro_reverendo.png" alt="Escola reverendo tercio">
                                <div>

                                    <span>REVERENDO TERCIO</span>
                                </div>

                            </a>
                        </div>

                        
                    </div>
                </div>
                <div class="space"></div>
                <div class="centro">
                    <a href="/esporte" class="ver_atividades">Saiba mais</a>
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
                        <a href="/esporte">
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
                        <a href="/esporte">
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
                        <a href="/esporte">
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
                    <a href="/esporte" class="ver_atividades">Veja todas as atividades esportivas</a>
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
                        <a href="/eventos">
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
                        <a href="/eventos">
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
                        <a href="/eventos">
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
                    <a href="/eventos" class="ver_atividades">Veja todas as os eventos</a>
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

                                🏐 <strong>Katiane</strong> — pedagoga, organiza treinos e campeonatos, promovendo atividades que fortalecem o aprendizado.
                                <br>

                                🏐 <strong>Fidel</strong> — assistente social, apoia a coordenação e oferece orientações sociais aos participantes.
                                <br>

                                🏐 <strong>Luan</strong> — Organização e Marketing é o responsável pela divulgação, comunicação e coordenação geral do projeto.
                                <br>

                                🏐 <strong>Allan</strong> — professor de Educação Física, responsável pelos treinos
                                técnicos.
                                <br>

                                🏐 <strong>Pastora Gislene</strong> — cuida da parte espiritual e da organização dos
                                eventos. <br>



                            </p>
                        </div>


                        <div class="space"></div>

                        <div class="sobre_nos_tel">
                            <div class="lado_a_lado">
                                <div class="ancora_sobre">
                                    <a href="/sobre">SOBRE NOS</a>
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
                                <img src="assets/img/isar_patrocinador.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Isar</h6>
                                <span> Instituto de Arte e Cultura: Promove ações culturais e apoia projetos que valorizam a arte e os talentos da comunidade.
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
                                <img src="assets/img/patrocinador_paes.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Pães e doces</h6>
                                <span>Pães e Doces: Produtos artesanais com sabor e qualidade, apoiando a comunidade local.
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
                                <img src="assets/img/patrocinador_drogaria.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Drogaria jotta</h6>
                                <span>Comprometida com a saúde e o bem-estar, a Drogaria Jotta apoia ações que promovem qualidade de vida na comunidade.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/_arenanewopen?igsh=MTB0bDZwdHEza3JsYw==" target="_blank">
                                <img src="assets/img/patrocinador_arena.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Arena new open</h6>
                                <span>Espaço dedicado ao esporte e ao entretenimento, a Arena New Open incentiva atividades que fortalecem a integração e o desenvolvimento comunitário.
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
                                <img src="assets/img/patrocinador_pequeno.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Pequeno Principe</h6>
                                <span>Instituto focado no cuidado, desenvolvimento e bem-estar infantil, promovendo ações sociais e educativas para crianças e famílias.
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
                                <img src="assets/img/patrocinador_hotelinho.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Hotelzinho</h6>
                                <span>Espaço acolhedor e seguro, especializado no cuidado e desenvolvimento de crianças, apoiando famílias com carinho e atenção.
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
                                <img src="assets/img/patrocinador_psicologa.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Cleide Barros</h6>
                                <span>Psicóloga: Atua no cuidado da saúde mental, oferecendo apoio emocional e promovendo o bem-estar psicológico da comunidade.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>


                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/tdgamesloja?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                                <img src="assets/img/patrocinador_td_games.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>TDgames</h6>
                                <span> Empresa dedicada a jogos e entretenimento digital, promovendo diversão e inovação para todas as idades.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/sitiotaiacupebaa?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                                <img src="assets/img/sitio_patrocinador.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Sitio Taiaçupeba</h6>
                                <span>Espaço de contato com a natureza que oferece lazer, eventos e experiências rurais, valorizando a cultura e o meio ambiente local.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/sitiotaiacupebaa?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                                <img src="assets/img/patrocinador_dkm.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>DKM</h6>
                                <span>Clínica especializada em cuidados dentários, oferecendo atendimento de qualidade para promover a saúde bucal e o bem-estar dos pacientes.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/sitiotaiacupebaa?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                                <img src="assets/img/patrocinador_assecoria.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Assessoria Política</h6>
                                <span>Serviço especializado em consultoria estratégica, comunicação e apoio a processos políticos, fortalecendo a gestão pública e o diálogo com a sociedade.
                                </span>
                                <div class="circulo">
                                    <img src="assets/img/seta_circulo.svg" alt="seta" class="seta_circulo">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="patrocinador_oficial">
                            <a href="https://www.instagram.com/sitiotaiacupebaa?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank">
                                <img src="assets/img/patrocinador_casadecarnes.png" alt="patrocinador">
                                <strong>PATROCINADOR</strong>
                                <h6>Casa de Carnes</h6>
                                <span> Comércio especializado em cortes frescos e de qualidade, oferecendo variedade e atendimento dedicado à comunidade local.
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
                                <a href="/matricula" class="cadastre-se">CADASTRE-SE</a>
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




    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modalMensagem" tabindex="-1" aria-labelledby="modalMensagemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMensagemLabel">Mensagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalMensagemCorpo"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Erro -->
    <div class="modal fade" id="modalErro" tabindex="-1" aria-labelledby="modalErroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalErroLabel">Erro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalErroMensagem"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>






    <?php require_once('templates/scriptGeral.php') ?>


    <?php if (!empty($_SESSION['sucesso']) || !empty($_SESSION['erro'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (!empty($_SESSION['sucesso'])): ?>
                    document.getElementById('modalMensagemCorpo').textContent = <?= json_encode($_SESSION['sucesso']); ?>;
                    var modal = new bootstrap.Modal(document.getElementById('modalMensagem'));
                    modal.show();
                <?php elseif (!empty($_SESSION['erro'])): ?>
                    document.getElementById('modalErroMensagem').textContent = <?= json_encode($_SESSION['erro']); ?>;
                    var modal = new bootstrap.Modal(document.getElementById('modalErro'));
                    modal.show();
                <?php endif; ?>
            });
        </script>
    <?php
        unset($_SESSION['sucesso'], $_SESSION['erro']);
    endif;
    ?>




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
    $(document).ready(function () {
        const links = $('#menu a');
        const currentPath = window.location.pathname;

        // Marca o link ativo
        links.removeClass('active');
        links.each(function () {
            const linkPath = $(this).attr('href');
            if (linkPath === currentPath) {
                $(this).addClass('active');
            }
        });
        links.on('click', function () {
            links.removeClass('active');
            $(this).addClass('active');
        });

        // Toggle do menu e controle do z-index da .escolha_categoria
        $('#menu-toggle').on('click', function () {
            $(this).toggleClass('open');

            if ($(this).hasClass('open')) {
                // Remove o z-index da .escolha_categoria
                $('.escolha_categoria').css('z-index', '0');
            } else {
                // Restaura o z-index padrão
                $('.escolha_categoria').css('z-index', '20');
            }
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