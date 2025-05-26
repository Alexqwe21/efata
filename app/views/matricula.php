<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="shortcut icon" href="assets/img/Logo_Cultura.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/js/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />


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
                <!-- From Uiverse.io by Smit-Prajapati -->
                <div class="container">
                    <div class="heading">Ficha de Matrícula - Aula de Vôlei</div>
                    <form action="MatriculaController.php?acao=salvar" class="form" method="POST">



                        <input required class="input" type="text" name="nome" placeholder="Nome Completo">

                        <input required class="input" type="text" name="cep" id="cep" placeholder="CEP">
                        <small id="erro-cep">CEP inválido ou não encontrado.</small>


                        <input required class="input" type="text" name="endereco" placeholder="Endereço">



                        <input required class="input" type="text" name="bairro" placeholder="Bairro">

                        <input required class="input" type="text" name="cidade" placeholder="Cidade">

                        <input required class="input" type="text" name="estado" placeholder="Estado">

                        <input required class="input" type="text" name="pais" placeholder="País">



                        <input required class="input" type="text" name="telefone" id="telefone" placeholder="Telefone">

                        <input required class="input" type="text" name="telefone_emergencia" id="telefone_emergencia"
                            placeholder="Telefone de Emergência">

                        <input required class="input" type="text" name="cpf" id="cpf" placeholder="CPF">

                        <input required class="input" type="text" name="rg" id="rg" placeholder="RG">

                        <div class="space_formulario">
                            <label class="input-label">Data de Nascimento (DD/MM/AAAA)</label>
                        </div>
                        <input required class="input" type="text" name="data_nascimento" id="data_nascimento"
                            placeholder="Ex: 25/12/2010" maxlength="10">


                        <input required class="input" type="email" name="email" placeholder="E-mail">

                        <input class="input" type="text" name="problemas_saude"
                            placeholder="Problemas de Saúde (se houver)">


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
                            <label class="input-label">Nascimento do Menor (DD/MM/AAAA)</label>
                        </div>
                        <input class="input" type="text" name="menor_nascimento" id="menor_nascimento"
                            placeholder="Ex: 25/12/2010" maxlength="10" required>

                        <input class="input" type="text" name="atividade" value="Aula de Vôlei" readonly>

                        <button class="login-button" type="submit">Enviar Matrícula</button>
                    </form>

                    <span class="agreement"><a href="/home">Saiba mais sobre o projeto</a></span>
                </div>


            </article>
        </section>








    </main>








    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/lottie-web@latest/build/player/lottie.min.js"></script>
    <!-- jQuery (obrigatório) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slick JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>










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


    <script>
        // Máscara para data DD/MM/AAAA
        const menorNascimento = document.getElementById('menor_nascimento');
        menorNascimento.addEventListener('input', function () {
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
            input.addEventListener('input', function () {
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
            input.addEventListener('input', function () {
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
            input.addEventListener('input', function () {
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
        cep.addEventListener('input', function () {
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
            input.addEventListener('input', function () {
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

        cepInput.addEventListener('blur', function () {
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









</body>

</html>