<?php
// app/views/dash/blog/comentarios.php  (carregada dentro do layout dash/dashboard)
$e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

$abas = [
    'pendente' => ['Pendentes', 'warning text-dark'],
    'aprovado' => ['Aprovados', 'success'],
    'spam'     => ['Spam',      'secondary'],
];

// Botão de ação (cada um é um mini-formulário POST com o token de segurança)
$botao = function ($acao, $id, $rotulo, $classe, $confirmar = '') use ($e, $csrf, $status, $pagina) {
    $js = $confirmar ? ' onsubmit="return confirm(\'' . $e($confirmar) . '\')"' : '';
    return '<form method="post" action="/blogcomentarios/' . $acao . '/' . (int) $id . '" class="d-inline"' . $js . '>'
        . '<input type="hidden" name="csrf" value="' . $e($csrf) . '">'
        . '<input type="hidden" name="status" value="' . $e($status) . '">'
        . '<input type="hidden" name="pagina" value="' . (int) $pagina . '">'
        . '<button type="submit" class="btn btn-sm ' . $classe . '">' . $rotulo . '</button>'
        . '</form> ';
};
?>

<?php if (!empty($flash)): ?>
  <div class="alert alert-<?= $flash['tipo'] === 'erro' ? 'danger' : 'success' ?>"><?= $e($flash['msg']) ?></div>
<?php endif; ?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
  <h4 class="mb-0">Comentários do blog</h4>
  <a href="/blogadmin" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Posts</a>
</div>

<ul class="nav nav-pills mb-3">
  <?php foreach ($abas as $chave => $info): ?>
    <li class="nav-item me-2">
      <a class="nav-link <?= $status === $chave ? 'active' : '' ?>" href="/blogcomentarios?status=<?= $chave ?>">
        <?= $info[0] ?>
        <span class="badge bg-<?= $info[1] ?>"><?= (int) $totais[$chave] ?></span>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<?php if (empty($comentarios)): ?>

  <div class="alert alert-info">Nenhum comentário nesta aba.</div>

<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th style="width:18%">Quem</th>
          <th>Comentário</th>
          <th style="width:18%">Post</th>
          <th style="width:12%">Data</th>
          <th class="text-end" style="width:20%">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($comentarios as $c): ?>
          <tr>
            <td>
              <strong><?= $e($c['nome_comentario']) ?></strong>
              <?php if (!empty($c['email_comentario'])): ?>
                <br><small class="text-muted"><?= $e($c['email_comentario']) ?></small>
              <?php endif; ?>
            </td>
            <td style="white-space:normal"><?= nl2br($e($c['texto_comentario'])) ?></td>
            <td>
              <a href="/blog/ver/<?= $e($c['slug_post']) ?>" target="_blank" rel="noopener"><?= $e($c['titulo_post']) ?></a>
            </td>
            <td><small><?= $e(date('d/m/Y H:i', strtotime($c['data_cadastro_comentario']))) ?></small></td>
            <td class="text-end">
              <?php if ($status !== 'aprovado'): ?>
                <?= $botao('aprovar', $c['id_comentario'], 'Aprovar', 'btn-success') ?>
              <?php endif; ?>
              <?php if ($status === 'pendente'): ?>
                <?= $botao('spam', $c['id_comentario'], 'Spam', 'btn-outline-secondary') ?>
              <?php elseif ($status === 'aprovado'): ?>
                <?= $botao('pendente', $c['id_comentario'], 'Ocultar', 'btn-outline-secondary') ?>
              <?php endif; ?>
              <?= $botao('excluir', $c['id_comentario'], 'Excluir', 'btn-outline-danger', 'Excluir este comentário de vez?') ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if ($totalPaginas > 1): ?>
    <nav>
      <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
            <a class="page-link" href="/blogcomentarios?status=<?= $e($status) ?>&pagina=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>

<?php endif; ?>
