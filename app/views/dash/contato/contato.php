<?php if (isset($_SESSION['mensagem'])): ?>
  <div class="alert alert-<?php echo $_SESSION['tipo-msg']; ?>" role="alert">
    <?php echo $_SESSION['mensagem']; ?>
  </div>
  <?php unset($_SESSION['mensagem']); ?>
<?php endif; ?>



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


<a href="#" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#modalExcluirTodos">
  <i class="bi bi-trash-fill"></i> Excluir todos os e-mails
</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>

      <th scope="col">Nome do contato</th>
      <th scope="col">Telefone contato</th>
      <th scope="col">Email contato</th>
      <th scope="col">Mensagem contato</th>
      <th scope="col">Data de envio</th>
      <th scope="col">Excluir</th>


    </tr>
  </thead>
  <tbody>
    <?php foreach ($listarEmails as $linha): ?>
      <tr>
        <th scope="row"><?php echo $linha['id_contato']; ?></th>

        <td><?php echo htmlspecialchars($linha['nome_contato']); ?></td>
        <td><?php echo htmlspecialchars($linha['telefone_contato']); ?></td>
        <td><?php echo htmlspecialchars($linha['email_contato']); ?></td>
        <td><?php echo nl2br(htmlspecialchars($linha['mensagem_contato'], ENT_NOQUOTES, 'UTF-8')); ?></td>
        <td>
          <?php
          // Cria um objeto DateTime a partir da data do banco
          $dataEnvio = new DateTime($linha['data_envio_contato']);

          // Formata a data no padrão brasileiro
          echo htmlspecialchars($dataEnvio->format('d/m/Y H:i:s'));
          ?>


        <td>
          <!-- Botão que ativa o modal -->
          <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#modalExcluir<?php echo $linha['id_contato']; ?>">
            <i class="bi bi-trash-fill text-danger"></i>
          </button>
        </td>


        </td>



        <!-- <td>
     //     <?php echo ($linha['status_galeria'] == 'Ativo') ? 'Ativo' : 'Inativo'; ?>//
        </td> -->



        </td>


      </tr>


      <!-- Modal de confirmação -->
      <div class="modal fade" id="modalExcluir<?php echo $linha['id_contato']; ?>" tabindex="-1" aria-labelledby="modalExcluirLabel<?php echo $linha['id_contato']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="modalExcluirLabel<?php echo $linha['id_contato']; ?>">Confirmar exclusão</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja excluir o contato <strong><?php echo htmlspecialchars($linha['nome_contato']); ?></strong>?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo BASE_URL . 'contato/excluir/' . $linha['id_contato']; ?>" class="btn btn-danger">Excluir</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal para excluir todos os contatos -->
      <div class="modal fade" id="modalExcluirTodos" tabindex="-1" aria-labelledby="modalExcluirTodosLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="modalExcluirTodosLabel">Excluir todos os contatos</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              Tem certeza que deseja <strong>excluir todos os e-mails</strong>? Essa ação não pode ser desfeita.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <a href="<?php echo BASE_URL . 'contato/excluirTodos'; ?>" class="btn btn-danger">Excluir tudo</a>
            </div>
          </div>
        </div>
      </div>



    <?php endforeach; ?>


  </tbody>
</table>



<script src="/vendors/dash/js/adminlte.js"></script>


</html>