<?php
// Campos do post, usados tanto no modal "Novo post" quanto nos modais de edição.
// Recebe: $post, $categorias e $sufixo (texto único para os ids: "Novo" ou o id do post)
// Opcionais: $imagens (fotos da galeria deste post) e $limiteGaleria

$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$s = $e($sufixo);

$dataPub = !empty($post['data_publicacao_post'])
  ? date('Y-m-d\TH:i', strtotime($post['data_publicacao_post']))
  : '';

$fotoAtual = !empty($post['foto_post']) ? '/' . ltrim($post['foto_post'], '/') : '';

$imagens       = $imagens ?? [];
$limiteGaleria = $limiteGaleria ?? 20;
$vagasGaleria  = max(0, $limiteGaleria - count($imagens));
?>

<div class="col-md-8">
  <label class="form-label" for="titulo_post_<?= $s ?>">Título</label>
  <input type="text" name="titulo_post" id="titulo_post_<?= $s ?>" class="form-control" maxlength="200" required
    placeholder="Ex: Como foi o nosso último treino"
    value="<?= $e($post['titulo_post']) ?>">
</div>

<div class="col-md-4">
  <label class="form-label" for="id_categoria_blog_<?= $s ?>">Categoria</label>
  <select name="id_categoria_blog" id="id_categoria_blog_<?= $s ?>" class="form-select">
    <option value="">Sem categoria</option>
    <?php foreach ($categorias as $c): ?>
      <option value="<?= (int) $c['id_categoria_blog'] ?>"
        <?= (int) $post['id_categoria_blog'] === (int) $c['id_categoria_blog'] ? 'selected' : '' ?>>
        <?= $e($c['nome_categoria_blog']) ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>

<div class="col-12">
  <label class="form-label" for="resumo_post_<?= $s ?>">Resumo <small class="text-muted">(aparece na lista de posts, até 300 caracteres)</small></label>
  <textarea name="resumo_post" id="resumo_post_<?= $s ?>" class="form-control" rows="2" maxlength="300"><?= $e($post['resumo_post']) ?></textarea>
</div>

<div class="col-12">
  <label class="form-label">Conteúdo</label>
  <div class="editor-post" style="height: 260px; background: #fff;"></div>
  <textarea name="conteudo_post" class="conteudo-post" style="display: none;"><?= $e($post['conteudo_post']) ?></textarea>
</div>

<div class="col-md-6">
  <label class="form-label" for="foto_post_<?= $s ?>">Imagem de capa <small class="text-muted">(JPG, PNG, WEBP ou GIF, até 3 MB)</small></label>
  <input type="file" name="foto_post" id="foto_post_<?= $s ?>" class="form-control foto-post" accept="image/jpeg,image/png,image/webp,image/gif">

  <div class="mt-2">
    <img class="preview-capa" src="<?= $e($fotoAtual) ?>" alt="Prévia da capa"
      style="max-width: 100%; max-height: 200px; object-fit: cover; border: 1px solid #ccc; padding: 4px; <?= $fotoAtual === '' ? 'display: none;' : '' ?>">
  </div>

  <?php if ($fotoAtual !== ''): ?>
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" name="remover_foto" id="remover_foto_<?= $s ?>" value="1">
      <label class="form-check-label" for="remover_foto_<?= $s ?>">Remover a imagem atual</label>
    </div>
  <?php endif; ?>

  <label class="form-label mt-3" for="alt_foto_post_<?= $s ?>">Texto alternativo da imagem <small class="text-muted">(descrição para acessibilidade e Google)</small></label>
  <input type="text" name="alt_foto_post" id="alt_foto_post_<?= $s ?>" class="form-control" maxlength="255"
    value="<?= $e($post['alt_foto_post']) ?>">
</div>

<div class="col-md-6">
  <label class="form-label" for="video_post_<?= $s ?>">Vídeo <small class="text-muted">(opcional: link do YouTube ou do Vimeo)</small></label>
  <input type="url" name="video_post" id="video_post_<?= $s ?>" class="form-control" maxlength="255"
    placeholder="https://www.youtube.com/watch?v=..."
    value="<?= $e($post['video_post'] ?? '') ?>">
  <small class="text-muted">O vídeo aparece no começo do post. Para apagar, deixe o campo vazio.</small>
</div>

<div class="col-12">
  <label class="form-label">Galeria de fotos <small class="text-muted">(opcional, até <?= (int) $limiteGaleria ?> fotos, 3 MB cada)</small></label>

  <?php if (!empty($imagens)): ?>
    <div class="row g-2 mb-3">
      <?php foreach ($imagens as $img): ?>
        <?php $idImg = (int) $img['id_imagem']; ?>
        <div class="col-6 col-md-3 col-lg-2">
          <div class="border rounded p-2 h-100" style="background: #fff;">
            <img src="/<?= $e(ltrim(BlogMidia::miniatura($img['arquivo_imagem']), '/')) ?>" alt=""
              style="width: 100%; aspect-ratio: 4 / 3; object-fit: cover; border-radius: 4px;">

            <input type="text" name="legenda_img[<?= $idImg ?>]" class="form-control form-control-sm mt-2"
              maxlength="160" placeholder="Legenda" value="<?= $e($img['legenda_imagem']) ?>">

            <div class="d-flex align-items-center gap-2 mt-2">
              <label class="small mb-0" for="ordem_img_<?= $s ?>_<?= $idImg ?>">Ordem</label>
              <input type="number" name="ordem_img[<?= $idImg ?>]" id="ordem_img_<?= $s ?>_<?= $idImg ?>"
                class="form-control form-control-sm" style="width: 70px;" value="<?= (int) $img['ordem_imagem'] ?>">
            </div>

            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" name="remover_img[]" value="<?= $idImg ?>"
                id="remover_img_<?= $s ?>_<?= $idImg ?>">
              <label class="form-check-label small text-danger" for="remover_img_<?= $s ?>_<?= $idImg ?>">Remover</label>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ($vagasGaleria > 0): ?>
    <input type="file" name="galeria[]" class="form-control galeria-input" multiple
      accept="image/jpeg,image/png,image/webp,image/gif"
      data-vagas="<?= (int) $vagasGaleria ?>">
    <small class="galeria-aviso text-danger d-block mt-1"></small>
    <small class="text-muted">Você pode escolher várias fotos de uma vez. Elas aparecem em grade no fim do post, e a pessoa clica para ampliar.
      Depois de salvar, volte aqui para escrever as legendas e mudar a ordem.</small>
  <?php else: ?>
    <div class="alert alert-info py-2 mb-0">Esta galeria já tem o máximo de <?= (int) $limiteGaleria ?> fotos. Remova alguma para enviar novas.</div>
  <?php endif; ?>
</div>

<div class="col-md-3">
  <label class="form-label" for="status_post_<?= $s ?>">Status</label>
  <select name="status_post" id="status_post_<?= $s ?>" class="form-select">
    <option value="rascunho" <?= $post['status_post'] === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
    <option value="publicado" <?= $post['status_post'] === 'publicado' ? 'selected' : '' ?>>Publicado</option>
  </select>
  <small class="text-muted">Rascunho não aparece no site.</small>
</div>

<div class="col-md-3">
  <label class="form-label" for="data_publicacao_post_<?= $s ?>">Data de publicação</label>
  <input type="datetime-local" name="data_publicacao_post" id="data_publicacao_post_<?= $s ?>" class="form-control"
    value="<?= $e($dataPub) ?>">
  <small class="text-muted">Vazio = publica agora. Data futura = agenda o post.</small>
</div>
