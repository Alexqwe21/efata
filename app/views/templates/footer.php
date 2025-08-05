<div class="site">
    <div class="lado_a_lado">


        <div class="columns">
            <div class="logo_footer">
                <a href="/home"><img src="assets/img/Logo_Cultura.png" alt="logo_footer"></a>


            </div>
            <div class="mapa">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29270.58488301266!2d-46.47978443366779!3d-23.50288005240974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce615e5ddfd0a1%3A0x7c4c710f5c0c5a9f!2sS%C3%A3o%20Miguel%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1750011980226!5m2!1spt-BR!2sbr" width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="columns">

            <div class="entre_em_contato">
                <p>Entre Em Contato</p>
                <div class="telefone">
                    <img src="assets/img/telefone_footer.svg" alt="telefone">
                    <span>11 944748900</span>
                </div>
            </div>
            <nav>
                <ul id="menu">
                    <li><a href="/home" class="active">INICIO</a></li>
                    <li><a href="/esporte">ESPORTE</a></li>
                    <li><a href="/cultura">CULTURA</a></li>
                    <li><a href="/eventos">EVENTOS</a></li>
                    <li><a href="/sobre">SOBRE</a></li>
                </ul>
            </nav>

        </div>

        <div class="columns" style="width: 30%;">

            <div class="Newsletter">
                <h2>Newsletter</h2>
                <div>
                    <hr>
                </div>

                <p>Receba as ultimas atualizações sobre novos eventos e atividades.</p>
            </div>

            <form id="formNewsletter">
                <div class="email_Newsletter">
                    <label for="email"></label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <button type="submit" id="btnNewsletter">
                        <span id="iconeBotao">
                            <img src="assets/img/buttoon_sumit.svg" alt="Enviar">
                        </span>
                    </button>
                </div>
                <div id="retornoNewsletter" style="margin-top: 10px;"></div>
            </form>


            <div id="retornoNewsletter" style="margin-top: 10px; font-weight: bold;"></div>


            <div class="siga_agente">
                <span>SIGA A GENTE NAS REDES SOCIAIS</span>
            </div>

            <div class="redes_sociais_footer">
                <div>
                    <a href="https://wa.link/rbfxje" target="_blank"><img src="assets/img/wpp_topo.svg" alt="whatsapp"></a>
                </div>

                <div>
                    <a href="https://www.instagram.com/culturaefata?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank"><img src="assets/img/instagram_topo.svg" alt="instagram"></a>
                </div>

                <a href="#" onclick="alert('O link para o Facebook ainda não está disponível. Em breve!'); return false;">
                    <img src="assets/img/facebook_topo.svg" alt="facebook">
                </a>

            </div>


        </div>

    </div>
    <div class="space">

    </div>
    <div class="direitos">
        <strong>Todos direitos reservados</strong>
    </div>
</div>


<script>
    document.getElementById('formNewsletter').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        const retorno = document.getElementById('retornoNewsletter');
        const icone = document.getElementById('iconeBotao');

        // Mostra spinner CSS
        icone.innerHTML = '<span class="spinner"></span>';

        fetch('newsletter/enviarNewsletter', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                // Restaura o ícone padrão
                icone.innerHTML = '<img src="assets/img/buttoon_sumit.svg" alt="Enviar">';

                retorno.textContent = res.mensagem;
                retorno.style.color = res.status === 'sucesso' ? 'green' : 'red';

                if (res.status === 'sucesso') {
                    form.reset();
                }
            })
            .catch(() => {
                icone.innerHTML = '<img src="assets/img/buttoon_sumit.svg" alt="Enviar">';
                retorno.textContent = '❌ Erro ao enviar requisição.';
                retorno.style.color = 'red';
            });
    });
</script>

