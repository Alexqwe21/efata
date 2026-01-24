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
        <a href="https://api.whatsapp.com/send?phone=5511912345494" target="_blank" class="whatsapp-fixo"
            aria-label="Fale conosco pelo WhatsApp">
            <img src="assets/img/whatsapp_Flutuante.svg" alt="WhatsApp"/>
        </a>


        <section class="matricula_formulario">
            <article class="site">



                <!-- From Uiverse.io by Smit-Prajapati -->
                <div class="container">
                    <div class="heading">Ficha de Matrícula - Aula de Vôlei</div>
                    <form action="matricula/salvar" class="form" method="POST">

                        <!-- Dados Pessoais -->
                        <input required class="input" type="text" name="nome" placeholder="Nome Completo">

                        <input required class="input" type="text" name="cep" id="cep" placeholder="CEP">
                        <small id="erro-cep" style="color:red; display:none;">CEP inválido ou não encontrado.</small>

                        <input required class="input" type="text" name="endereco" placeholder="Endereço">
                        <input required class="input" type="text" name="bairro" placeholder="Bairro">
                        <input required class="input" type="text" name="cidade" placeholder="Cidade">
                        <input required class="input" type="text" name="estado" placeholder="UF" maxlength="2"
                            style="text-transform:uppercase ;">
                        <input required class="input" type="text" name="pais" placeholder="País">

                        <!-- Campos de telefone -->
                        <div class="campo_telefone">
                            <input required class="input" type="text" name="telefone" id="telefone" placeholder="Telefone">
                            <span id="erroTelefone" class="mensagem-erro" style="display: none; color: red;">Telefone inválido. Use DDD + número (11 dígitos).</span>
                        </div>

                        <div class="campo_telefone">
                            <input required class="input" type="text" name="telefone_emergencia" id="telefone_emergencia" placeholder="Telefone de Emergência">
                            <span id="erroTelefoneEmergencia" class="mensagem-erro" style="display: none; color: red;">Telefone de emergência inválido.</span>
                        </div>

                        <input required class="input" type="text" name="cpf" id="cpf" placeholder="CPF">
                        <small id="cpf-erro" style="color: red; display: none;"></small>

                        <input class="input" type="text" name="rg" id="rg" placeholder="RG">

                        <div class="space_formulario">
                            <label class="input-label">Data de Nascimento (DD/MM/AAAA)</label>
                        </div>
                        <input required class="input" type="text" name="data_nascimento" id="data_nascimento"
                            placeholder="Ex: 25/12/2010" maxlength="10">

                        <input required class="input" type="email" name="email" placeholder="E-mail">

                        <!-- Problemas de saúde simples -->
                        <input class="input" type="text" name="problemas_saude"
                            placeholder="Problemas de Saúde (se houver)">

                        <!-- Dados do Responsável -->
                        <div class="space_formulario">
                            <h4>Dados do Responsável (se menor de idade)</h4>
                        </div>
                        <input class="input" type="text" name="responsavel_nome" placeholder="Nome do Responsável">
                        <input class="input" type="text" name="responsavel_rg" id="responsavel_rg"
                            placeholder="RG do Responsável">
                        <input class="input" type="text" name="responsavel_cpf" id="responsavel_cpf"
                            placeholder="CPF do Responsável">
                        <input class="input" type="text" name="responsavel_qualidade"
                            placeholder="Qualidade (Pai/Mãe/Tutor)">
                        <input class="input" type="text" name="menor_nome" placeholder="Nome do Menor">
                        <input class="input" type="text" name="menor_rg" id="menor_rg" placeholder="RG do Menor">

                        <div class="space_formulario">
                            <label class="input-label">Data nascimento Responsável (DD/MM/AAAA)</label>
                        </div>
                        <input class="input" type="text" name="menor_nascimento" id="menor_nascimento"
                            placeholder="Ex: 25/12/2010" maxlength="10">

                        <input class="input" type="text" name="atividade" value="Aula de Vôlei" readonly>

                        <!-- Questionário de Avaliação de Saúde -->
                        <div class="space_formulario_saude">
                            <h4>Questionário de Avaliação de Saúde</h4>
                        </div>

                        <div class="pergunta">
                            <label class="bold">1. Você possui ou já teve algum dos seguintes problemas de
                                saúde?</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Doença cardíaca">
                                Doença cardíaca</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Pressão alta"> Pressão
                                alta</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Diabetes">
                                Diabetes</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Asma"> Asma</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Problemas articulares">
                                Problemas articulares</label><br>
                            <label><input type="checkbox" name="saude_problemas[]" value="Epilepsia">
                                Epilepsia</label><br>

                            <label><input type="checkbox" name="saude_problemas[]" value="Nenhum"> Não possuo problemas
                                de saúde</label><br>



                            <label>Outras condições médicas: <input type="text" class="input" placeholder="Digite aqui"
                                    name="saude_outros"></label>
                        </div>

                        <div class="pergunta">
                            <label class="bold">2. Está fazendo uso de medicamentos atualmente?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="medicamentos" value="Sim"> Sim</label>
                                <label><input type="radio" name="medicamentos" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="medicamentos_quais" placeholder="Se Sim Qual(is)?">
                        </div>

                        <div class="pergunta">
                            <label class="bold">3. Já sofreu alguma lesão praticando esportes?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="lesao" value="Sim"> Sim</label>
                                <label><input type="radio" name="lesao" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="lesao_qual" placeholder="Se Sim Qual foi a lesão?">
                        </div>

                        <div class="pergunta">
                            <label class="bold">4. Realiza acompanhamento médico regular?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="acompanhamento" value="Sim"> Sim</label>
                                <label><input type="radio" name="acompanhamento" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="acompanhamento_especialidade"
                                placeholder="Se Sim Qual Especialidade">
                        </div>

                        <div class="pergunta">
                            <label class="bold">5. Possui alergias?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="alergias" value="Sim"> Sim</label>
                                <label><input type="radio" name="alergias" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="alergias_quais" placeholder="Quais?">
                        </div>

                        <div class="pergunta">
                            <label class="bold">6. Pratica atividades físicas regularmente?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="atividade_fisica" value="Sim"> Sim</label>
                                <label><input type="radio" name="atividade_fisica" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="atividade_fisica_quais" placeholder="Quais?">
                        </div>

                        <div class="pergunta">
                            <label class="bold">7. Com que frequência você dorme pelo menos 7 horas por
                                noite?</label><br>
                            <label><input type="radio" name="sono" value="Sempre"> Sempre</label>
                            <label><input type="radio" name="sono" value="Às vezes"> Às vezes</label>
                            <label><input type="radio" name="sono" value="Raramente"> Raramente</label>
                        </div>

                        <div class="pergunta">
                            <label class="bold">8. Alimenta-se bem e com regularidade?</label><br>
                            <label><input type="radio" name="alimentacao" value="Sim"> Sim</label>
                            <label><input type="radio" name="alimentacao" value="Não"> Não</label>
                        </div>

                        <div class="pergunta">
                            <label class="bold">9. Está apto(a) para participar de atividades físicas
                                intensas?</label><br>
                            <label><input type="radio" name="apto" value="Sim"> Sim</label>
                            <label><input type="radio" name="apto" value="Não"> Não</label>
                            <label><input type="radio" name="apto" value="Não sei"> Não sei / Preciso de avaliação
                                médica</label>
                        </div>

                        <div class="pergunta">
                            <label class="bold">10. Já realizou avaliação médica nos últimos 12 meses?</label><br>
                            <div class="radio_lado_a_lado">
                                <label><input type="radio" name="avaliacao_medica" value="Sim"> Sim</label>
                                <label><input type="radio" name="avaliacao_medica" value="Não"> Não</label>
                            </div>
                            <input class="input" type="text" name="avaliacao_medica_quem" placeholder="Médico">
                        </div>

                        <!-- Termo de Responsabilidade -->
                        <div class="space_formulario_saude">
                            <h4>Termo de Responsabilidade</h4>
                        </div>

                        <p>Declaro que as informações acima são verdadeiras e me responsabilizo por qualquer omissão. Autorizo a participação no projeto de vôlei e reconheço que é recomendada a realização de avaliação médica antes do início das atividades. Também autorizo o uso de minha imagem, vídeos e de textos por mim fornecidos para fins de divulgação e comunicação relacionados ao projeto.</p>

                        <button class="login-button" type="submit">Enviar Matrícula</button>
                        <a href="/home" class="login-button" style="display: flex; justify-content: center; text-decoration: none;">VOLTAR</a>
                    </form>
                    <!-- Modal de mensagem -->

                    <span class="agreement"><a href="/home">Saiba mais sobre o projeto</a></span>
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
        function aplicarMascaraTelefone(input) {
            input.addEventListener('input', function() {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 11) valor = valor.slice(0, 11);

                if (valor.length > 2 && valor.length <= 7) {
                    valor = `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
                } else if (valor.length > 7) {
                    valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7)}`;
                }

                input.value = valor;
            });
        }

        function validarTelefone(input, erroSpan) {
            input.addEventListener('blur', function() {
                const apenasNumeros = input.value.replace(/\D/g, '');
                if (apenasNumeros.length !== 11) {
                    erroSpan.style.display = 'inline';
                    input.style.borderColor = 'red';
                } else {
                    erroSpan.style.display = 'none';
                    input.style.borderColor = '';
                }
            });
        }

        // Aplicar em ambos os campos
        const telefone = document.getElementById('telefone');
        const telefoneEmergencia = document.getElementById('telefone_emergencia');
        const erroTelefone = document.getElementById('erroTelefone');
        const erroTelefoneEmergencia = document.getElementById('erroTelefoneEmergencia');

        aplicarMascaraTelefone(telefone);
        aplicarMascaraTelefone(telefoneEmergencia);

        validarTelefone(telefone, erroTelefone);
        validarTelefone(telefoneEmergencia, erroTelefoneEmergencia);
    </script>


    <script>
        // Máscara para data DD/MM/AAAA
        const menorNascimento = document.getElementById('menor_nascimento');
        menorNascimento.addEventListener('input', function() {
            let valor = this.value.replace(/\D/g, '');
            if (valor.length > 8) valor = valor.slice(0, 8);
            if (valor.length >= 5) {
                this.value = valor.slice(0, 2) + '/' + valor.slice(2, 4) + '/' + valor.slice(4);
            } else if (valor.length >= 3) {
                this.value = valor.slice(0, 2) + '/' + valor.slice(2);
            } else {
                this.value = valor;
            }
        });

        // Máscara para telefone: (00) 00000-0000
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
        mascaraTelefone(document.getElementById('telefone'));
        mascaraTelefone(document.getElementById('telefone_emergencia'));

        // Máscara para CPF: 000.000.000-00
        function mascaraCPF(input) {
            input.addEventListener('input', function() {
                let valor = input.value.replace(/\D/g, '');
                if (valor.length > 11) valor = valor.slice(0, 11);
                if (valor.length > 9) {
                    input.value = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6, 9) + '-' + valor.slice(9);
                } else if (valor.length > 6) {
                    input.value = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6);
                } else if (valor.length > 3) {
                    input.value = valor.slice(0, 3) + '.' + valor.slice(3);
                } else {
                    input.value = valor;
                }
            });
        }
        mascaraCPF(document.getElementById('cpf'));
        mascaraCPF(document.getElementById('responsavel_cpf'));

        // Máscara para RG: 00.000.000-0
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
        mascaraRG(document.getElementById('rg'));
        mascaraRG(document.getElementById('responsavel_rg'));
        mascaraRG(document.getElementById('menor_rg'));

        // Máscara para CEP: 00000-000
        const cep = document.getElementById('cep');
        cep.addEventListener('input', function() {
            let valor = this.value.replace(/\D/g, '');
            if (valor.length > 8) valor = valor.slice(0, 8);
            if (valor.length > 5) {
                this.value = valor.slice(0, 5) + '-' + valor.slice(5);
            } else {
                this.value = valor;
            }
        });

        // Máscara para datas: DD/MM/AAAA
        function mascaraData(input) {
            input.addEventListener('input', function() {
                let valor = this.value.replace(/\D/g, '');
                if (valor.length > 8) valor = valor.slice(0, 8);
                if (valor.length >= 5) {
                    this.value = valor.slice(0, 2) + '/' + valor.slice(2, 4) + '/' + valor.slice(4);
                } else if (valor.length >= 3) {
                    this.value = valor.slice(0, 2) + '/' + valor.slice(2);
                } else {
                    this.value = valor;
                }
            });
        }

        mascaraData(document.getElementById('menor_nascimento'));
        mascaraData(document.getElementById('data_nascimento'));
    </script>


    <script>
        const cepInput = document.getElementById('cep');
        const erroCep = document.getElementById('erro-cep');

        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            erroCep.style.display = 'none'; // Sempre oculta antes

            if (cep.length !== 8) {
                erroCep.textContent = 'CEP inválido. Deve conter 8 dígitos.';
                erroCep.style.display = 'block';
                return;
            }

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        erroCep.textContent = 'CEP não encontrado.';
                        erroCep.style.display = 'block';
                        return;
                    }

                    // Preenche os campos
                    document.querySelector('input[name="endereco"]').value = data.logradouro || '';
                    document.querySelector('input[name="bairro"]').value = data.bairro || '';
                    document.querySelector('input[name="cidade"]').value = data.localidade || '';
                    document.querySelector('input[name="estado"]').value = data.uf || '';
                    document.querySelector('input[name="pais"]').value = 'Brasil';
                })
                .catch(() => {
                    erroCep.textContent = 'Erro ao consultar o CEP.';
                    erroCep.style.display = 'block';
                });
        });
    </script>


    <script>
        document.querySelector('.form').addEventListener('submit', function(e) {

            // Função para mostrar o modal com a mensagem de erro usando Bootstrap
            function mostrarModal(msg) {
                const modalMensagem = document.getElementById('modalErroMensagem');
                modalMensagem.textContent = msg;

                // Criar instancia do modal Bootstrap e mostrar
                const modalBootstrap = new bootstrap.Modal(document.getElementById('modalErro'));
                modalBootstrap.show();
            }

            function isRadioChecked(name) {
                return document.querySelector('input[name="' + name + '"]:checked') !== null;
            }

            // Validação checkbox saude_problemas
            const checkboxes = document.querySelectorAll('input[name="saude_problemas[]"]');
            let peloMenosUmMarcado = false;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    peloMenosUmMarcado = true;
                }
            });
            if (!peloMenosUmMarcado) {
                e.preventDefault();
                mostrarModal('Por favor, marque pelo menos um problema de saúde ou indique que não possui.');
                return;
            }

            // Validação radios obrigatórios
            const radiosToCheck = [
                'medicamentos',
                'lesao',
                'acompanhamento',
                'alergias',
                'atividade_fisica',
                'sono',
                'alimentacao',
                'apto',
                'avaliacao_medica'
            ];

            for (let i = 0; i < radiosToCheck.length; i++) {
                if (!isRadioChecked(radiosToCheck[i])) {
                    e.preventDefault();
                    // Melhor deixar a mensagem genérica ou com nome amigável
                    const nomeAmigavel = radiosToCheck[i].replace(/_/g, ' ');
                    mostrarModal('Por favor, responda a pergunta sobre "' + nomeAmigavel + '".');
                    return;
                }
            }

            // Não valida os inputs condicionais porque não são obrigatórios

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            const erroSpan = document.getElementById('cpf-erro');

            cpfInput.addEventListener('blur', function() {
                const cpf = cpfInput.value.trim();
                if (cpf.length === 0) return;

                fetch('/matricula/verificarCpf', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'cpf=' + encodeURIComponent(cpf)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.existe) {
                            erroSpan.textContent = 'Este CPF já está cadastrado.';
                            erroSpan.style.display = 'inline';
                            cpfInput.classList.add('is-invalid');
                        } else {
                            erroSpan.style.display = 'none';
                            cpfInput.classList.remove('is-invalid');
                        }
                    });
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