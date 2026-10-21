// Chat do leão: abre o balão, busca as perguntas prontas em /chat/perguntas e mostra as respostas.
// As perguntas são editadas no painel em /chatadmin.
(function () {
    var raiz = document.getElementById('leaoChat');
    if (!raiz) return;

    var botao        = document.getElementById('leaoChatBotao');
    var janela       = document.getElementById('leaoChatJanela');
    var fechar       = document.getElementById('leaoChatFechar');
    var mensagens    = document.getElementById('leaoChatMensagens');
    var convite      = document.getElementById('leaoChatConvite');
    var conviteFecha = document.getElementById('leaoChatConviteFechar');

    var perguntas = null;   // carregadas na primeira vez que o chat abre
    var iniciado  = false;

    // ---- abrir / fechar ----

    function abrir() {
        janela.hidden = false;
        botao.setAttribute('aria-expanded', 'true');
        botao.setAttribute('aria-label', 'Fechar chat do Cultura Efatá');
        esconderConvite();

        if (!iniciado) {
            iniciado = true;
            iniciarConversa();
        }
    }

    function fecharJanela() {
        janela.hidden = true;
        botao.setAttribute('aria-expanded', 'false');
        botao.setAttribute('aria-label', 'Abrir chat do Cultura Efatá');
        botao.focus();
    }

    botao.addEventListener('click', function () {
        janela.hidden ? abrir() : fecharJanela();
    });

    fechar.addEventListener('click', fecharJanela);

    document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape' && !janela.hidden) fecharJanela();
    });

    // ---- convite "Posso ajudar?" (uma vez por visita) ----

    function lerSessao(chave) {
        try { return sessionStorage.getItem(chave); } catch (e) { return null; }
    }

    function gravarSessao(chave, valor) {
        try { sessionStorage.setItem(chave, valor); } catch (e) { /* navegador sem storage */ }
    }

    function esconderConvite() {
        convite.hidden = true;
        gravarSessao('leaoConviteVisto', '1');
    }

    if (!lerSessao('leaoConviteVisto')) {
        setTimeout(function () {
            if (janela.hidden) convite.hidden = false;
        }, 4000);
    }

    conviteFecha.addEventListener('click', esconderConvite);

    // ---- conversa ----

    function rolarParaFim() {
        mensagens.scrollTop = mensagens.scrollHeight;
    }

    // Texto entra sempre por textContent (nunca como HTML)
    function balao(texto, quem) {
        var div = document.createElement('div');
        div.className = 'leao-msg leao-msg-' + quem;
        div.textContent = texto;
        mensagens.appendChild(div);
        rolarParaFim();
        return div;
    }

    function digitando() {
        var div = document.createElement('div');
        div.className = 'leao-msg leao-msg-bot leao-digitando';
        div.innerHTML = '<span></span><span></span><span></span>';
        mensagens.appendChild(div);
        rolarParaFim();
        return div;
    }

    // Mostra o "digitando..." por um instante e depois a resposta
    function responder(montar) {
        var pontos = digitando();
        setTimeout(function () {
            pontos.remove();
            montar();
            rolarParaFim();
        }, 650);
    }

    function mostrarOpcoes() {
        if (!perguntas || perguntas.length === 0) return;

        var grupo = document.createElement('div');
        grupo.className = 'leao-opcoes';

        perguntas.forEach(function (p) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'leao-opcao';
            b.textContent = p.pergunta_chat;
            b.addEventListener('click', function () {
                grupo.remove();
                escolher(p);
            });
            grupo.appendChild(b);
        });

        mensagens.appendChild(grupo);
        rolarParaFim();
    }

    function escolher(p) {
        balao(p.pergunta_chat, 'pessoa');

        responder(function () {
            var msg = balao(p.resposta_chat, 'bot');

            if (p.url_link_chat && p.texto_link_chat) {
                var link = document.createElement('a');
                link.className = 'leao-msg-link';
                link.href = p.url_link_chat;
                link.textContent = p.texto_link_chat + ' →';
                if (/^https?:\/\//i.test(p.url_link_chat)) {
                    link.target = '_blank';
                    link.rel = 'noopener';
                }
                msg.appendChild(document.createElement('br'));
                msg.appendChild(link);
            }

            responder(function () {
                balao('Posso ajudar em mais alguma coisa?', 'bot');
                mostrarOpcoes();
            });
        });
    }

    function iniciarConversa() {
        var pontos = digitando();

        fetch('/chat/perguntas', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.ok ? r.json() : { perguntas: [] }; })
            .catch(function () { return { perguntas: [] }; })
            .then(function (dados) {
                perguntas = dados.perguntas || [];
                pontos.remove();

                balao('Olá! Eu sou o Leão do Efatá 🦁', 'bot');

                if (perguntas.length > 0) {
                    balao('Escolha uma pergunta abaixo ou fale com a nossa equipe no WhatsApp.', 'bot');
                    mostrarOpcoes();
                } else {
                    balao('Fale com a nossa equipe pelo WhatsApp, é só tocar no botão abaixo.', 'bot');
                }
            });
    }
})();
