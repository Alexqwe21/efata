<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
</head>

<?php if (isset($_SESSION['sucesso'])): ?>
  <div class="alert alert-success">
    <?= $_SESSION['sucesso']; ?>
    <?php unset($_SESSION['sucesso']); ?>
  </div>
<?php endif; ?>

<div class="container mt-4">
  <h3>Lista de Presença</h3>

  <!-- Form de filtro separado -->
  <form method="GET" action="/ListaDePresenca/ListarPresenca" class="mb-3">
    <div class="input-group">
      <input type="text" name="filtro" class="form-control" placeholder="Digite o nome do aluno" value="<?= htmlspecialchars($filtro ?? ''); ?>">
      <button class="btn btn-secondary" type="submit">Filtrar</button>
    </div>
  </form>

  <!-- Form para salvar presença -->
  <form method="POST" action="/listaDePresenca/salvarPresenca">
    <div class="mb-3">
      <label for="data_aula" class="form-label">Data da Aula</label>
      <input 
    type="date" 
    id="data_aula" 
    name="data_aula" 
    class="form-control" 
    required
    value="<?= date('Y-m-d'); ?>"  
  >
    </div>

    <!-- Mantém o filtro para redirecionar após salvar -->
    <input type="hidden" name="filtro" value="<?= htmlspecialchars($filtro ?? ''); ?>">

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Nome do Aluno</th>
          <th>Presença</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($alunos as $aluno): ?>
          <tr>
            <td><?= htmlspecialchars($aluno['matricula_nome']); ?></td>
            <td>
              <input type="checkbox" name="presenca[<?= $aluno['matricula_id']; ?>]" value="1">
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Salvar Presenças</button>
  </form>
</div>
