<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
</head>

<?php
// Escapa texto para exibir em HTML
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
?>

<?php if (!empty($flash)): ?>
  <div class="alert alert-<?= $flash['tipo'] === 'erro' ? 'danger' : 'success' ?>">
    <?= $e($flash['msg']) ?>
  </div>
<?php endif; ?>


<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h4 class="mb-0">Categorias do blog</h4>
  <a href="/blogadmin" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Voltar aos posts</a>
</div>


<form action="/blogadmin/salvarCategoria" method="POST" class="row g-3 mb-4">
  <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">

  <div class="col-md-6">
    <label class="form-label" for="nome_categoria_blog">Nova categoria</label>
    <input type="text" name="nome_categoria_blog" id="nome_categoria_blog" class="form-control"
      maxlength="100" required placeholder="Ex: Eventos">
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Adicionar</button>
  </div>
</form>


<?php if (empty($categorias)): ?>

  <div class="alert alert-info">Nenhuma categoria cadastrada ainda.</div>

<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Endereço no site</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categorias as $c): ?>
          <tr>
            <td><strong><?= $e($c['nome_categoria_blog']) ?></strong></td>
            <td><small class="text-muted">/blog/categoria/<?= $e($c['slug_categoria_blog']) ?></small></td>
            <td class="text-end">
              <form action="/blogadmin/excluirCategoria/<?= (int) $c['id_categoria_blog'] ?>" method="POST" class="d-inline"
                onsubmit="return confirm('Excluir esta categoria? Os posts dela ficarão sem categoria.');">
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
