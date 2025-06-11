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






<a href="<?php echo BASE_URL . 'produtos/adicionar/'  ?>" class="btn btn-primary mb-3">ADICIONAR</a>
<form method="GET" class="mb-3 row g-2">
  <div class="col-md-3">
    <label for="status" class="form-label">Filtrar por status:</label>
    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
      <option value="">Todos</option>
      <option value="Ativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
      <option value="Inativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
  </div>

  <div class="col-md-3">
    <label for="busca" class="form-label">Buscar por nome ou ID:</label>
    <input type="text" name="busca" id="busca" class="form-control" placeholder="Ex: Nome Do Aluno"
      value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>">
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-success w-100">Buscar</button>
  </div>
</form>



<table class="table table-striped table-hover">
  <thead>
    <tr>

      <th>Nome</th>
      <th>Atividade</th>
      <th>Data de Cadastro</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($listarMatriculas as $index => $matricula): ?>
      <tr>

        <td><?php echo ucfirst($matricula['matricula_nome']); ?></td>
        <td><?php echo $matricula['matricula_atividade']; ?></td>
        <td><?php echo $matricula['matricula_data_cadastro']; ?></td>
        <td>
          <!-- BOTÃO PARA ABRIR O MODAL -->
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMatricula<?php echo $index; ?>">
            Ver Mais
          </button>
        </td>
      </tr>

      <!-- Modal com todos os dados -->
     <!-- Modal -->
  <div class="modal fade" id="modalMatricula<?php echo $index; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $index; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="modalLabel<?php echo $index; ?>">Detalhes da Matrícula</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <p><strong>Nome:</strong> <?php echo $matricula['matricula_nome']; ?></p>
          <p><strong>CPF:</strong> <?php echo $matricula['matricula_cpf']; ?></p>
          <p><strong>RG:</strong> <?php echo $matricula['matricula_rg']; ?></p>
          <p><strong>Data de Nascimento:</strong> <?php echo $matricula['matricula_data_nascimento']; ?></p>
          <p><strong>Endereço:</strong> <?php echo $matricula['matricula_endereco'] . ', ' . $matricula['matricula_bairro'] . ', ' . $matricula['matricula_cidade'] . ' - ' . $matricula['matricula_estado']; ?></p>
          <p><strong>Telefone:</strong> <?php echo $matricula['matricula_telefone']; ?></p>
          <p><strong>Telefone de Emergência:</strong> <?php echo $matricula['matricula_telefone_emergencia']; ?></p>
          <p><strong>Email:</strong> <?php echo $matricula['matricula_email']; ?></p>
          <p><strong>Atividade:</strong> <?php echo $matricula['matricula_atividade']; ?></p>
          <p><strong>Problemas de saúde:</strong> <?php echo $matricula['matricula_problemas_saude']; ?></p>
          <p><strong>Responsável:</strong> <?php echo $matricula['matricula_responsavel_nome']; ?> (<?php echo $matricula['matricula_responsavel_qualidade']; ?>)</p>
          <p><strong>Menor:</strong> <?php echo $matricula['matricula_menor_nome']; ?> - RG: <?php echo $matricula['matricula_menor_rg']; ?></p>

          <hr>
          <h6><strong>Questionário de Saúde</strong></h6>
          <p><strong>Problemas:</strong> <?php echo $matricula['questionario_saude_problemas']; ?></p>
          <p><strong>Outros:</strong> <?php echo $matricula['questionario_saude_outros']; ?></p>
          <p><strong>Medicamentos:</strong> <?php echo $matricula['questionario_medicamentos']; ?> - <?php echo $matricula['questionario_medicamentos_quais']; ?></p>
          <p><strong>Lesões:</strong> <?php echo $matricula['questionario_lesao']; ?> - <?php echo $matricula['questionario_lesao_qual']; ?></p>
          <p><strong>Acompanhamento:</strong> <?php echo $matricula['questionario_acompanhamento']; ?> - <?php echo $matricula['questionario_acompanhamento_especialidade']; ?></p>
          <p><strong>Alergias:</strong> <?php echo $matricula['questionario_alergias']; ?> - <?php echo $matricula['questionario_alergias_quais']; ?></p>
          <p><strong>Atividades físicas:</strong> <?php echo $matricula['questionario_atividade_fisica']; ?> - <?php echo $matricula['questionario_atividade_fisica_quais']; ?></p>
          <p><strong>Sono:</strong> <?php echo $matricula['questionario_sono']; ?></p>
          <p><strong>Alimentação equilibrada:</strong> <?php echo $matricula['questionario_alimentacao']; ?></p>
          <p><strong>Apto para atividade física:</strong> <?php echo $matricula['questionario_apto']; ?></p>
          <p><strong>Avaliação médica:</strong> <?php echo $matricula['questionario_avaliacao_medica']; ?> - <?php echo $matricula['questionario_avaliacao_medica_quem']; ?></p>
          <hr>
           <h6><strong>Status Matricula</strong></h6>
            <p> <strong>Matricula:</strong>  <?php  echo $matricula['status_matricula']; ?></p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
    <?php endforeach; ?>

  </tbody>
</table>




</html>