<style>
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

  <div class="col-md-2">
    <label for="status" class="form-label">Filtrar por status:</label>
    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
      <option value="">Todos</option>
      <option value="Ativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
      <option value="Inativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
  </div>

  <div class="col-md-2">
    <label class="form-label" for="nome">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control" placeholder="Ex: João Silva"
      value="<?php echo isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : ''; ?>">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="cpf">CPF</label>
    <!-- CPF -->
    <input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00"
      value="<?php echo isset($_GET['cpf']) ? htmlspecialchars($_GET['cpf']) : ''; ?>"
      maxlength="14" autocomplete="off">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="rg">RG</label>
    <!-- RG -->
    <input type="text" name="rg" id="rg" class="form-control" placeholder="00.000.000-0"
      value="<?php echo isset($_GET['rg']) ? htmlspecialchars($_GET['rg']) : ''; ?>"
      maxlength="12" autocomplete="off">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="telefone">Telefone</label>
    <!-- Telefone -->

    <input type="text" name="telefone" id="telefone" class="form-control" placeholder="(00) 00000-0000"
      value="<?php echo isset($_GET['telefone']) ? htmlspecialchars($_GET['telefone']) : ''; ?>"
      maxlength="15" autocomplete="off">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="email">E-mail</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Ex: nome@email.com"
      value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
  </div>



  <div class="col-md-2 d-flex align-items-end">
    <a href="/matricula/matriculas" class="btn btn-outline-secondary w-100">Limpar</a>
  </div>



</form>




<div class="mb-3" style="display: flex; align-items: center;">
  <a href="/matricula/exportarPDF<?= $queryString ?>" target="_blank" class="btn btn-danger">
    <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
  </a>
  <a href="/matricula/exportarExcel?filtro=&status="
    class="btn-admin-export"
    target="_blank">
    <i class='bx bx-file'></i> Exportar Excel
  </a>
</div>









