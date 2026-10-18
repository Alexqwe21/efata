<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.min.css">
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
  <h4 class="mb-0">Posts do blog</h4>

  <div class="d-flex gap-2">
    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCategorias">
      <i class="bi bi-tags"></i> Categorias
    </button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovoPost">
      <i class="bi bi-plus-lg"></i> Novo post
    </button>
  </div>
</div>


<?php if (empty($posts)): ?>

  <div class="alert alert-info">Nenhum post cadastrado ainda. Clique em <strong>Novo post</strong> para começar.</div>

<?php else: ?>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead>
        <tr>
          <th>Título</th>
          <th>Categoria</th>
          <th>Autor</th>
          <th>Status</th>
          <th>Publicação</th>
          <th class="text-end">Ações</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($posts as $p): ?>
          <?php
          $publicado = $p['status_post'] === 'publicado';
          $agendado  = $publicado && !empty($p['data_publicacao_post']) && strtotime($p['data_publicacao_post']) > time();
          ?>
          <tr>
            <td>
              <strong><?= $e($p['titulo_post']) ?></strong><br>
              <small class="text-muted">/blog/ver/<?= $e($p['slug_post']) ?></small>
            </td>

            <td>
              <?php if (!empty($p['nome_categoria_blog'])): ?>
                <?= $e($p['nome_categoria_blog']) ?>
              <?php else: ?>
                <span class="text-muted">Sem categoria</span>
              <?php endif; ?>
            </td>

            <td><?= $e($p['nome_funcionario']) ?></td>

            <td>
              <?php if ($agendado): ?>
                <span class="badge bg-info text-dark">Agendado</span>
              <?php elseif ($publicado): ?>
                <span class="badge bg-success">Publicado</span>
              <?php else: ?>
                <span class="badge bg-secondary">Rascunho</span>
              <?php endif; ?>
            </td>

            <td>
              <?= !empty($p['data_publicacao_post']) ? date('d/m/Y H:i', strtotime($p['data_publicacao_post'])) : '—' ?>
            </td>

            <td class="text-end text-nowrap">
              <?php if ($publicado && !$agendado): ?>
                <a href="/blog/ver/<?= $e($p['slug_post']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Ver no site">
                  <i class="bi bi-box-arrow-up-right"></i>
                </a>
              <?php endif; ?>

              <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarPost<?= (int) $p['id_post'] ?>">
                Editar
              </button>

              <form action="/blogadmin/excluir/<?= (int) $p['id_post'] ?>" method="POST" class="d-inline"
                onsubmit="return confirm('Excluir este post? Essa ação não pode ser desfeita.');">
                <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">
                <input type="hidden" name="pagina" value="<?= (int) $pagina ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
  </div>


  <?php if ($totalPaginas > 1): ?>
    <nav aria-label="Paginação">
      <ul class="pagination justify-content-center">
        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="/blogadmin?pagina=<?= $pagina - 1 ?>">Anterior</a>
        </li>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
            <a class="page-link" href="/blogadmin?pagina=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
          <a class="page-link" href="/blogadmin?pagina=<?= $pagina + 1 ?>">Próxima</a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>

<?php endif; ?>




<!-- MODAL: NOVO POST -->
<div class="modal fade modal-post" id="modalNovoPost" tabindex="-1" aria-labelledby="labelNovoPost" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="/blogadmin/salvar" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">
        <input type="hidden" name="pagina" value="<?= (int) $pagina ?>">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="labelNovoPost">Novo post</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body row g-3">
          <?php $this->carregarViews('dash/blog/_campos', [
            'post'       => $postNovo,
            'categorias' => $categorias,
            'sufixo'     => 'Novo',
            'imagens'    => [],
            'limiteGaleria' => $limiteGaleria ?? 20,
          ]); ?>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Salvar post</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- MODAIS: EDITAR POST (um por post) -->
<?php foreach ($posts as $p): ?>
  <div class="modal fade modal-post" id="modalEditarPost<?= (int) $p['id_post'] ?>" tabindex="-1" aria-labelledby="labelEditarPost<?= (int) $p['id_post'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form action="/blogadmin/atualizar/<?= (int) $p['id_post'] ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">
          <input type="hidden" name="pagina" value="<?= (int) $pagina ?>">

          <div class="modal-header bg-warning text-dark">
            <h5 class="modal-title" id="labelEditarPost<?= (int) $p['id_post'] ?>">Editar post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>

          <div class="modal-body row g-3">
            <?php $this->carregarViews('dash/blog/_campos', [
              'post'       => $p,
              'categorias' => $categorias,
              'sufixo'     => (int) $p['id_post'],
              'imagens'    => $imagens[(int) $p['id_post']] ?? [],
              'limiteGaleria' => $limiteGaleria ?? 20,
            ]); ?>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Salvar alterações</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>



