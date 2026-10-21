-- Chat do leão: perguntas e respostas prontas do balão flutuante do site.
-- Rodar uma vez no phpMyAdmin (banco do site). Depois é só editar pelo painel em /chatadmin.

CREATE TABLE IF NOT EXISTS `tbl_chat_perguntas` (
  `id_pergunta`     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pergunta_chat`   VARCHAR(150) NOT NULL,
  `resposta_chat`   TEXT NOT NULL,
  `texto_link_chat` VARCHAR(60)  NULL DEFAULT NULL,   -- texto do botão abaixo da resposta (opcional)
  `url_link_chat`   VARCHAR(255) NULL DEFAULT NULL,   -- para onde o botão leva (ex: /matricula)
  `ordem_chat`      INT NOT NULL DEFAULT 0,           -- menor aparece primeiro
  `ativo_chat`      TINYINT(1) NOT NULL DEFAULT 1,
  `criado_em_chat`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Perguntas iniciais (ajuste os textos pelo painel)
INSERT INTO `tbl_chat_perguntas`
  (`pergunta_chat`, `resposta_chat`, `texto_link_chat`, `url_link_chat`, `ordem_chat`) VALUES
('Como faço a matrícula?',
 'A matrícula é feita pelo nosso formulário online. É só preencher os dados e a nossa equipe entra em contato para confirmar.',
 'Fazer matrícula', '/matricula', 1),
('Quais atividades vocês oferecem?',
 'O Cultura Efatá trabalha com esporte e cultura. Veja as modalidades e atividades em cada página.',
 'Ver esportes', '/esporte', 2),
('Quais são os próximos eventos?',
 'Todos os nossos eventos, encontros e campeonatos ficam na página de eventos.',
 'Ver eventos', '/eventos', 3),
('Onde vocês ficam?',
 'Estamos em São Miguel Paulista, São Paulo - SP. Para saber o endereço exato e os horários, fale com a gente no WhatsApp.',
 NULL, NULL, 4),
('Quero conhecer o projeto',
 'Conheça a nossa história, a equipe e o que move o Cultura Efatá.',
 'Sobre nós', '/sobre', 5),
('Tem novidades?',
 'Publicamos notícias, fotos e avisos no nosso blog.',
 'Ir para o blog', '/blog', 6);