<table class="table table-striped table-hover">
  <thead>
    <tr>

      <th>Nome</th>
      <th>Atividade</th>
      <th>Data de Cadastro</th>
      <th>Status Matricula</th>
      <th>Ações</th>
      <th>Editar</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($listarMatriculas as $index => $matricula): ?>
      <tr>

        <td><?php echo ucfirst($matricula['matricula_nome']); ?></td>
        <td><?php echo $matricula['matricula_atividade']; ?></td>
        <td><?php echo $matricula['matricula_data_cadastro']; ?></td>
        <td><?php echo $matricula['status_matricula']; ?></td>
        <td>
          <!-- BOTÃO PARA ABRIR O MODAL -->
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMatricula<?php echo $index; ?>">
            Ver Mais
          </button>
        </td>
        <td> <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarMatricula<?php echo $matricula['matricula_id']; ?>">
            Editar
          </button></td>
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
              <p> <strong>Matricula:</strong> <?php echo $matricula['status_matricula']; ?></p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal com todos os dados -->

      <!-- MODAL PARA EDITAR OS DADOS -->

      <!-- Modal de Edição de Matrícula -->
      <div class="modal fade" id="editarMatricula<?php echo $matricula['matricula_id']; ?>" tabindex="-1" aria-labelledby="editarLabel<?php echo $matricula['matricula_id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <form action="/matricula/atualizar/<?php echo $matricula['matricula_id']; ?>" method="POST">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Editar Matrícula Completa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>

              <div class="modal-body row g-3">
                <h6>Informações Pessoais</h6>
                <?php
                $campos = [
                  'matricula_nome' => 'Nome',
                  'matricula_email' => 'E-mail',
                  'matricula_cep' => 'CEP',
                  'matricula_endereco' => 'Endereço',
                  'matricula_bairro' => 'Bairro',
                  'matricula_cidade' => 'Cidade',
                  'matricula_estado' => 'Estado',
                  'matricula_pais' => 'País',
                  'matricula_telefone' => 'Telefone',
                  'matricula_telefone_emergencia' => 'Telefone de Emergência',
                  'matricula_cpf' => 'CPF',
                  'matricula_rg' => 'RG',
                  'matricula_data_nascimento' => 'Data de Nascimento',
                  'matricula_problemas_saude' => 'Problemas de Saúde',
                  'matricula_responsavel_nome' => 'Responsável',
                  'matricula_responsavel_rg' => 'RG do Responsável',
                  'matricula_responsavel_cpf' => 'CPF do Responsável',
                  'matricula_responsavel_qualidade' => 'Parentesco',
                  'matricula_menor_nome' => 'Nome do Menor',
                  'matricula_menor_rg' => 'RG do Menor',
                  'matricula_menor_nascimento' => 'Nascimento do Menor',
                  'matricula_atividade' => 'Atividade'
                ];
                ?>

                <?php foreach ($campos as $key => $label): ?>
                  <div class="col-md-6">
                    <label class="form-label"><?php echo $label; ?></label>
                    <input
                      type="text"
                      name="<?php echo $key; ?>"
                      class="form-control <?php
                                          if (str_contains($key, 'cpf')) echo 'cpf';
                                          elseif (str_contains($key, 'telefone')) echo 'telefone'; // agora vem antes
                                          elseif (str_contains($key, 'rg')) echo 'rg';
                                          elseif (str_contains($key, 'cep')) echo 'cep';
                                          elseif (str_contains($key, 'nascimento')) echo 'data';
                                          ?>"

                      value="<?php echo htmlspecialchars($matricula[$key] ?? ''); ?>">
                  </div>
                <?php endforeach; ?>

                <div class="col-md-4">
                  <label class="form-label">Status da Matrícula</label>
                  <select name="status_matricula" class="form-select">
                    <option value="Ativo" <?php echo $matricula['status_matricula'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                    <option value="Inativo" <?php echo $matricula['status_matricula'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                  </select>
                </div>

                <hr>
                <h6>Questionário de Saúde</h6>

                <?php
                $enums = [
                  'questionario_medicamentos' => ['Sim', 'Não'],
                  'questionario_lesao' => ['Sim', 'Não'],
                  'questionario_acompanhamento' => ['Sim', 'Não'],
                  'questionario_alergias' => ['Sim', 'Não'],
                  'questionario_atividade_fisica' => ['Sim', 'Não'],
                  'questionario_sono' => ['Sempre', 'Às vezes', 'Raramente'],
                  'questionario_alimentacao' => ['Sim', 'Não'],
                  'questionario_apto' => ['Sim', 'Não', 'Não sei'],
                  'questionario_avaliacao_medica' => ['Sim', 'Não']
                ];
                ?>

                <?php foreach ($enums as $key => $options): ?>
                  <div class="col-md-6">
                    <label class="form-label"><?php echo ucfirst(str_replace('_', ' ', $key)); ?></label>
                    <select name="<?php echo $key; ?>" class="form-select">
                      <?php foreach ($options as $option): ?>
                        <option value="<?php echo $option; ?>" <?php echo ($matricula[$key] == $option ? 'selected' : ''); ?>><?php echo $option; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                <?php endforeach; ?>

                <?php
                $textos = [
                  'questionario_saude_problemas' => 'Problemas de Saúde',
                  'questionario_saude_outros' => 'Outros Problemas',
                  'questionario_medicamentos_quais' => 'Medicamentos Quais?',
                  'questionario_lesao_qual' => 'Lesão Qual?',
                  'questionario_acompanhamento_especialidade' => 'Especialidade do Acompanhamento',
                  'questionario_alergias_quais' => 'Alergias Quais?',
                  'questionario_atividade_fisica_quais' => 'Atividades Físicas Quais?',
                  'questionario_avaliacao_medica_quem' => 'Quem fez a Avaliação Médica'
                ];
                ?>

                <?php foreach ($textos as $key => $label): ?>
                  <div class="col-md-6">
                    <label class="form-label"><?php echo $label; ?></label>
                    <input type="text" name="<?php echo $key; ?>" class="form-control" value="<?php echo htmlspecialchars($matricula[$key] ?? ''); ?>">
                  </div>
                <?php endforeach; ?>

              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- MODAL PARA EDITAR OS DADOS -->
    <?php endforeach; ?>

  </tbody>
</table>

<?php
// Pega só os filtros que interessam para exportar
$params = [];
if (!empty($_GET['status'])) $params['status'] = $_GET['status'];
if (!empty($_GET['nome'])) $params['nome'] = $_GET['nome'];
if (!empty($_GET['cpf'])) $params['cpf'] = $_GET['cpf'];
if (!empty($_GET['rg'])) $params['rg'] = $_GET['rg'];
if (!empty($_GET['telefone'])) $params['telefone'] = $_GET['telefone'];
if (!empty($_GET['email'])) $params['email'] = $_GET['email'];

$queryString = !empty($params) ? '?' . http_build_query($params) : '';
?>







<!-- SCRIPT DE MÁSCARAS -->
<script>
  function aplicarMascara(selector, func) {
    document.querySelectorAll(selector).forEach(input => func(input));
  }

  function mascaraCPF(input) {
    input.addEventListener('input', function() {
      let v = input.value.replace(/\D/g, '').slice(0, 11);
      input.value = v.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4').replace(/[-.]$/, '');
    });
  }

  function mascaraRG(input) {
    input.addEventListener('input', function() {
      let v = input.value.replace(/\D/g, '').slice(0, 9);
      input.value = v.replace(/(\d{2})(\d{3})(\d{3})(\d{0,1})/, '$1.$2.$3-$4').replace(/[-.]$/, '');
    });
  }

  function mascaraTelefone(input) {
    input.addEventListener('input', function() {
      let v = input.value.replace(/\D/g, '').slice(0, 11);
      input.value = v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3').replace(/[-]$/, '');
    });
  }

  function mascaraCEP(input) {
    input.addEventListener('input', function() {
      let v = input.value.replace(/\D/g, '').slice(0, 8);
      input.value = v.replace(/(\d{5})(\d{0,3})/, '$1-$2').replace(/-$/, '');
    });
  }

  function mascaraData(input) {
    input.addEventListener('input', function() {
      let v = input.value.replace(/\D/g, '').slice(0, 8);
      input.value = v.replace(/(\d{2})(\d{2})(\d{0,4})/, '$1/$2/$3').replace(/\/$/, '');
    });
  }

  function aplicarMascarasEmTudo() {
    aplicarMascara('.cpf', mascaraCPF);
    aplicarMascara('.rg', mascaraRG);
    aplicarMascara('.telefone', mascaraTelefone);
    aplicarMascara('.cep', mascaraCEP);
    aplicarMascara('.data', mascaraData);
  }

  document.addEventListener('DOMContentLoaded', aplicarMascarasEmTudo);

  // Reaplica ao abrir modais dinamicamente
  document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('shown.bs.modal', aplicarMascarasEmTudo);
  });
</script>




</html>