<!-- MODAL: CATEGORIAS -->
<div class="modal fade" id="modalCategorias" tabindex="-1" aria-labelledby="labelCategorias" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="labelCategorias">Categorias do blog</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <div class="modal-body">

        <form action="/blogadmin/salvarCategoria" method="POST" class="row g-2 mb-4">
          <input type="hidden" name="csrf" value="<?= $e($csrf) ?>">
          <input type="hidden" name="pagina" value="<?= (int) $pagina ?>">

          <div class="col-sm-9">
            <label class="form-label" for="nome_categoria_blog">Nova categoria</label>
            <input type="text" name="nome_categoria_blog" id="nome_categoria_blog" class="form-control"
              maxlength="100" required placeholder="Ex: Eventos">
          </div>

          <div class="col-sm-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Adicionar</button>
          </div>
        </form>

        <?php if (empty($categorias)): ?>

          <div class="alert alert-info mb-0">Nenhuma categoria cadastrada ainda.</div>

        <?php else: ?>

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
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
                        <input type="hidden" name="pagina" value="<?= (int) $pagina ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        <?php endif; ?>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>

    </div>
  </div>
</div>



<style>
  .modal-post .ql-editor img { max-width: 100%; height: auto; }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    var barra = [
      [{ header: [2, 3, false] }],
      ['bold', 'italic', 'underline'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      ['blockquote', 'link', 'image'],
      ['clean']
    ];

    // Botão de foto do editor: envia o arquivo para o servidor e coloca a imagem onde está o cursor
    function enviarImagemDoEditor(quill, modal) {
      var seletor = document.createElement('input');
      seletor.type = 'file';
      seletor.accept = 'image/jpeg,image/png,image/webp,image/gif';

      seletor.addEventListener('change', function() {
        var arquivo = seletor.files && seletor.files[0];
        if (!arquivo) return;

        if (arquivo.size > 3 * 1024 * 1024) {
          alert('A imagem deve ter no máximo 3 MB.');
          return;
        }

        var dados = new FormData();
        dados.append('csrf', modal.querySelector('input[name="csrf"]').value);
        dados.append('imagem', arquivo);

        var posicao = (quill.getSelection(true) || { index: quill.getLength() }).index;

        fetch('/blogadmin/uploadImagem', { method: 'POST', body: dados })
          .then(function(r) { return r.json(); })
          .then(function(res) {
            if (!res.ok) {
              alert(res.erro || 'Não foi possível enviar a imagem.');
              return;
            }

            quill.insertEmbed(posicao, 'image', res.url, 'user');

            var descricao = window.prompt('Descreva a imagem em poucas palavras (para acessibilidade e Google). Pode deixar em branco.', '');
            if (descricao) {
              quill.formatText(posicao, 1, 'alt', descricao, 'user');
            }

            quill.setSelection(posicao + 1, 0);
          })
          .catch(function() { alert('Não foi possível enviar a imagem. Tente novamente.'); });
      });

      seletor.click();
    }

    document.querySelectorAll('.modal-post').forEach(function(modal) {
      var campo = modal.querySelector('.conteudo-post');
      var quill = null;

      // O editor só é criado na primeira vez que o modal abre
      modal.addEventListener('shown.bs.modal', function() {
        if (quill) return;

        quill = new Quill(modal.querySelector('.editor-post'), {
          theme: 'snow',
          placeholder: 'Escreva o conteúdo do post...',
          modules: {
            toolbar: {
              container: barra,
              handlers: { image: function() { enviarImagemDoEditor(quill, modal); } }
            }
          }
        });

        if (campo.value.trim() !== '') {
          quill.clipboard.dangerouslyPasteHTML(campo.value);
        }
      });

      // Antes de enviar, copia o HTML do editor para o campo escondido
      modal.querySelector('form').addEventListener('submit', function() {
        if (quill) {
          campo.value = quill.getText().trim() === '' ? '' : quill.root.innerHTML;
        }
      });

      // Galeria: avisa na hora se alguma foto passa de 3 MB ou se são fotos demais
      var galeria = modal.querySelector('.galeria-input');
      if (galeria) {
        galeria.addEventListener('change', function() {
          var aviso = modal.querySelector('.galeria-aviso');
          var vagas = parseInt(galeria.dataset.vagas, 10) || 0;
          var problema = '';

          if (galeria.files.length > vagas) {
            problema = 'Você pode enviar mais ' + vagas + ' foto(s) neste post.';
          }

          Array.prototype.forEach.call(galeria.files, function(f) {
            if (f.size > 3 * 1024 * 1024) {
              problema = '"' + f.name + '" passa de 3 MB. Reduza a foto e escolha de novo.';
            }
          });

          aviso.textContent = problema;
          if (problema) {
            galeria.value = '';
          }
        });
      }

      // Prévia da capa
      var input = modal.querySelector('.foto-post');
      var preview = modal.querySelector('.preview-capa');

      input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });

    <?php if (!empty($abrir)): ?>
      // Reabre o modal depois de um envio (erro de validação ou ação de categoria)
      var alvo = document.getElementById(<?= json_encode($abrir) ?>);
      if (alvo) {
        bootstrap.Modal.getOrCreateInstance(alvo).show();
      }
    <?php endif; ?>

  });
</script>
