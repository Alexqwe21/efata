<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
</head>

<?php
// Escapa texto para exibir em HTML
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

// Campos do formulário (iguais nos modais de nova pergunta e de edição)
$campos = function ($p) use ($e) {
  $id = (int) $p['id_pergunta'];
?>
  <div class="col-12">
    <label class="form-label" for="pergunta<?= $id ?>">Pergunta (aparece como botão no chat)</label>
    <input type="text" name="pergunta_chat" id="pergunta<?= $id ?>" class="form-control"
      maxlength="150" required value="<?= $e($p['pergunta_chat']) ?>" placeholder="Ex: Como faço a matrícula?">
  </div>

  <div class="col-12">
    <label class="form-label" for="resposta<?= $id ?>">Resposta do leão</label>
    <textarea name="resposta_chat" id="resposta<?= $id ?>" class="form-control" rows="5"
      maxlength="2000" required><?= $e($p['resposta_chat']) ?></textarea>
  </div>

  <div class="col-md-5">
    <label class="form-label" for="textoLink<?= $id ?>">Texto do botão <small class="text-muted">(opcional)</small></label>
    <input type="text" name="texto_link_chat" id="textoLink<?= $id ?>" class="form-control"
      maxlength="60" value="<?= $e($p['texto_link_chat']) ?>" placeholder="Ex: Fazer matrícula">
  </div>

  <div class="col-md-7">
    <label class="form-label" for="urlLink<?= $id ?>">Link do botão <small class="text-muted">(opcional)</small></label>
    <input type="text" name="url_link_chat" id="urlLink<?= $id ?>" class="form-control"
      maxlength="255" value="<?= $e($p['url_link_chat']) ?>" placeholder="Ex: /matricula ou https://...">
  </div>

  <div class="col-md-3">
    <label class="form-label" for="ordem<?= $id ?>">Ordem</label>
    <input type="number" name="ordem_chat" id="ordem<?= $id ?>" class="form-control"
      value="<?= (int) $p['ordem_chat'] ?>">
    <small class="text-muted">Menor aparece primeiro</small>
  </div>

  <div class="col-md-9 d-flex align-items-center">
    <div class="form-check form-switch mt-3">
      <input class="form-check-input" type="checkbox" name="ativo_chat" value="1" id="ativo<?= $id ?>"
        <?= !empty($p['ativo_chat']) ? 'checked' : '' ?>>
      <label class="form-check-label" for="ativo<?= $id ?>">Mostrar no site</label>
    </div>
  </div>
<?php
};
?>

<?php if (!empty($flash)): ?>
  <div class="alert alert-<?= $flash['tipo'] === 'erro' ? 'danger' : 'success' ?>">
    <?= $e($flash['msg']) ?>
  </div>
<?php endif; ?>


<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <div>
    <h4 class="mb-0">Chat do leão</h4>
    <small class="text-muted">Perguntas e respostas prontas do balão flutuante do site. O botão do WhatsApp aparece sempre.</small>
  </div>

  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovaPergunta">
    <i class="bi bi-plus-lg"></i> Nova pergunta
  </button>
</div>


<?php if (empty($perguntas)): ?>

  <div class="alert alert-info">Nenhuma pergunta cadastrada ainda. Clique em <strong>Nova pergunta</strong> para começar.</div>

<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th style="width: 70px;">Ordem</th>
          <th>Pergunta</th>
          <th>Botão</th>
          <th>Status</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($perguntas as $p): ?>
          <tr>
            <td><?= (int) $p['ordem_chat'] ?></td>
            <td>
              <strong><?= $e($p['pergunta_chat']) ?></strong><br>
              <small class="text-muted"><?= $e(mb_strimwidth($p['resposta_chat'], 0, 90, '...')) ?></small>
            </td>
            <td>
              <?php if (!empty($p['url_link_chat'])): ?>
                <small><?= $e($p['texto_link_chat']) ?><br><span class="text-muted"><?= $e($p['url_link_chat']) ?></span></small>
              <?php else: ?>
                <small class="text-muted">—</small>
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($p['ativo_chat'])): ?>
                <span class="badge bg-success">No site</span>
              <?php else: ?>
                <span class="badge bg-secondary">Oculta</span>
              <?php endif; ?>
            </td>
            <td class="text-end text-nowrap">
              <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modalEditarPergunta<?= (int) $p['id_pergunta'] ?>">Editar</button>

              <form action="/chatadmin/excluir/<?= (int) $p['id_pergunta'] ?>" method="POST" class="d-inline"
                onsubmit="return confirm('Excluir esta pergunta do chat?');">
                <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php endif; ?>


<!-- Modal: nova pergunta -->
<div class="modal fade" id="modalNovaPergunta" tabindex="-1" aria-labelledby="labelNovaPergunta" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/chatadmin/salvar" method="POST">
        <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="labelNovaPergunta">Nova pergunta</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body row g-3">
          <?php $campos($nova); ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modais: editar pergunta -->
<?php foreach ($perguntas as $p): ?>
  <div class="modal fade" id="modalEditarPergunta<?= (int) $p['id_pergunta'] ?>" tabindex="-1"
    aria-labelledby="labelEditarPergunta<?= (int) $p['id_pergunta'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="/chatadmin/atualizar/<?= (int) $p['id_pergunta'] ?>" method="POST">
          <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">

          <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="labelEditarPergunta<?= (int) $p['id_pergunta'] ?>">Editar pergunta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>

          <div class="modal-body row g-3">
            <?php $campos($p); ?>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-warning">Salvar alterações</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>


<?php if (!empty($abrir)): ?>
  <script>
    // Reabre o modal depois de um erro de validação (o bootstrap.js carrega no fim do painel)
    document.addEventListener('DOMContentLoaded', function() {
      var alvo = document.getElementById(<?= json_encode($abrir) ?>);
      if (alvo) {
        bootstrap.Modal.getOrCreateInstance(alvo).show();
      }
    });
  </script>
<?php endif; ?>
