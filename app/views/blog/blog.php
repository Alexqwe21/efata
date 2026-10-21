<?php
// app/views/blog/blog.php
// Página ÚNICA do blog público: tem tudo dentro dela (CSS, cabeçalho, rodapé, lista e post).
// Quem escolhe o que mostrar é o BlogController, pela variável $modo:
//
//   $modo = 'lista'  -> /blog e /blog/categoria/{slug}
//           recebe: $categoriaAtual, $posts, $categorias, $pagina, $totalPaginas
//   $modo = 'post'   -> /blog/ver/{slug}
//           recebe: $post, $categorias
//
// Para trocar o cabeçalho ou o rodapé pelos do site, procure os comentários
// "CABEÇALHO" e "RODAPÉ" mais abaixo.

$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');


// ==========================================================
// Limpeza do HTML escrito no editor (usada só na página do post).
// Mantém: parágrafos, títulos, listas, negrito, itálico, citação e link.
// Remove: scripts, atributos (onclick, style...) e links perigosos (javascript:).
// ==========================================================

if (!function_exists('blog_filtrar_no')) {
    function blog_filtrar_no(DOMNode $no)
    {
        $permitidas = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 'h2', 'h3', 'ul', 'ol', 'li', 'blockquote', 'a', 'img'];
        $descartar  = ['script', 'style', 'iframe', 'object', 'embed', 'form', 'svg', 'math', 'noscript', 'template'];

        foreach (iterator_to_array($no->childNodes) as $filho) {

            if ($filho->nodeType === XML_COMMENT_NODE) {
                $no->removeChild($filho);
                continue;
            }

            if ($filho->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            $tag = strtolower($filho->nodeName);

            if (in_array($tag, $descartar, true)) {
                $no->removeChild($filho);
                continue;
            }

            blog_filtrar_no($filho);

            // Tag não permitida: mantém só o texto/filhos dela
            if (!in_array($tag, $permitidas, true)) {
                while ($filho->firstChild) {
                    $no->insertBefore($filho->firstChild, $filho);
                }
                $no->removeChild($filho);
                continue;
            }

            // Imagem: só vale se vier da pasta de uploads do blog; senão é removida
            if ($tag === 'img') {
                $src = trim($filho->getAttribute('src'));

                if (!class_exists('BlogMidia') || !BlogMidia::caminhoPublicoValido($src)) {
                    $no->removeChild($filho);
                    continue;
                }
            }

            // Remove todos os atributos; do <a> só mantém um href seguro (e da <img>, src e alt)
            foreach (iterator_to_array($filho->attributes) as $attr) {
                $nome = $attr->nodeName;

                if ($tag === 'img' && ($nome === 'src' || $nome === 'alt')) {
                    continue;
                }

                if ($tag === 'a' && $nome === 'href') {
                    if (!preg_match('~^(https?://|mailto:|/)~i', trim($attr->nodeValue))) {
                        $filho->removeAttribute('href');
                    }
                } else {
                    $filho->removeAttribute($nome);
                }
            }

            if ($tag === 'a' && $filho->hasAttribute('href')) {
                $filho->setAttribute('rel', 'noopener noreferrer');
                $filho->setAttribute('target', '_blank');
            }

            if ($tag === 'img') {
                $filho->setAttribute('loading', 'lazy');
            }
        }
    }
}

