<div class="container mt-4">
  <h3>Histórico de Presenças</h3>

<div class="container mt-4">
  <h3>Histórico de Presenças</h3>

<form method="GET" action="/ListaDePresenca/HistoricoPresenca" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <label for="inicio">Data Inicial:</label>
            <input type="date" id="inicio" name="inicio" class="form-control"
                   value="<?= htmlspecialchars($inicio ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label for="fim">Data Final:</label>
            <input type="date" id="fim" name="fim" class="form-control"
                   value="<?= htmlspecialchars($fim ?? '') ?>">
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </div>
</form>

<div class="mb-3" style="display: flex; align-items: center; gap: 10px;">
    <a href="/ListaDePresenca/exportarPresencaPDF?inicio=<?= htmlspecialchars($inicio) ?>&fim=<?= htmlspecialchars($fim) ?>" 
       target="_blank" 
       class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
    </a>

    <a href="/ListaDePresenca/exportarPresencaExcel?inicio=<?= htmlspecialchars($inicio) ?>&fim=<?= htmlspecialchars($fim) ?>" 
       target="_blank" 
       class="btn btn-success">
        <i class="bi bi-file-earmark-excel-fill"></i> Exportar Excel
    </a>
</div>








  <?php if (!empty($historico)): ?>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Data da Aula</th>
          <th>Nome do Aluno</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
       <?php foreach ($historico as $p): ?>

          <tr>
            <td><?= date('d/m/Y', strtotime($p['data_aula'])); ?></td>
            <td><?= htmlspecialchars($p['matricula_nome']); ?></td>
            <td>
              <?php if ($p['presente']): ?>
                <span class="badge bg-success">Presente</span>
              <?php else: ?>
                <span class="badge bg-danger">Faltou</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">Nenhuma presença registrada ainda.</div>
  <?php endif; ?>
</div>
