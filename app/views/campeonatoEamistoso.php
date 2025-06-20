<style>
    h4 {
        margin: 15px 0 !important;
    }
</style>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="assets/img/Logo_Cultura.png" type="image/x-icon" />

    <!-- Reset CSS -->
    <link rel="stylesheet" href="/assets/css/reset.css" />

    <!-- Seu CSS -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time(); ?>">

    <!-- Slick Carousel CSS (escolha local OU CDN, não os dois) -->
    <link rel="stylesheet" href="assets/js/slick/slick.css" />
    <link rel="stylesheet" href="assets/js/slick/slick-theme.css" />
    <!-- OU -->
    <!--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    -->

    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <title>Cultura Efatá</title>
</head>


<body>
    <button id="back-to-top" title="Voltar para o Topo"><img src="assets/img/seta_para_cima.svg" alt="seta"></button>

    <div class="preloader" id="preloader">
        <div id="lottie-container" style="width: 350px; height: 350px;"></div>
    </div>



    <main>
        <a href="https://wa.me/5511999999999" target="_blank" class="whatsapp-fixo"
            aria-label="Fale conosco pelo WhatsApp">
            <img src="assets/img/whatsapp_Flutuante.svg" alt="WhatsApp" />
        </a>


        <section class="matricula_formulario">
            <article class="site">



                <div class="container">
                    <div class="heading">Cadastro de Time - Campeonato / Amistoso</div>
                    <form action="campeonatoEamistoso/salvarTimeEJogadores" class="form" method="POST">
                        <!-- Nome do time -->
                        <input required class="input" type="text" name="nome_time" placeholder="Nome da Equipe / Time">
                        <input required class="input" type="email" name="email_campeonato" placeholder="Email do Time">

                        <hr>
                        <h3>Participação de Jogadores / Campeonato ou Amistoso – Cultura Efatá</h3>

                        <!-- Jogadores obrigatórios (1 a 6) -->
                        <!-- Você pode usar um loop no PHP futuramente -->
                        <!-- Jogador 1 -->
                        <div class="jogador">
                            <h4>Jogador 1</h4>
                            <input required class="input" type="text" name="jogadores[0][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[0][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[0][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select class="input" name="jogadores[0][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[0][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>


                        <!-- Jogador 2 -->
                        <div class="jogador">
                            <h4>Jogador 2</h4>
                            <input required class="input" type="text" name="jogadores[1][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[1][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[1][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select class="input" name="jogadores[1][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[1][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>

                        <!-- Jogador 3 -->
                        <div class="jogador">
                            <h4>Jogador 3</h4>
                            <input required class="input" type="text" name="jogadores[2][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[2][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[2][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select class="input" name="jogadores[2][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[2][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>

                        <!-- Jogador 4 -->
                        <div class="jogador">
                            <h4>Jogador 4</h4>
                            <input required class="input" type="text" name="jogadores[3][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[3][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[3][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select class="input" name="jogadores[3][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[3][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>

                        <!-- Jogador 5 -->
                        <div class="jogador">
                            <h4>Jogador 5</h4>
                            <input required class="input" type="text" name="jogadores[4][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[4][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[4][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select required class="input" name="jogadores[4][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[4][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>

                        <!-- Jogador 6 -->
                        <div class="jogador">
                            <h4>Jogador 6</h4>
                            <input required class="input" type="text" name="jogadores[5][nome_completo]" placeholder="Nome Completo">
                            <input class="input" type="text" name="jogadores[5][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>
                            <input required class="input" type="text" name="jogadores[5][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>
                            <select class="input" name="jogadores[5][posicao]" required>
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>
                            <input class="input" type="text" name="jogadores[5][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>
                        <!-- Jogador 7 (opcional) -->
                        <div class="jogador">
                            <h4>Jogador 7 (opcional)</h4>
                            <input class="input" type="text" name="jogadores[6][nome_completo]" placeholder="Nome Completo">

                            <input class="input" type="text" name="jogadores[6][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>

                            <input class="input" type="text" name="jogadores[6][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>

                            <select class="input" name="jogadores[6][posicao]">
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>

                            <input class="input" type="text" name="jogadores[6][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>

                        <!-- Jogador 8 (opcional) -->
                        <div class="jogador">
                            <h4>Jogador 8 (opcional)</h4>
                            <input class="input" type="text" name="jogadores[7][nome_completo]" placeholder="Nome Completo">

                            <input class="input" type="text" name="jogadores[7][rg]" placeholder="RG">
                            <span class="erro" style="display:none;color:red;font-size:12px;">RG inválido</span>

                            <input class="input" type="text" name="jogadores[7][data_nascimento]" placeholder="Data de Nascimento (DD/MM/AAAA)">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Data inválida</span>

                            <select class="input" name="jogadores[7][posicao]">
                                <option value="" disabled selected>Selecione a Posição no Vôlei</option>
                                <option value="levantador">Levantador</option>
                                <option value="ponteiro">Ponteiro</option>
                                <option value="oposto">Oposto</option>
                                <option value="central">Central</option>
                                <option value="libero">Líbero</option>
                            </select>

                            <input class="input" type="text" name="jogadores[7][telefone]" placeholder="Telefone">
                            <span class="erro" style="display:none;color:red;font-size:12px;">Telefone inválido</span>
                        </div>



                        <!-- Botões -->
                        <button class="login-button" type="submit">Cadastrar Time</button>
                        <a href="/home" class="login-button" style="display: flex; justify-content: center; text-decoration: none;">VOLTAR</

                                </div>


            </article>
        </section>



    </main>

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


    <!-- Modal de erro -->
    <div class="modal fade" id="modalErro" tabindex="-1" aria-labelledby="modalErroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalErroLabel">Erro de validação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalErroMensagem">
                    <!-- Mensagem de erro será inserida aqui -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>




    <!-- jQuery apenas uma vez -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Migrate se precisar de compatibilidade (opcional) -->
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>

    <!-- Slick Carousel -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Fancybox -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <!-- Bootstrap Bundle JS (inclui Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lottie -->
    <script src="https://unpkg.com/lottie-web@latest/build/player/lottie.min.js"></script>




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

    <script>
        // Funções máscara:
        function mascaraRG(input) {
            input.addEventListener('input', function() {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 9) valor = valor.slice(0, 9);
                if (valor.length > 7) {
                    input.value = valor.slice(0, 2) + '.' + valor.slice(2, 5) + '.' + valor.slice(5, 8) + '-' + valor.slice(8);
                } else if (valor.length > 4) {
                    input.value = valor.slice(0, 2) + '.' + valor.slice(2, 5) + '.' + valor.slice(5);
                } else if (valor.length > 2) {
                    input.value = valor.slice(0, 2) + '.' + valor.slice(2);
                } else {
                    input.value = valor;
                }
            });
        }

        function mascaraData(input) {
            input.addEventListener('input', function() {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 8) valor = valor.slice(0, 8);
                if (valor.length >= 5) {
                    input.value = valor.slice(0, 2) + '/' + valor.slice(2, 4) + '/' + valor.slice(4);
                } else if (valor.length >= 3) {
                    input.value = valor.slice(0, 2) + '/' + valor.slice(2);
                } else {
                    input.value = valor;
                }
            });
        }

        function mascaraTelefone(input) {
            input.addEventListener('input', function() {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 11) valor = valor.slice(0, 11);
                if (valor.length > 6) {
                    input.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7);
                } else if (valor.length > 2) {
                    input.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
                } else {
                    input.value = valor;
                }
            });
        }

        // Validações:
        function validarRG(input, erroSpan) {
            input.addEventListener('blur', function() {
                const valor = input.value.replace(/\D/g, '');
                if (valor.length !== 9) {
                    erroSpan.style.display = 'inline';
                    input.style.borderColor = 'red';
                } else {
                    erroSpan.style.display = 'none';
                    input.style.borderColor = '';
                }
            });
        }

        function validarData(input, erroSpan) {
            input.addEventListener('blur', function() {
                const valor = input.value;
                // Regex simples DD/MM/AAAA
                const regexData = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/;
                if (!regexData.test(valor)) {
                    erroSpan.style.display = 'inline';
                    input.style.borderColor = 'red';
                } else {
                    erroSpan.style.display = 'none';
                    input.style.borderColor = '';
                }
            });
        }

        function validarTelefone(input, erroSpan) {
            input.addEventListener('blur', function() {
                const valor = input.value.replace(/\D/g, '');
                if (valor.length !== 11) {
                    erroSpan.style.display = 'inline';
                    input.style.borderColor = 'red';
                } else {
                    erroSpan.style.display = 'none';
                    input.style.borderColor = '';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const jogadores = document.querySelectorAll('.jogador');

            jogadores.forEach(function(jogador) {
                const inputRG = jogador.querySelector('input[name$="[rg]"]');
                const erroRG = inputRG?.nextElementSibling;

                const inputData = jogador.querySelector('input[name$="[data_nascimento]"]');
                const erroData = inputData?.nextElementSibling;

                const inputTelefone = jogador.querySelector('input[name$="[telefone]"]');
                const erroTelefone = inputTelefone?.nextElementSibling;

                if (inputRG && erroRG) {
                    mascaraRG(inputRG);
                    validarRG(inputRG, erroRG);
                }

                if (inputData && erroData) {
                    mascaraData(inputData);
                    validarData(inputData, erroData);
                }

                if (inputTelefone && erroTelefone) {
                    mascaraTelefone(inputTelefone);
                    validarTelefone(inputTelefone, erroTelefone);
                }
            });
        });
    </script>












    <?php if (!empty($_SESSION['sucesso']) || !empty($_SESSION['erro'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var mensagem = '';

                <?php if (!empty($_SESSION['sucesso'])): ?>
                    mensagem = <?= json_encode($_SESSION['sucesso']); ?>;
                <?php elseif (!empty($_SESSION['erro'])): ?>
                    mensagem = <?= json_encode($_SESSION['erro']); ?>;
                <?php endif; ?>

                document.getElementById('modalMensagemCorpo').textContent = mensagem;

                var modal = new bootstrap.Modal(document.getElementById('modalMensagem'));
                modal.show();
            });
        </script>
    <?php
        unset($_SESSION['sucesso'], $_SESSION['erro']);
    endif;
    ?>





</body>

</html>