if (!function_exists('blog_limpar_html')) {
    function blog_limpar_html($html)
    {
        $html = (string) $html;

        if (trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div>' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();

        $raiz = $dom->getElementsByTagName('div')->item(0);

        if (!$raiz) {
            return '';
        }

        blog_filtrar_no($raiz);

        $saida = '';
        foreach ($raiz->childNodes as $no) {
            $saida .= $dom->saveHTML($no);
        }

        return $saida;
    }
}


// ==========================================================
// Dados da página (título, descrição, links...)
// ==========================================================

$ehPost = ($modo ?? 'lista') === 'post';

if ($ehPost) {

    // O conteúdo vem do editor: passa pela limpeza antes de ir para a página
    $corpo    = blog_limpar_html($post['conteudo_post']);
    $texto    = trim(preg_replace('/\s+/u', ' ', strip_tags($corpo)));
    $palavras = preg_match_all('/\S+/u', $texto);
    $minutos  = max(1, (int) ceil($palavras / 200));

    $data     = !empty($post['data_publicacao_post']) ? strtotime($post['data_publicacao_post']) : null;
    $autor    = trim(explode(' ', trim($post['nome_funcionario'] ?? ''))[0] ?? '');
    $urlPost  = BASE_URL . 'blog/ver/' . $post['slug_post'];
    $temCapa  = !empty($post['foto_post']);
    $urlCapa  = $temCapa ? BASE_URL . ltrim($post['foto_post'], '/') : '';

    // Vídeo (YouTube/Vimeo) e galeria de fotos do post
    $video   = class_exists('BlogMidia') ? BlogMidia::videoEmbed($post['video_post'] ?? '') : null;
    $galeria = $galeria ?? [];

    // Sem capa, a primeira foto da galeria vira a imagem de compartilhamento (WhatsApp, Facebook...)
    if (!$temCapa && !empty($galeria)) {
        $urlCapa = BASE_URL . ltrim($galeria[0]['arquivo_imagem'], '/');
    }

    $tituloMeta = $post['titulo_post'];
    $descricao  = !empty($post['resumo_post'])
        ? $post['resumo_post']
        : mb_strimwidth($texto, 0, 160, '…', 'UTF-8');
    $canonical  = $urlPost;
    $imagemOg   = $urlCapa;
    $tipoOg     = 'article';

} else {

    $base = $categoriaAtual
        ? '/blog/categoria/' . $categoriaAtual['slug_categoria_blog']
        : '/blog';

    $urlPagina = fn($n) => $base . ($n > 1 ? '?pagina=' . $n : '');

    $tituloMeta = $categoriaAtual ? 'Blog: ' . $categoriaAtual['nome_categoria_blog'] : 'Blog';
    $descricao  = $categoriaAtual
        ? 'Posts da categoria ' . $categoriaAtual['nome_categoria_blog'] . ' no blog da Cultura Efatá.'
        : 'Novidades, treinos e histórias da Cultura Efatá.';
    $canonical  = BASE_URL . ltrim($urlPagina($pagina), '/');
    $imagemOg   = '';
    $tipoOg     = 'website';
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php require_once(__DIR__ . '/../templates/head.php'); ?>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">

   <style>
/* ==========================================================
   Blog público - Cultura Efatá
   Paleta: 056CF2 · 0597F2 · 05AFF2 · 05F2DB · F2A007
   ========================================================== */

:root {
  --azul-1: #056CF2;
  --azul-2: #0597F2;
  --azul-3: #05AFF2;
  --turquesa: #05F2DB;
  --laranja: #F2A007;

  --azul-escuro: #0455c4;   /* texto azul sobre fundo claro (contraste) */
  --noite: #06121E;         /* mesmo azul-noite do painel */
  --texto: #1b2733;
  --suave: #566678;
  --fundo: #f3f8fe;
  --borda: #dbe6f3;
}

.blog-body {
  font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
  color: var(--texto);
  background: var(--fundo);
  line-height: 1.6;
}

.blog-body a:focus-visible,
.blog-body button:focus-visible {
  outline: 3px solid var(--laranja);
  outline-offset: 2px;
}

/* ---------- Topo ---------- */

.blog-topo {
  background: var(--noite);
}

.blog-topo::after {
  content: "";
  display: block;
  height: 4px;
  background: linear-gradient(90deg, var(--azul-1), var(--azul-2), var(--azul-3), var(--turquesa), var(--laranja));
}

.blog-topo .container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding-top: .75rem;
  padding-bottom: .75rem;
}

.blog-topo__logo img {
  display: block;
  height: 44px;
  width: auto;
}

.blog-topo__nav {
  display: flex;
  gap: .25rem;
}

.blog-topo__nav a {
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: .95rem;
  padding: .5rem .95rem;
  border-radius: 999px;
}

.blog-topo__nav a:hover,
.blog-topo__nav a.ativo {
  background: rgba(255, 255, 255, .14);
}

/* ---------- Faixa de título ---------- */

.blog-hero {
  position: relative;
  overflow: hidden;
  color: #fff;
  padding: 3.5rem 0 4.5rem;
  background: linear-gradient(110deg, #056CF2 0%, #056CF2 42%, #0597F2 74%, #05AFF2 100%);
}

.blog-hero::before {
  content: "";
  position: absolute;
  right: -90px;
  top: -130px;
  width: 400px;
  height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(5, 242, 219, .55), rgba(5, 242, 219, 0) 68%);
}

.blog-hero::after {
  content: "";
  position: absolute;
  right: 12%;
  bottom: -150px;
  width: 300px;
  height: 300px;
  border-radius: 50%;
  border: 34px solid rgba(255, 255, 255, .1);
}

.blog-hero .container {
  position: relative;
  z-index: 1;

  
}

.blog-kicker {
  display: inline-block;
  margin-bottom: 1rem;
  padding: .3rem .85rem;
  border-radius: 999px;
  background: var(--laranja);
  color: var(--noite);
  font-weight: 800;
  font-size: .75rem;
  letter-spacing: .08em;
  text-transform: uppercase;
  text-decoration: none;
}

.blog-hero h1 {
  margin: 0 0 .6rem;
  max-width: 860px;
  font-weight: 800;
  font-size: clamp(2rem, 5vw, 3.25rem);
  line-height: 1.12;
  letter-spacing: -.02em;
}

.blog-hero__sub {
  margin: 0;
  max-width: 560px;
  font-size: 1.1rem;
  opacity: .95;
}

.blog-hero--artigo {
  padding-bottom: 5rem;
}

.blog-hero--artigo h1 {
  font-size: clamp(1.75rem, 4vw, 2.75rem);
}

.artigo-meta {
  display: flex;
  flex-wrap: wrap;
  gap: .5rem 1.25rem;
  margin-top: 1.25rem;
  font-size: .95rem;
  font-weight: 600;
}

.artigo-meta i {
  margin-right: .35rem;
}

/* ---------- Conteúdo principal ---------- */

.blog-main {
  position: relative;
  z-index: 2;
  margin-top: 2.75rem;
  padding-bottom: 4rem;
}

/* ---------- Cards da lista ---------- */

.post-card {
  display: flex;
  flex-direction: column;
  height: 100%;
  overflow: hidden;
  background: #fff;
  border: 1px solid var(--borda);
  border-radius: 18px;
  transition: transform .2s ease, box-shadow .2s ease;
}

.post-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 14px 30px rgba(5, 108, 242, .16);
}

.post-card__midia {
  display: block;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background: var(--noite);
  color: #fff;
  text-decoration: none;
}

.post-card__midia img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.post-card__ph {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  color: #fff;
  font-size: 3.5rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--azul-1), var(--azul-3));
}

.post-card__corpo {
  display: flex;
  flex: 1;
  flex-direction: column;
  gap: .6rem;
  padding: 1.25rem 1.25rem 1.4rem;
}

