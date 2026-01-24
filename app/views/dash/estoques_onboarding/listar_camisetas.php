<style>
  body {
    text-transform: uppercase;
  }

  .btn-admin-export {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background-color: #198754;
    /* Verde Bootstrap */
    color: #fff;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s;
    margin-left: 20px;
  }

  .btn-admin-export:hover {
    background-color: #157347;
    text-decoration: none;
  }

  .btn-admin-export i {
    font-size: 18px;
  }

  table,
  .modal-content,
  .form-control {
    text-transform: uppercase !important;
  }
</style>




<?php if (isset($_SESSION['sucesso'])): ?>
  <div class="alert alert-success">
    <?php echo $_SESSION['sucesso'];
    unset($_SESSION['sucesso']); ?>
  </div>
<?php endif; ?>





<form method="GET" class="row g-3 mb-4">

  <!-- STATUS -->
  <div class="col-md-2">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
      <option value="">Todos</option>
      <option value="Ativo" <?= (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : '' ?>>
        Ativo
      </option>
      <option value="Inativo" <?= (isset($_GET['status']) && $_GET['status'] == 'Inativo') ? 'selected' : '' ?>>
        Inativo
      </option>
    </select>
  </div>

  <!-- NOME PRODUTO -->
  <div class="col-md-3">
    <label for="nome" class="form-label">Produto</label>
    <input type="text"
      name="nome"
      id="nome"
      class="form-control"
      placeholder="Ex: Papel A4"
      value="<?= isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '' ?>">
  </div>

  <!-- CATEGORIA -->
  <div class="col-md-3">
    <label for="categoria" class="form-label">Categoria</label>
    <select name="categoria" id="categoria" class="form-select">
      <option value="">Todas</option>
      <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat['id_categoria'] ?>"
          <?= (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['nome_categoria']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- SALDO -->
  <div class="col-md-2">
    <label for="saldo" class="form-label">Saldo</label>
    <select name="saldo" id="saldo" class="form-select">
      <option value="">Todos</option>
      <option value="positivo" <?= (isset($_GET['saldo']) && $_GET['saldo'] == 'positivo') ? 'selected' : '' ?>>
        Com saldo
      </option>
      <option value="zerado" <?= (isset($_GET['saldo']) && $_GET['saldo'] == 'zerado') ? 'selected' : '' ?>>
        Zerado
      </option>
    </select>
  </div>

  <!-- UNIDADE -->
  <div class="col-md-2">
    <label for="unidade" class="form-label">Unidade</label>
    <select name="unidade" id="unidade" class="form-select">
      <option value="">Todas</option>
      <option value="Un" <?= (isset($_GET['unidade']) && $_GET['unidade'] == 'Un') ? 'selected' : '' ?>>Un</option>
      <option value="Cx" <?= (isset($_GET['unidade']) && $_GET['unidade'] == 'Cx') ? 'selected' : '' ?>>Cx</option>
      <option value="Kg" <?= (isset($_GET['unidade']) && $_GET['unidade'] == 'Kg') ? 'selected' : '' ?>>Kg</option>
      <option value="L" <?= (isset($_GET['unidade']) && $_GET['unidade'] == 'L') ? 'selected' : '' ?>>L</option>
      <option value="Pct" <?= (isset($_GET['unidade']) && $_GET['unidade'] == 'Pct') ? 'selected' : '' ?>>Pct</option>
    </select>
  </div>

  <!-- BOTÕES -->
  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">
      <i class="bi bi-funnel"></i> Filtrar
    </button>
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <a href="<?= BASE_URL ?>/Onboarding/bank" class="btn btn-outline-secondary w-100">
      Limpar
    </a>
  </div>

</form>





<!-- <div class="mb-3" style="display: flex; align-items: center;">
  <a href="/matricula/exportarPDF<?= $queryString ?>" target="_blank" class="btn btn-danger">
    <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
  </a>
  <a href="/matricula/exportarExcel?filtro=&status="
    class="btn-admin-export"
    target="_blank">
    <i class='bx bx-file'></i> Exportar Excel
  </a>
</div> -->

<div class="mb-3 d-flex justify-content-between align-items-center">
  <h5 class="mb-0">ESTOQUE DE CAMISETAS<h5>



  <button class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#modalCadastrarEstoque">
    <i class="bi bi-plus-circle"></i> Cadastrar Item
  </button>








</div>


<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Produto</th>
      <th>Categoria</th>
      <th>Unidade</th>
      <th>Saldo</th>
      <th>Status</th>
      <th>Ações</th>
      <th>Editar</th>
    </tr>
  </thead>

  <tbody>
    <?php if (!empty($produtos)): ?>
      <?php foreach ($produtos as $produto):


        // var_dump($produto);
        // exit;

      ?>



        <tr>
          <td><?= htmlspecialchars($produto['nome_produto']) ?></td>

          <td>
            <?= !empty($produto['nome_categoria'])
              ? htmlspecialchars($produto['nome_categoria'])
              : '<span class="text-muted">Sem categoria</span>' ?>
          </td>

          <td><?= htmlspecialchars($produto['unidade']) ?></td>

          <td>
            <span class="badge bg-<?= $produto['saldo'] > 0 ? 'success' : 'danger' ?>">
              <?= (int)$produto['saldo'] ?>
            </span>
          </td>

          <td>
            <span class="badge <?= $produto['status_produto'] == 'Ativo' ? 'bg-success' : 'bg-secondary' ?>">
              <?= htmlspecialchars($produto['status_produto']) ?>
            </span>
          </td>

          <td class="d-flex gap-1">
            <button class="btn btn-primary btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#verProduto<?= $produto['id_produto'] ?>">
              Ver
            </button>

            <button class="btn btn-success btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#entradaProduto<?= $produto['id_produto'] ?>">
              Entrada
            </button>

            <button class="btn btn-danger btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#saidaProduto<?= $produto['id_produto'] ?>">
              Saída
            </button>
          </td>

          <td>
            <button class="btn btn-warning btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#editarProduto<?= $produto['id_produto'] ?>">
              Editar
            </button>
          </td>
        </tr>

        <!-- ================= MODAL VER PRODUTO ================= -->
        <div class="modal fade" id="verProduto<?= $produto['id_produto'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detalhes do Produto</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
              </div>

              <div class="modal-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <strong>Produto:</strong>
                    <div><?= htmlspecialchars($produto['nome_produto']) ?></div>
                  </div>

                  <div class="col-md-6">
                    <strong>Categoria:</strong>
                    <div>
                      <?= $produto['nome_categoria']
                        ? htmlspecialchars($produto['nome_categoria'])
                        : '<span class="text-muted">Sem categoria</span>' ?>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <strong>Unidade:</strong>
                    <div><?= htmlspecialchars($produto['unidade']) ?></div>
                  </div>

                  <div class="col-md-4">
                    <strong>Saldo:</strong>
                    <span class="badge bg-<?= $produto['saldo'] > 0 ? 'success' : 'danger' ?>">
                      <?= (int)$produto['saldo'] ?>
                    </span>
                  </div>

                  <div class="col-md-4">
                    <strong>Status:</strong>
                    <span class="badge <?= $produto['status_produto'] == 'Ativo' ? 'bg-success' : 'bg-secondary' ?>">
                      <?= $produto['status_produto'] ?>
                    </span>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              </div>

            </div>
          </div>
        </div>

        <!-- ================= MODAL EDITAR PRODUTO ================= -->
        <!-- MODAL EDITAR PRODUTO -->
        <div class="modal fade" id="editarProduto<?= $produto['id_produto'] ?>" tabindex="-1">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

              <form action="<?= BASE_URL ?>/Onboarding/atualizar/<?= $produto['id_produto'] ?>" method="POST">
  <input type="hidden" name="id_estoque" value="3">
                <div class="modal-header bg-warning">
                  <h5 class="modal-title">
                    <i class="bi bi-pencil-square"></i> Editar Produto
                  </h5>
                  <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <div class="row g-3">

                    <!-- NOME -->
                    <div class="col-md-8">
                      <label class="form-label">Nome do Produto *</label>
                      <input type="text" name="nome_produto" class="form-control"
                        value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>
                    </div>

                    <!-- UNIDADE -->
                    <div class="col-md-4">
                      <label class="form-label">Unidade *</label>
                      <select name="unidade" class="form-select" required>
                        <?php
                        $unidades = ['Un', 'Cx', 'Kg', 'L', 'Pct'];
                        foreach ($unidades as $u):
                        ?>
                          <option value="<?= $u ?>" <?= $produto['unidade'] == $u ? 'selected' : '' ?>>
                            <?= $u ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <!-- CATEGORIA EXISTENTE -->
                    <div class="col-md-6">
                      <label class="form-label">Categoria existente</label>
                      <select name="id_categoria" class="form-select">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categorias as $categoria): ?>
                          <option value="<?= $categoria['id_categoria'] ?>"
                            <?= ($produto['id_categoria'] ?? null) == $categoria['id_categoria'] ? 'selected' : '' ?>>
                            <?= $categoria['nome_categoria'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <!-- NOVA CATEGORIA -->
                    <div class="col-md-6">
                      <label class="form-label">Ou criar nova categoria</label>
                      <input type="text" name="nova_categoria" class="form-control"
                        placeholder="Ex: Material de Escritório">
                    </div>

                    <!-- STATUS -->
                    <div class="col-md-6">
                      <label class="form-label">Status</label>
                      <select name="status_produto" class="form-select">
                        <option value="Ativo" <?= $produto['status_produto'] == 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="Inativo" <?= $produto['status_produto'] == 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                      </select>
                    </div>

                    <!-- DESCRIÇÃO -->
                    <div class="col-12">
                      <label class="form-label">Descrição</label>
                      <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                    </div>

                  </div>
                </div>

                <div class="modal-footer">
                  <button class="btn btn-success px-4">
                    <i class="bi bi-check-circle"></i> Salvar
                  </button>
                  <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Cancelar
                  </button>
                </div>

              </form>

            </div>
          </div>
        </div>

        <!-- ================= MODAL ENTRADA ================= -->
        <div class="modal fade" id="entradaProduto<?= $produto['id_produto'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <form action="<?= BASE_URL ?>/Onboarding/movimentar" method="POST">
                  <input type="hidden" name="id_estoque" value="3">
                <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                <input type="hidden" name="tipo" value="Entrada">

                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title">Entrada de Estoque</h5>
                  <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <label class="form-label">Quantidade</label>
                  <input type="number" name="quantidade" class="form-control" min="1" required>

                  <label class="form-label mt-2">Motivo</label>
                  <input type="text" name="motivo" class="form-control">
                </div>

                <div class="modal-footer">
                  <button class="btn btn-success">Confirmar</button>
                </div>
              </form>

            </div>
          </div>
        </div>

        <!-- ================= MODAL SAÍDA ================= -->
        <div class="modal fade" id="saidaProduto<?= $produto['id_produto'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <form action="<?= BASE_URL ?>/Onboarding/movimentar" method="POST">
                  <input type="hidden" name="id_estoque" value="3">
                <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                <input type="hidden" name="tipo" value="Saida">

                <div class="modal-header bg-danger text-white">
                  <h5 class="modal-title">Saída de Estoque</h5>
                  <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <label class="form-label">Quantidade</label>
                  <input type="number" name="quantidade" class="form-control" min="1" required>

                  <label class="form-label mt-2">Motivo</label>
                  <input type="text" name="motivo" class="form-control">
                </div>

                <div class="modal-footer">
                  <button class="btn btn-danger">Confirmar</button>
                </div>
              </form>

            </div>
          </div>
        </div>

      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="text-center text-muted">
          Nenhum produto cadastrado no estoque.
        </td>
      </tr>
    <?php endif; ?>
  </tbody>


</table>



<!-- MODAL CADASTRAR PRODUTO -->
<!-- MODAL CADASTRAR PRODUTO -->
<div class="modal fade" id="modalCadastrarEstoque" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <form action="<?= BASE_URL ?>/Onboarding/salvar" method="POST">
        <input type="hidden" name="id_estoque" value="3">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">
            <i class="bi bi-box-seam"></i> Cadastrar Produto no Estoque
          </h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <!-- NOME -->
            <div class="col-md-8">
              <label class="form-label">Nome do Produto *</label>
              <input type="text" name="nome_produto" class="form-control" required>
            </div>

            <!-- UNIDADE -->
            <div class="col-md-4">
              <label class="form-label">Unidade *</label>
              <select name="unidade" class="form-select" required>
                <option value="">Selecione</option>
                <option value="Un">Unidade</option>
                <option value="Cx">Caixa</option>
                <option value="Kg">Kg</option>
                <option value="L">Litro</option>
                <option value="Pct">Pacote</option>
              </select>
            </div>

            <!-- CATEGORIA EXISTENTE -->
            <div class="col-md-6">
              <label class="form-label">Categoria existente</label>
              <select name="id_categoria" class="form-select">
                <option value="">Selecionar</option>
                <?php foreach ($categorias ?? [] as $categoria): ?>
                  <option value="<?= $categoria['id_categoria'] ?>">
                    <?= $categoria['nome_categoria'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- NOVA CATEGORIA -->
            <div class="col-md-6">
              <label class="form-label">Ou criar nova categoria</label>
              <input type="text"
                name="nova_categoria"
                class="form-control"
                placeholder="Ex: Material de Limpeza">
            </div>

            <!-- QUANTIDADE -->
            <div class="col-md-6">
              <label class="form-label">Quantidade Inicial *</label>
              <input type="number" name="quantidade" class="form-control" min="0" required>
            </div>

            <!-- DESCRIÇÃO -->
            <div class="col-12">
              <label class="form-label">Descrição</label>
              <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success px-4">
            <i class="bi bi-check-circle"></i> Salvar
          </button>
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
            Cancelar
          </button>
        </div>

      </form>

    </div>
  </div>
</div>













</html>