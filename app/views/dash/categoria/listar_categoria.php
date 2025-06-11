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

      <th scope="col">Nome da categoria</th>
      <th scope="col">Descrição categoria</th>
      <th scope="col">Status</th>
      <th scope="col">Editar</th>
      <th scope="col">Desativar/Ativar</th>

    </tr>
  </thead>
  <tbody>
    <?php foreach ($listar_categoria as $linha): ?>
      <tr>
        <th scope="row"><?php echo $linha['id_categoria']; ?></th>

        <td><?php echo htmlspecialchars($linha['nome_categoria']); ?></td>
        <td><?php echo htmlspecialchars($linha['descricao_categoria']); ?></td>
        <td>
          <?php echo ($linha['status_categoria'] == 'Ativo') ? 'Ativo' : 'Inativo'; ?>
        </td>

        <td>
          <a href="/produtos/editarC/<?php echo $linha['id_categoria']; ?>">
            <button><i class="bi bi-pencil-fill"></i></button>
          </a>
        </td>

        <td>
          <a href="/produtos/statusC/<?php echo $linha['id_categoria']; ?>">
            <button><i class="bi bi-trash-fill"></i></button>
          </a>
        </td>

      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script src="/vendors/dash/js/adminlte.js"></script>

</html>