.chip {
  display: inline-block;
  align-self: flex-start;
  padding: .25rem .75rem;
  border-radius: 999px;
  background: #e5f0fe;
  color: var(--azul-escuro);
  font-weight: 700;
  font-size: .75rem;
  text-decoration: none;
}

.chip:hover {
  background: var(--azul-1);
  color: #fff;
}

.post-card__titulo {
  margin: 0;
  font-size: 1.2rem;
  font-weight: 800;
  line-height: 1.3;
}

.post-card__titulo a {
  color: var(--noite);
  text-decoration: none;
}

.post-card__titulo a:hover {
  color: var(--azul-escuro);
}

.post-card__resumo {
  margin: 0;
  color: var(--suave);
  font-size: .95rem;
}

.post-card__rodape {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: auto;
  padding-top: .5rem;
  color: var(--suave);
  font-size: .85rem;
}

.post-card__ler {
  color: var(--azul-escuro);
  font-weight: 700;
  text-decoration: none;
}

.post-card__ler:hover {
  text-decoration: underline;
  text-underline-offset: 3px;
}

/* ---------- Lateral ---------- */

.lateral-card {
  padding: 1.4rem;
  background: #fff;
  border: 1px solid var(--borda);
  border-radius: 18px;
}

.lateral-card + .lateral-card {
  margin-top: 1.25rem;
}

.lateral-card h2 {
  display: flex;
  align-items: center;
  gap: .5rem;
  margin: 0 0 1rem;
  font-size: 1rem;
  font-weight: 800;
  color: var(--noite);
}

.lateral-card h2::before {
  content: "";
  width: 6px;
  height: 1.1em;
  border-radius: 3px;
  background: var(--laranja);
}

.lateral-lista {
  margin: 0;
  padding: 0;
  list-style: none;
}

.lateral-lista a {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: .55rem .75rem;
  border-left: 3px solid transparent;
  border-radius: 8px;
  color: var(--texto);
  font-weight: 600;
  text-decoration: none;
}

.lateral-lista a:hover {
  background: #eef5fe;
  color: var(--azul-escuro);
}

.lateral-lista a.ativo {
  background: #e5f0fe;
  border-left-color: var(--laranja);
  color: var(--azul-escuro);
}

.lateral-lista small {
  min-width: 1.6rem;
  padding: .1rem .5rem;
  border-radius: 999px;
  background: var(--noite);
  color: #fff;
  font-size: .75rem;
  text-align: center;
}

/* ---------- Botões ---------- */

.btn-blog {
  display: inline-flex;
  align-items: center;
  gap: .5rem;
  padding: .65rem 1.3rem;
  border: 2px solid var(--azul-1);
  border-radius: 999px;
  background: var(--azul-1);
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  transition: background .15s ease, color .15s ease;
}

.btn-blog:hover {
  background: var(--noite);
  border-color: var(--noite);
  color: #fff;
}

.btn-blog--contorno {
  background: transparent;
  color: var(--azul-escuro);
}

.btn-blog--contorno:hover {
  background: var(--azul-1);
  border-color: var(--azul-1);
  color: #fff;
}

/* ---------- Paginação ---------- */

.paginacao {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: .4rem;
  margin: 2.5rem 0 0;
  padding: 0;
  list-style: none;
}

.paginacao a,
.paginacao span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 2.5rem;
  height: 2.5rem;
  padding: 0 .8rem;
  border: 1px solid var(--borda);
  border-radius: 999px;
  background: #fff;
  color: var(--texto);
  font-weight: 700;
  text-decoration: none;
}

.paginacao a:hover {
  border-color: var(--azul-1);
  color: var(--azul-escuro);
}

.paginacao .atual {
  background: var(--azul-1);
  border-color: var(--azul-1);
  color: #fff;
}

.paginacao .desativado {
  opacity: .45;
}

/* ---------- Estado vazio ---------- */

.vazio {
  padding: 3rem 1.5rem;
  text-align: center;
  background: #fff;
  border: 1px dashed var(--azul-3);
  border-radius: 18px;
}

.vazio i {
  display: block;
  margin-bottom: .75rem;
  color: var(--azul-2);
  font-size: 2.5rem;
}

/* ---------- Página do post ---------- */

.artigo {
  overflow: hidden;
  background: #fff;
  border: 1px solid var(--borda);
  border-radius: 22px;
}

.artigo__capa {
  display: block;
  width: 100%;
  max-height: 480px;
  object-fit: cover;
}

.artigo__corpo {
  max-width: 720px;
  margin: 0 auto;
  padding: 2rem 1.5rem 2.25rem;
  font-size: 1.125rem;
  line-height: 1.8;
}

.artigo__corpo h2,
.artigo__corpo h3 {
  margin: 2rem 0 .75rem;
  color: var(--noite);
  font-weight: 800;
  line-height: 1.25;
}

.artigo__corpo h2 { font-size: 1.6rem; }
.artigo__corpo h3 { font-size: 1.3rem; }

.artigo__corpo p {
  margin: 0 0 1.15rem;
}

.artigo__corpo a {
  color: var(--azul-escuro);
  text-underline-offset: 3px;
}

.artigo__corpo ul,
.artigo__corpo ol {
  margin: 0 0 1.15rem;
  padding-left: 1.4rem;
}

.artigo__corpo li {
  margin-bottom: .4rem;
}

.artigo__corpo blockquote {
  margin: 1.5rem 0;
  padding: 1rem 1.25rem;
  border-left: 5px solid var(--turquesa);
  border-radius: 0 12px 12px 0;
  background: #eef9fb;
  color: var(--noite);
  font-weight: 500;
}

