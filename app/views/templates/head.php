<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="shortcut icon" href="#" type="image/x-icon">
 <link rel="shortcut icon" href="/assets/img/Logo_Cultura.png" type="image/x-icon">
 <link rel="stylesheet" href="/assets/css/reset.css">
 <link rel="stylesheet" href="/assets/css/style.css?v=<?= time(); ?>">


 <link rel="stylesheet" type="text/css" href="/assets/js/slick/slick.css" />
 <link rel="stylesheet" type="text/css" href="/assets/js/slick/slick-theme.css" />
 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
 <link rel="stylesheet" type="text/css"
     href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />

 <!-- Google tag (gtag.js) -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZF40SL361Y"></script>
 <script>
     window.dataLayer = window.dataLayer || [];

     function gtag() {
         dataLayer.push(arguments);
     }
     gtag('js', new Date());

     gtag('config', 'G-ZF40SL361Y');
 </script>


 <!-- ===== NOVO: título e SEO dinâmicos =====
      O blog define $tituloMeta (e $descricao, $canonical, $imagemOg, $tipoOg) antes de incluir este arquivo.
      Nas outras páginas essas variáveis não existem, então o título continua "Cultura Efatá". -->
 <title><?= isset($tituloMeta) ? htmlspecialchars($tituloMeta . ' | Cultura Efatá', ENT_QUOTES, 'UTF-8') : 'Cultura Efatá' ?></title>

 <?php if (isset($tituloMeta)): ?>
     <?php if (!empty($descricao)): ?>
         <meta name="description" content="<?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?>">
         <meta property="og:description" content="<?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?>">
     <?php endif; ?>
     <?php if (!empty($canonical)): ?>
         <link rel="canonical" href="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
         <meta property="og:url" content="<?= htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') ?>">
     <?php endif; ?>
     <meta property="og:type" content="<?= htmlspecialchars($tipoOg ?? 'website', ENT_QUOTES, 'UTF-8') ?>">
     <meta property="og:site_name" content="Cultura Efatá">
     <meta property="og:title" content="<?= htmlspecialchars($tituloMeta, ENT_QUOTES, 'UTF-8') ?>">
     <?php if (!empty($imagemOg)): ?>
         <meta property="og:image" content="<?= htmlspecialchars($imagemOg, ENT_QUOTES, 'UTF-8') ?>">
     <?php endif; ?>
 <?php endif; ?>

 <!-- ===== NOVO: gancho para itens extras de uma página =====
      O blog usa isto para carregar fonte, Bootstrap e o CSS dele, só nas páginas do blog.
      Fica por último para o CSS do blog valer sobre o style.css. -->
 <?= $headExtra ?? '' ?>