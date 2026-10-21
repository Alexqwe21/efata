<!-- Chat do leão: balão flutuante com perguntas prontas (editadas em /chatadmin) + WhatsApp -->
<link rel="stylesheet" href="/assets/css/chat_leao.css?v=<?= filemtime(__DIR__ . '/../../../assets/css/chat_leao.css'); ?>">

<div class="leao-chat" id="leaoChat">

    <div class="leao-chat-janela" id="leaoChatJanela" role="dialog" aria-label="Chat do Cultura Efatá" hidden>
        <div class="leao-chat-topo">
            <img src="/assets/img/leao_chat.png" alt="" class="leao-chat-avatar">
            <div class="leao-chat-titulo">
                <strong>Leão do Efatá</strong>
                <span>Tire suas dúvidas</span>
            </div>
            <button type="button" class="leao-chat-fechar" id="leaoChatFechar" aria-label="Fechar chat">&times;</button>
        </div>

        <div class="leao-chat-mensagens" id="leaoChatMensagens" aria-live="polite"></div>

        <a class="leao-chat-whatsapp" target="_blank" rel="noopener"
            href="https://wa.me/5511914754581?text=<?= rawurlencode('Olá! Vim pelo site do Cultura Efatá e gostaria de mais informações.') ?>">
            <img src="/assets/img/wpp_topo.svg" alt="">
            Falar com a equipe no WhatsApp
        </a>
    </div>

    <div class="leao-chat-convite" id="leaoChatConvite" hidden>
        Posso ajudar? 🦁
        <button type="button" id="leaoChatConviteFechar" aria-label="Dispensar">&times;</button>
    </div>

    <button type="button" class="leao-chat-botao" id="leaoChatBotao" aria-expanded="false" aria-controls="leaoChatJanela"
        aria-label="Abrir chat do Cultura Efatá">
        <img src="/assets/img/leao_chat.png" alt="">
    </button>
</div>

<script src="/assets/js/chat_leao.js?v=<?= filemtime(__DIR__ . '/../../../assets/js/chat_leao.js'); ?>" defer></script>