.artigo__acoes {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: .75rem;
  max-width: 720px;
  margin: 0 auto;
  padding: 1.25rem 1.5rem 1.75rem;
  border-top: 1px solid var(--borda);
}

.artigo__acoes span {
  margin-right: auto;
  font-weight: 700;
}

/* ---------- Imagens dentro do texto ---------- */

.artigo__corpo img {
  display: block;
  max-width: 100%;
  height: auto;
  margin: 1.5rem auto;
  border-radius: 14px;
}

/* ---------- Vídeo do post ---------- */

.artigo__video {
  padding: 1.5rem 1.5rem 0;
  max-width: 720px;
  margin: 0 auto;
}

.video-embed {
  position: relative;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  border-radius: 14px;
  background: var(--noite);
}

.video-embed iframe {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  border: 0;
}

/* ---------- Galeria de fotos ---------- */

.galeria {
  max-width: 720px;
  margin: 0 auto;
  padding: 0 1.5rem 2rem;
}

.galeria__titulo {
  margin: 0 0 1rem;
  font-size: 1.3rem;
  font-weight: 800;
  color: var(--noite);
}

.galeria__grade {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: .6rem;
}

.galeria__item {
  position: relative;
  display: block;
  overflow: hidden;
  aspect-ratio: 4 / 3;
  border-radius: 12px;
  background: var(--noite);
  cursor: zoom-in;
}

.galeria__item img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform .25s ease;
}

.galeria__item:hover img,
.galeria__item:focus-visible img {
  transform: scale(1.06);
}

/* Ampliação (lightbox) */

.lightbox {
  position: fixed;
  inset: 0;
  z-index: 10000;
  display: none;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: .75rem;
  padding: 1rem;
  background: rgba(6, 18, 30, .94);
}

.lightbox.aberto {
  display: flex;
}

.lightbox img {
  max-width: 100%;
  max-height: 78vh;
  object-fit: contain;
  border-radius: 8px;
}

.lightbox__legenda {
  max-width: 800px;
  min-height: 1.4em;
  margin: 0;
  color: #fff;
  text-align: center;
}

.lightbox__contagem {
  color: rgba(255, 255, 255, .7);
  font-size: .85rem;
}

.lightbox button {
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 46px;
  height: 46px;
  border: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, .16);
  color: #fff;
  font-size: 1.4rem;
  line-height: 1;
  cursor: pointer;
}

.lightbox button:hover,
.lightbox button:focus-visible {
  background: var(--azul-1);
}

.lightbox__fechar { top: 14px; right: 14px; }
.lightbox__anterior { left: 14px; top: 50%; transform: translateY(-50%); }
.lightbox__proximo { right: 14px; top: 50%; transform: translateY(-50%); }

@media (max-width: 575px) {
  .artigo__video { padding: 1rem 1rem 0; }
  .galeria { padding: 0 1rem 1.5rem; }
  .galeria__grade { grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); }
  .lightbox__anterior { left: 6px; }
  .lightbox__proximo { right: 6px; }
}

/* ---------- Rodapé ---------- */

.blog-rodape {
  background: var(--noite);
  color: rgba(255, 255, 255, .85);
}

.blog-rodape::before {
  content: "";
  display: block;
  height: 4px;
  background: linear-gradient(90deg, var(--laranja), var(--turquesa), var(--azul-3), var(--azul-2), var(--azul-1));
}

.blog-rodape .container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding-top: 1.75rem;
  padding-bottom: 1.75rem;
}

.blog-rodape img {
  display: block;
  height: 40px;
  width: auto;
}

.blog-rodape a {
  color: #fff;
  font-weight: 600;
  text-decoration: none;
}

.blog-rodape a:hover {
  color: var(--turquesa);
}

.blog-rodape small {
  font-size: .85rem;
}

/* ---------- Movimento reduzido ---------- */

@media (prefers-reduced-motion: reduce) {
  .post-card,
  .btn-blog {
    transition: none;
  }

  .post-card:hover {
    transform: none;
  }
}
  </style> 
</head>
<body class="blog-body">

  <div class="preloader" id="preloader">
    <div id="lottie-container" style="width: 350px; height: 350px;"></div>
  </div>


  <!-- ================= CABEÇALHO (troque pelo do site, se quiser) ================= -->
  <header class="blog-topo">
    <div class="container">
      <a class="blog-topo__logo" href="/" aria-label="Cultura Efatá - página inicial">
        <img src="/assets/img/Logo_Cultura.png" alt="Cultura Efatá">
      </a>

      <nav class="blog-topo__nav" aria-label="Menu principal">
        <a href="/">Início</a>
        <a href="/blog" class="ativo">Blog</a>
      </nav>
    </div>
  </header>



