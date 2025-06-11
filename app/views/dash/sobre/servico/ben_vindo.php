<style>
  button {
    border: none;
    background-color: transparent;
  }

  .pg_produto {
    width: 230px;
    height: 230px;
    border-radius: 5px;
  }
</style>



<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Foto</th>
      <th scope="col">Nome da Galeria</th>
      <th scope="col">Texto Alternativo</th>
      <th scope="col">Status</th>
      <th scope="col">Editar</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($listarDestaque as $linha): ?>
      <tr>
        <th scope="row"><?php echo htmlspecialchars($linha['id_galeira']); ?></th>
        <td><img src="/uploads/<?php echo $linha['foto_galeria']; ?>" alt="<?php echo htmlspecialchars($linha['alt_foto_galeria']); ?>" class="pg_produto"></td>

        <td><?php echo htmlspecialchars($linha['nome_galeria']); ?></td>
        <td><?php echo htmlspecialchars($linha['alt_foto_galeria']); ?></td>
        <td>
          <?php echo ($linha['status_galeria'] == 'Ativo') ? 'Ativo' : 'Inativo'; ?>
        </td>

        <td>
          <a href="<?php echo BASE_URL . 'galeria/editarG/' . $linha['id_galeira']; ?>">
            <button class="btn btn-primary">
              <i class="bi bi-pencil-fill"></i> Editar
            </button>
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>

</table>
<script src="/vendors/dash/js/adminlte.js"></script>

</html>