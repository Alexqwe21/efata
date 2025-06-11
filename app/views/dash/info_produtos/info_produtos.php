<style>
  button {
    border: none;
    background-color: transparent;
  }

  .pg_produto {
    width: 150px;
    height: 150px;
    border-radius: 5px;
    object-fit: cover;
  }
</style>




<form method="get" action="/info_produtos/info_produtos">
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Buscar por nome" name="busca" value="<?php echo $_GET['busca'] ?? ''; ?>">
    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
  </div>
</form>



<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Foto</th>
      <th scope="col">Nome</th>

      <th scope="col">Preço</th>
      <th scope="col">Texto Alternativo</th>
      <th scope="col">Descrição</th>
      <th scope="col">Forma de pagamento</th>
      <th scope="col">Entrega</th>
      <th scope="col">Reservas</th>
      <th scope="col">Personalizção</th>
      <!-- <th scope="col">Tempo</th> -->
      <!-- <th scope="col">Especialidade</th> -->
      <th scope="col">Editar</th>


    </tr>
  </thead>
  <tbody>
    <?php foreach ($listarServico as $linha): ?>

      <tr>
        <th scope="row"><?php echo $linha['id_info_produtos'] ?></th>
        <td><img src="/uploads/<?php echo $linha['foto_produto']; ?>" alt="<?php echo $linha['alt_foto_produto']; ?>" class="pg_produto"></td>


        <td><?php echo $linha['nome_produto'] ?></td>

        <td><?php echo $linha['preco_produto'] ?></td>
        <td><?php echo $linha['info_alt_foto_produto'] ?></td>
        <td><?php echo mb_strimwidth($linha['descricao_info_produto'], 0, 50, '...'); ?></td>
        <td><?php echo mb_strimwidth($linha['forma_pagamento_info_produto'], 0, 30, '...'); ?></td>
        <td><?php echo mb_strimwidth($linha['entrega_info_produtos'], 0, 30, '...'); ?></td>
        <td><?php echo mb_strimwidth($linha['reserva_info_produtos'], 0, 30, '...'); ?></td>
        <td><?php echo mb_strimwidth($linha['personalizacao_info_produtos'], 0, 30, '...'); ?></td>


        <td>
          <a href="/info_produtos/editarI/<?php echo $linha['id_info_produtos']; ?>">
            <button><i class="bi bi-pencil-fill"></i></button>
          </a>
        </td>


      </tr>


    <?php endforeach; ?>



  </tbody>
</table>
<script src="/vendors/dash/js/adminlte.js"></script>

</html>