<?php if ($ehPost): ?>
  <!-- ================= PÁGINA DO POST ================= -->

  <section class="blog-hero blog-hero--artigo">
    <div class="container">
      <?php if (!empty($post['nome_categoria_blog'])): ?>
        <a class="blog-kicker" href="/blog/categoria/<?= $e($post['slug_categoria_blog']) ?>">
          <?= $e($post['nome_categoria_blog']) ?>
        </a>
      <?php else: ?>
        <span class="blog-kicker">Blog</span>
      <?php endif; ?>

      <h1><?= $e($post['titulo_post']) ?></h1>

      <div class="artigo-meta">
        <?php if ($data): ?>
          <span><i class="bi bi-calendar3"></i><time datetime="<?= date('Y-m-d', $data) ?>"><?= date('d/m/Y', $data) ?></time></span>
        <?php endif; ?>
        <?php if ($autor !== ''): ?>
          <span><i class="bi bi-person"></i>Por <?= $e($autor) ?></span>
        <?php endif; ?>
        <span><i class="bi bi-clock"></i><?= $minutos ?> min de leitura</span>
      </div>
    </div>
  </section>


  <main class="blog-main">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-8">
          <article class="artigo">

            <?php if ($temCapa): ?>
              <img class="artigo__capa" src="/<?= $e(ltrim($post['foto_post'], '/')) ?>"
                alt="<?= $e($post['alt_foto_post'] ?? '') ?>">
            <?php endif; ?>

            <?php if ($video): ?>
              <div class="artigo__video">
                <div class="video-embed">
                  <iframe src="<?= $e($video['embed']) ?>"
                    title="Vídeo: <?= $e($post['titulo_post']) ?>"
                    loading="lazy"
                    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen></iframe>
                </div>
              </div>
            <?php endif; ?>

            <div class="artigo__corpo">
              <?= $corpo ?>
            </div>

            <?php if (!empty($galeria)): ?>
              <section class="galeria" aria-label="Galeria de fotos">
                <h2 class="galeria__titulo">Galeria de fotos</h2>
                <div class="galeria__grade">
                  <?php foreach ($galeria as $i => $foto): ?>
                    <?php
                    $arquivo  = '/' . ltrim($foto['arquivo_imagem'], '/');
                    $miniatura = '/' . ltrim(class_exists('BlogMidia') ? BlogMidia::miniatura($foto['arquivo_imagem']) : $foto['arquivo_imagem'], '/');
                    $legenda  = trim((string) ($foto['legenda_imagem'] ?? ''));
                    ?>
                    <a class="galeria__item" href="<?= $e($arquivo) ?>" data-indice="<?= (int) $i ?>"
                      data-legenda="<?= $e($legenda) ?>">
                      <img src="<?= $e($miniatura) ?>" loading="lazy"
                        alt="<?= $e($legenda !== '' ? $legenda : 'Foto ' . ($i + 1) . ' de ' . $post['titulo_post']) ?>">
                    </a>
                  <?php endforeach; ?>
                </div>
              </section>
            <?php endif; ?>

            <div class="artigo__acoes">
              <span>Gostou? Compartilhe:</span>
              <a class="btn-blog btn-blog--contorno" target="_blank" rel="noopener"
                href="https://wa.me/?text=<?= rawurlencode($post['titulo_post'] . ' ' . $urlPost) ?>">
                <i class="bi bi-whatsapp"></i> WhatsApp
              </a>
              <a class="btn-blog" href="/blog"><i class="bi bi-arrow-left"></i> Voltar ao blog</a>
            </div>

          </article>

          <!-- ================= COMENTÁRIOS ================= -->
<?php
$comentarios = $comentarios ?? [];
$comentToken = $comentToken ?? '';
?>
<section class="coment" id="comentarios" aria-labelledby="coment-titulo">

  <h2 class="coment__titulo" id="coment-titulo">
    Comentários <span class="coment__total"><?= count($comentarios) ?></span>
  </h2>

  <?php if (empty($comentarios)): ?>
    <p class="coment__vazio">Ainda não há comentários. Seja a primeira pessoa a comentar!</p>
  <?php else: ?>
    <ul class="coment__lista">
      <?php foreach ($comentarios as $c): ?>
        <?php $inicial = mb_strtoupper(mb_substr(trim($c['nome_comentario']), 0, 1)); ?>
        <li class="coment__item">
          <span class="coment__avatar" aria-hidden="true"><?= $e($inicial) ?></span>
          <div class="coment__conteudo">
            <div class="coment__cabecalho">
              <strong><?= $e($c['nome_comentario']) ?></strong>
              <time datetime="<?= $e(date('Y-m-d', strtotime($c['data_cadastro_comentario']))) ?>">
                <?= $e(date('d/m/Y', strtotime($c['data_cadastro_comentario']))) ?>
              </time>
            </div>
            <p><?= nl2br($e($c['texto_comentario'])) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form class="coment__form" id="formComentario" novalidate>
    <h3>Deixe seu comentário</h3>

    <input type="hidden" name="id_post" value="<?= (int) $post['id_post'] ?>">
    <input type="hidden" name="tk" value="<?= $e($comentToken) ?>">

    <!-- Campo-isca: escondido de pessoas. Robôs costumam preencher. -->
    <div class="coment__isca" aria-hidden="true">
      <label>Não preencha este campo
        <input type="text" name="site_url" tabindex="-1" autocomplete="off">
      </label>
    </div>

    <div class="coment__linha">
      <div class="coment__campo">
        <label for="comentNome">Nome *</label>
        <input type="text" id="comentNome" name="nome" maxlength="80" required autocomplete="name">
      </div>
      <div class="coment__campo">
        <label for="comentEmail">E-mail <small>(opcional, não aparece no site)</small></label>
        <input type="email" id="comentEmail" name="email" maxlength="120" autocomplete="email">
      </div>
    </div>

    <div class="coment__campo">
      <label for="comentTexto">Comentário *</label>
      <textarea id="comentTexto" name="texto" rows="4" maxlength="1000" required></textarea>
      <small class="coment__contador"><span id="comentContador">0</span>/1000</small>
    </div>

    <button type="submit" class="coment__botao" id="comentBotao">Enviar comentário</button>
    <p class="coment__aviso">
      Os comentários são analisados antes de aparecer. Seu e-mail, se informado, é usado só pela equipe
      para contato e não é publicado.
    </p>
    <div class="coment__retorno" id="comentRetorno" role="status" aria-live="polite"></div>
  </form>

