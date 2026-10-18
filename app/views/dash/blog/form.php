<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
</head>

<?php
// Escapa texto para exibir em HTML
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$dataPub = !empty($post['data_publicacao_post'])
  ? date('Y-m-d\TH:i', strtotime($post['data_publicacao_post']))
  : '';

$fotoAtual = !empty($post['foto_post']) ? '/' . ltrim($post['foto_post'], '/') : '';
?>


<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h4 class="mb-0"><?= $e($tituloPagina) ?></h4>
  <a href="/blogadmin" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>


<?php if (!empty($erros)): ?>
  <div class="alert alert-danger">
    <strong>Corrija os pontos abaixo:</strong>
    <ul class="mb-0">
      <?php foreach ($erros as $erro): ?>
        <li><?= $e($erro) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>


<form id="formPost" action="<?= $e($acao) ?>" method="POST" enctype="multipart/form-data" class="row g-3">

  <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">

  <div class="col-md-8">
    <label class="form-label" for="titulo_post">Título</label>
    <input type="text" name="titulo_post" id="titulo_post" class="form-control" maxlength="200" required
      placeholder="Ex: Como foi o nosso último treino"
      value="<?= $e($post['titulo_post']) ?>">
  </div>

  <div class="col-md-4">
    <label class="form-label" for="id_categoria_blog">Categoria</label>
    <select name="id_categoria_blog" id="id_categoria_blog" class="form-select">
      <option value="">Sem categoria</option>
      <?php foreach ($categorias as $c): ?>
        <option value="<?= (int) $c['id_categoria_blog'] ?>"
          <?= (int) $post['id_categoria_blog'] === (int) $c['id_categoria_blog'] ? 'selected' : '' ?>>
          <?= $e($c['nome_categoria_blog']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <small class="text-muted">
      <a href="/blogadmin/categorias">Gerenciar categorias</a>
    </small>
  </div>


  <div class="col-12">
    <label class="form-label" for="resumo_post">Resumo <small class="text-muted">(aparece na lista de posts, até 300 caracteres)</small></label>
    <textarea name="resumo_post" id="resumo_post" class="form-control" rows="2" maxlength="300"><?= $e($post['resumo_post']) ?></textarea>
  </div>


  <div class="col-12">
    <label class="form-label">Conteúdo</label>
    <div id="editor" style="min-height: 320px; background: #fff;"></div>
    <textarea name="conteudo_post" id="conteudo_post" style="display: none;"><?= $e($post['conteudo_post']) ?></textarea>
  </div>


  <div class="col-md-6">
    <label class="form-label" for="foto_post">Imagem de capa <small class="text-muted">(JPG, PNG, WEBP ou GIF, até 3 MB)</small></label>
    <input type="file" name="foto_post" id="foto_post" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">

    <div class="mt-2">
      <img id="preview-capa" src="<?= $e($fotoAtual) ?>" alt="Prévia da capa"
        style="max-width: 100%; max-height: 220px; object-fit: cover; border: 1px solid #ccc; padding: 4px; <?= $fotoAtual === '' ? 'display: none;' : '' ?>">
    </div>

    <?php if ($fotoAtual !== ''): ?>
      <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" name="remover_foto" id="remover_foto" value="1">
        <label class="form-check-label" for="remover_foto">Remover a imagem atual</label>
      </div>
    <?php endif; ?>

    <label class="form-label mt-3" for="alt_foto_post">Texto alternativo da imagem <small class="text-muted">(descrição para acessibilidade e Google)</small></label>
    <input type="text" name="alt_foto_post" id="alt_foto_post" class="form-control" maxlength="255"
      value="<?= $e($post['alt_foto_post']) ?>">
  </div>


  <div class="col-md-3">
    <label class="form-label" for="status_post">Status</label>
    <select name="status_post" id="status_post" class="form-select">
      <option value="rascunho" <?= $post['status_post'] === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
      <option value="publicado" <?= $post['status_post'] === 'publicado' ? 'selected' : '' ?>>Publicado</option>
    </select>
    <small class="text-muted">Rascunho não aparece no site.</small>
  </div>

  <div class="col-md-3">
    <label class="form-label" for="data_publicacao_post">Data de publicação</label>
    <input type="datetime-local" name="data_publicacao_post" id="data_publicacao_post" class="form-control"
      value="<?= $e($dataPub) ?>">
    <small class="text-muted">Vazio = publica agora. Data futura = agenda o post.</small>
  </div>


  <div class="col-12 d-flex gap-2">
    <button type="submit" class="btn btn-success">Salvar post</button>
    <a href="/blogadmin" class="btn btn-secondary">Cancelar</a>
  </div>

</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    // ---- Editor de texto ----
    const campo = document.getElementById('conteudo_post');

    const quill = new Quill('#editor', {
      theme: 'snow',
      placeholder: 'Escreva o conteúdo do post...',
      modules: {
        toolbar: [
          [{ header: [2, 3, false] }],
          ['bold', 'italic', 'underline'],
          [{ list: 'ordered' }, { list: 'bullet' }],
          ['blockquote', 'link'],
          ['clean']
        ]
      }
    });

    if (campo.value.trim() !== '') {
      quill.clipboard.dangerouslyPasteHTML(campo.value);
    }

    // Antes de enviar, copia o HTML do editor para o campo escondido
    document.getElementById('formPost').addEventListener('submit', function() {
      campo.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML;
    });


    // ---- Prévia da capa ----
    const input = document.getElementById('foto_post');
    const preview = document.getElementById('preview-capa');

    input.addEventListener('change', function() {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          preview.src = ev.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    });

  });
</script>