</section>

<style>
  .coment { margin-top: 32px; background: #fff; border: 1px solid var(--borda, #dbe6f3); border-radius: 18px; padding: 28px; }
  .coment__titulo { font-size: 1.4rem; font-weight: 800; color: var(--noite, #06121E); margin: 0 0 18px; }
  .coment__total { display: inline-block; min-width: 28px; padding: 2px 9px; border-radius: 99px; background: var(--azul-1, #056CF2); color: #fff; font-size: .85rem; text-align: center; vertical-align: middle; }
  .coment__vazio { color: var(--suave, #566678); margin-bottom: 24px; }
  .coment__lista { list-style: none; margin: 0 0 28px; padding: 0; display: grid; gap: 14px; }
  .coment__item { display: flex; gap: 12px; align-items: flex-start; }
  .coment__avatar { flex: 0 0 42px; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--azul-1, #056CF2), var(--azul-3, #05AFF2)); color: #fff; font-weight: 800; }
  .coment__conteudo { flex: 1; min-width: 0; background: var(--fundo, #f3f8fe); border-radius: 14px; padding: 12px 16px; }
  .coment__cabecalho { display: flex; flex-wrap: wrap; gap: 6px 12px; align-items: baseline; margin-bottom: 4px; }
  .coment__cabecalho time { font-size: .8rem; color: var(--suave, #566678); }
  .coment__conteudo p { margin: 0; overflow-wrap: anywhere; }

  .coment__form { border-top: 1px solid var(--borda, #dbe6f3); padding-top: 22px; }
  .coment__form h3 { font-size: 1.1rem; font-weight: 800; margin: 0 0 14px; }
  .coment__linha { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .coment__campo { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
  .coment__campo label { font-weight: 700; font-size: .9rem; }
  .coment__campo small { font-weight: 400; color: var(--suave, #566678); }
  .coment__campo input, .coment__campo textarea { width: 100%; border: 1px solid var(--borda, #dbe6f3); border-radius: 12px; padding: 11px 14px; font: inherit; background: #fff; color: var(--texto, #1b2733); }
  .coment__campo input:focus, .coment__campo textarea:focus { outline: 3px solid var(--azul-3, #05AFF2); outline-offset: 1px; border-color: var(--azul-1, #056CF2); }
  .coment__contador { text-align: right; }
  .coment__isca { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
  .coment__botao { border: 0; border-radius: 12px; padding: 12px 22px; font-weight: 800; color: #fff; background: var(--azul-1, #056CF2); cursor: pointer; transition: background .2s; }
  .coment__botao:hover { background: var(--azul-escuro, #0455c4); }
  .coment__botao:disabled { opacity: .6; cursor: wait; }
  .coment__aviso { margin: 12px 0 0; font-size: .8rem; color: var(--suave, #566678); }
  .coment__retorno { margin-top: 12px; font-weight: 700; }
  .coment__retorno.ok { color: #0a7a3d; }
  .coment__retorno.erro { color: #b3261e; }
  @media (max-width: 575px) { .coment { padding: 18px; } .coment__linha { grid-template-columns: 1fr; } }

  /* Modo escuro do site (body.dark-theme): o CSS do site força texto branco, então o fundo escurece também */
  body.dark-theme .coment { background: #161617; border-color: #2a2a2e; }
  body.dark-theme .coment__conteudo { background: #1C1C1C; }
  body.dark-theme .coment__campo input, body.dark-theme .coment__campo textarea { background: #1C1C1C; border-color: #333; color: #fff !important; }
  body.dark-theme .coment__retorno.ok { color: #5be08f !important; }
  body.dark-theme .coment__retorno.erro { color: #ff8a80 !important; }
  body.dark-theme .coment__botao { color: #fff !important; }
</style>

<script>
  (function () {
    var form = document.getElementById('formComentario');
    if (!form) return;

    var texto = document.getElementById('comentTexto');
    var contador = document.getElementById('comentContador');
    var botao = document.getElementById('comentBotao');
    var retorno = document.getElementById('comentRetorno');

    texto.addEventListener('input', function () { contador.textContent = texto.value.length; });

    function mostrar(tipo, msg) {
      retorno.className = 'coment__retorno ' + tipo;
      retorno.textContent = msg;
    }

    form.addEventListener('submit', function (ev) {
      ev.preventDefault();

      if (!form.nome.value.trim() || texto.value.trim().length < 3) {
        mostrar('erro', 'Preencha seu nome e escreva o comentário.');
        return;
      }

      botao.disabled = true;
      botao.textContent = 'Enviando...';

      fetch('/blog/comentar', { method: 'POST', body: new FormData(form) })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          mostrar(res.status === 'sucesso' ? 'ok' : 'erro', res.mensagem);
          if (res.status === 'sucesso') { form.reset(); contador.textContent = '0'; }
        })
        .catch(function () { mostrar('erro', 'Não foi possível enviar agora. Tente novamente.'); })
        .then(function () { botao.disabled = false; botao.textContent = 'Enviar comentário'; });
    });
  })();
</script>

        </div>


        <aside class="col-lg-4">
          <div class="lateral-card">
            <h2>Categorias</h2>

            <?php if (empty($categorias)): ?>
              <p class="text-secondary mb-0">Ainda não há categorias.</p>
            <?php else: ?>
              <ul class="lateral-lista">
                <li><a href="/blog">Todos os posts</a></li>
                <?php foreach ($categorias as $c): ?>
                  <?php $ativa = !empty($post['id_categoria_blog']) && (int) $post['id_categoria_blog'] === (int) $c['id_categoria_blog']; ?>
                  <li>
                    <a href="/blog/categoria/<?= $e($c['slug_categoria_blog']) ?>" class="<?= $ativa ? 'ativo' : '' ?>">
                      <?= $e($c['nome_categoria_blog']) ?>
                      <small><?= (int) $c['total_posts'] ?></small>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </aside>

      </div>
    </div>
  </main>


<?php else: ?>
  <!-- ================= LISTA DE POSTS ================= -->

  <section class="blog-hero">
    <div class="container">
      <?php if ($categoriaAtual): ?>
        <a class="blog-kicker" href="/blog">&larr; Todos os posts</a>
        <h1><?= $e($categoriaAtual['nome_categoria_blog']) ?></h1>
        <p class="blog-hero__sub">Posts desta categoria.</p>
      <?php else: ?>
        <span class="blog-kicker">Blog</span>
        <h1>Novidades da Cultura Efatá</h1>
        <p class="blog-hero__sub">Treinos, eventos e histórias de quem vive o esporte com a gente.</p>
      <?php endif; ?>
    </div>
  </section>


  <main class="blog-main">
    <div class="container">
      <div class="row g-4">

        <div class="col-lg-8">

          <?php if (empty($posts)): ?>

            <div class="vazio">
              <i class="bi bi-journal-text"></i>
              <h2 class="h5 fw-bold">Nenhum post por aqui ainda</h2>
              <p class="text-secondary mb-3">Volte em breve, estamos preparando novidades.</p>
              <?php if ($categoriaAtual): ?>
                <a class="btn-blog" href="/blog">Ver todos os posts</a>
              <?php endif; ?>
            </div>

          <?php else: ?>

            <div class="row row-cols-1 row-cols-md-2 g-4">
              <?php foreach ($posts as $p): ?>
                <?php
                $link = '/blog/ver/' . $p['slug_post'];
                $dataCard = !empty($p['data_publicacao_post']) ? strtotime($p['data_publicacao_post']) : null;
                ?>
                <div class="col">
                  <article class="post-card">

                    <a class="post-card__midia" href="<?= $e($link) ?>" tabindex="-1" aria-hidden="true">
                      <?php if (!empty($p['foto_post'])): ?>
                        <img src="/<?= $e(ltrim($p['foto_post'], '/')) ?>"
                          alt="<?= $e($p['alt_foto_post'] ?? '') ?>" loading="lazy">
                      <?php else: ?>
                        <div class="post-card__ph"><?= $e(mb_strtoupper(mb_substr($p['titulo_post'], 0, 1, 'UTF-8'), 'UTF-8')) ?></div>
                      <?php endif; ?>
                    </a>

                    <div class="post-card__corpo">
                      <?php if (!empty($p['nome_categoria_blog'])): ?>
                        <a class="chip" href="/blog/categoria/<?= $e($p['slug_categoria_blog']) ?>">
                          <?= $e($p['nome_categoria_blog']) ?>
                        </a>
                      <?php endif; ?>

                      <h2 class="post-card__titulo">
                        <a href="<?= $e($link) ?>"><?= $e($p['titulo_post']) ?></a>
                      </h2>

                      <?php if (!empty($p['resumo_post'])): ?>
                        <p class="post-card__resumo"><?= $e($p['resumo_post']) ?></p>
                      <?php endif; ?>

                      <div class="post-card__rodape">
                        <?php if ($dataCard): ?>
                          <time datetime="<?= date('Y-m-d', $dataCard) ?>"><?= date('d/m/Y', $dataCard) ?></time>
                        <?php else: ?>
                          <span></span>
                        <?php endif; ?>
                        <a class="post-card__ler" href="<?= $e($link) ?>">Ler post &rarr;</a>
                      </div>
                    </div>

                  </article>
                </div>
              <?php endforeach; ?>
            </div>


            <?php if ($totalPaginas > 1): ?>
              <?php
              $ini = max(1, $pagina - 2);
              $fim = min($totalPaginas, $pagina + 2);
              ?>
              <nav aria-label="Paginação">
                <ul class="paginacao">
                  <li>
                    <?php if ($pagina > 1): ?>
                      <a href="<?= $e($urlPagina($pagina - 1)) ?>" rel="prev">&larr; Anterior</a>
                    <?php else: ?>
                      <span class="desativado">&larr; Anterior</span>
                    <?php endif; ?>
                  </li>

                  <?php if ($ini > 1): ?>
                    <li><a href="<?= $e($urlPagina(1)) ?>">1</a></li>
                    <?php if ($ini > 2): ?><li><span class="desativado">&hellip;</span></li><?php endif; ?>
                  <?php endif; ?>

                  <?php for ($i = $ini; $i <= $fim; $i++): ?>
                    <li>
                      <?php if ($i === $pagina): ?>
                        <span class="atual" aria-current="page"><?= $i ?></span>
                      <?php else: ?>
                        <a href="<?= $e($urlPagina($i)) ?>"><?= $i ?></a>
                      <?php endif; ?>
                    </li>
                  <?php endfor; ?>

                  <?php if ($fim < $totalPaginas): ?>
                    <?php if ($fim < $totalPaginas - 1): ?><li><span class="desativado">&hellip;</span></li><?php endif; ?>
                    <li><a href="<?= $e($urlPagina($totalPaginas)) ?>"><?= $totalPaginas ?></a></li>
                  <?php endif; ?>

                  <li>
                    <?php if ($pagina < $totalPaginas): ?>
                      <a href="<?= $e($urlPagina($pagina + 1)) ?>" rel="next">Próxima &rarr;</a>
                    <?php else: ?>
                      <span class="desativado">Próxima &rarr;</span>
                    <?php endif; ?>
                  </li>
                </ul>
              </nav>
            <?php endif; ?>

          <?php endif; ?>

        </div>


        <aside class="col-lg-4">
          <div class="lateral-card">
            <h2>Categorias</h2>

            <?php if (empty($categorias)): ?>
              <p class="text-secondary mb-0">Ainda não há categorias.</p>
            <?php else: ?>
              <ul class="lateral-lista">
                <li>
                  <a href="/blog" class="<?= !$categoriaAtual ? 'ativo' : '' ?>">Todos os posts</a>
                </li>
                <?php foreach ($categorias as $c): ?>
                  <?php $ativa = $categoriaAtual && (int) $categoriaAtual['id_categoria_blog'] === (int) $c['id_categoria_blog']; ?>
                  <li>
                    <a href="/blog/categoria/<?= $e($c['slug_categoria_blog']) ?>" class="<?= $ativa ? 'ativo' : '' ?>">
                      <?= $e($c['nome_categoria_blog']) ?>
                      <small><?= (int) $c['total_posts'] ?></small>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </aside>

      </div>
    </div>
  </main>

<?php endif; ?>



  <!-- ================= RODAPÉ (troque pelo do site, se quiser) ================= -->
  <footer class="blog-rodape">
    <div class="container">
      <a href="/" aria-label="Cultura Efatá - página inicial">
        <img src="/assets/img/Logo_Cultura.png" alt="Cultura Efatá">
      </a>

      <small>&copy; <?= date('Y') ?> Cultura Efatá. Todos os direitos reservados.</small>

      <a href="/blog">Voltar ao blog</a>
    </div>
  </footer>

<?php if ($ehPost && !empty($galeria)): ?>
  <!-- ================= AMPLIAÇÃO DAS FOTOS DA GALERIA ================= -->
  <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Foto ampliada">
    <button type="button" class="lightbox__fechar" aria-label="Fechar">&times;</button>
    <button type="button" class="lightbox__anterior" aria-label="Foto anterior">&#8249;</button>
    <img src="" alt="">
    <p class="lightbox__legenda"></p>
    <span class="lightbox__contagem"></span>
    <button type="button" class="lightbox__proximo" aria-label="Próxima foto">&#8250;</button>
  </div>

  <script>
    (function () {
      var itens = Array.prototype.slice.call(document.querySelectorAll('.galeria__item'));
      var caixa = document.getElementById('lightbox');
      if (!itens.length || !caixa) return;

      var imagem = caixa.querySelector('img');
      var legenda = caixa.querySelector('.lightbox__legenda');
      var contagem = caixa.querySelector('.lightbox__contagem');
      var atual = 0;
      var ultimoFoco = null;
      var toqueX = null;

      function mostrar(i) {
        atual = (i + itens.length) % itens.length;
        var item = itens[atual];
        imagem.src = item.getAttribute('href');
        imagem.alt = item.getAttribute('data-legenda') || item.querySelector('img').alt;
        legenda.textContent = item.getAttribute('data-legenda') || '';
        contagem.textContent = (atual + 1) + ' / ' + itens.length;
      }

      function abrir(i) {
        ultimoFoco = document.activeElement;
        mostrar(i);
        caixa.classList.add('aberto');
        document.body.style.overflow = 'hidden';
        caixa.querySelector('.lightbox__fechar').focus();
      }

      function fechar() {
        caixa.classList.remove('aberto');
        document.body.style.overflow = '';
        imagem.src = '';
        if (ultimoFoco) ultimoFoco.focus();
      }

      itens.forEach(function (item, i) {
        item.addEventListener('click', function (ev) { ev.preventDefault(); abrir(i); });
      });

      caixa.querySelector('.lightbox__fechar').addEventListener('click', fechar);
      caixa.querySelector('.lightbox__anterior').addEventListener('click', function () { mostrar(atual - 1); });
      caixa.querySelector('.lightbox__proximo').addEventListener('click', function () { mostrar(atual + 1); });

      // Clicar no fundo escuro também fecha
      caixa.addEventListener('click', function (ev) { if (ev.target === caixa) fechar(); });

      document.addEventListener('keydown', function (ev) {
        if (!caixa.classList.contains('aberto')) return;
        if (ev.key === 'Escape') fechar();
        if (ev.key === 'ArrowLeft') mostrar(atual - 1);
        if (ev.key === 'ArrowRight') mostrar(atual + 1);
      });

      // Passar o dedo para o lado troca de foto (celular)
      caixa.addEventListener('touchstart', function (ev) { toqueX = ev.changedTouches[0].clientX; }, { passive: true });
      caixa.addEventListener('touchend', function (ev) {
        if (toqueX === null) return;
        var dx = ev.changedTouches[0].clientX - toqueX;
        toqueX = null;
        if (Math.abs(dx) > 50) mostrar(atual + (dx < 0 ? 1 : -1));
      }, { passive: true });
    })();
  </script>
<?php endif; ?>

  <script src="https://unpkg.com/lottie-web@5.12.2/build/player/lottie.min.js"></script>
  <script>
    // Inicia o preload com animação Lottie
    const animation = lottie.loadAnimation({
      container: document.getElementById('lottie-container'),
      renderer: 'svg',
      loop: true,
      autoplay: true,
      path: '/assets/preloads/preloads.json' // caminho absoluto: o blog tem URLs como /blog/ver/{slug}
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

  <?php require_once(__DIR__ . '/../templates/chatLeao.php'); ?>
</body>

</html>
