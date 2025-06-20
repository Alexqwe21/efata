<head>
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time(); ?>">
</head>



<?php if (isset($_SESSION['sucesso'])): ?>
  <div class="alert alert-success">
    <?php echo $_SESSION['sucesso'];
    unset($_SESSION['sucesso']); ?>
  </div>
<?php endif; ?>





<form method="GET" class="row g-3 mb-4">

  <div class="col-md-2">
    <label for="status_time" class="form-label">Status do Time:</label>
    <select name="status_time" id="status_time" class="form-select" onchange="this.form.submit()">
      <option value="">Todos</option>
      <option value="Ativo" <?= (isset($_GET['status_time']) && $_GET['status_time'] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
      <option value="Inativo" <?= (isset($_GET['status_time']) && $_GET['status_time'] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
    </select>
  </div>

  <div class="col-md-2">
    <label class="form-label" for="nome_time">Nome do Time</label>
    <input type="text" name="nome_time" id="nome_time" class="form-control" placeholder="Ex: Os Craques"
      value="<?= isset($_GET['nome_time']) ? htmlspecialchars($_GET['nome_time']) : ''; ?>">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="email_campeonato">E-mail do Responsável</label>
    <input type="email" name="email_campeonato" id="email_campeonato" class="form-control" placeholder="Ex: nome@email.com"
      value="<?= isset($_GET['email_campeonato']) ? htmlspecialchars($_GET['email_campeonato']) : ''; ?>">
  </div>

  <div class="col-md-2">
    <label class="form-label" for="nome_jogador">Nome do Jogador</label>
    <input type="text" name="nome_jogador" id="nome_jogador" class="form-control" placeholder="Ex: João da Silva"
      value="<?= isset($_GET['nome_jogador']) ? htmlspecialchars($_GET['nome_jogador']) : ''; ?>">
  </div>

<div class="col-md-2">
  <label class="form-label" for="rg_jogador">RG</label>
  <input type="text" name="rg_jogador" id="rg_jogador" class="form-control" placeholder="00.000.000-0"
    maxlength="12" value="<?= isset($_GET['rg_jogador']) ? htmlspecialchars($_GET['rg_jogador']) : ''; ?>">
</div>

<div class="col-md-2">
  <label class="form-label" for="telefone_jogador">Telefone</label>
  <input type="text" name="telefone_jogador" id="telefone_jogador" class="form-control" placeholder="(00) 00000-0000"
    maxlength="15" value="<?= isset($_GET['telefone_jogador']) ? htmlspecialchars($_GET['telefone_jogador']) : ''; ?>">
</div>


  <div class="col-md-2 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
  </div>

  <div class="col-md-2 d-flex align-items-end">
    <a href="/campeonatoEamistoso/campeonatoListar" class="btn btn-outline-secondary w-100">Limpar</a>
  </div>

</form>





<div class="mb-3" style="display: flex; align-items: center;">
  <a href="/campeonatoEamistoso/exportarPDFCampeonatos<?= $queryString ?>" target="_blank" class="btn btn-danger">
    <i class="bi bi-file-earmark-pdf-fill"></i> Exportar PDF
  </a>
  <a href="/campeonatoEamistoso/exportarExcelCampeonatos?filtro=&status="
    class="btn-admin-export"
    target="_blank">
    <i class='bx bx-file'></i> Exportar Excel
  </a>
</div>









<table class="table table-striped table-hover">
  <!-- <thead>
    <tr>

      <th>Nome</th>
      <th>Atividade</th>
      <th>Data de Cadastro</th>
      <th>Status Matricula</th>
      <th>Ações</th>
      <th>Editar</th>
    </tr>
  </thead> -->
  <tbody>

    <tr>





      <div style="display: flex; justify-content: space-between; flex-flow: row wrap;">


        <?php foreach ($listarCampeonato as $index => $campeonatos): ?>

          <?php
          // Pega a primeira letra do time e transforma em maiúscula
          $letra = strtoupper(substr($campeonatos['nome_time'], 0, 1));

          // Array expandido com cerca de 50 cores diferentes
        $cores = [
  '#D7263D', // vermelho forte
  '#F46036', // laranja vibrante
  '#2E294E', // roxo escuro
  '#1B998B', // verde esmeralda escuro
  '#2D3047', // azul petróleo
  '#0F4C5C', // azul petróleo escuro
  '#3C1642', // roxo profundo
  '#086788', // azul escuro vibrante
  '#1C1C1C', // preto quase puro
  '#2C2C54', // roxo grafite
  '#3D348B', // roxo escuro saturado
  '#1D3557', // azul royal escuro
  '#4A4E69', // cinza arroxeado escuro
  '#8338EC', // roxo elétrico
  '#3A0CA3', // azul royal profundo
  '#240046', // roxo escuro
  '#7209B7', // púrpura vivo
  '#F72585', // rosa choque escuro
  '#D00000', // vermelho puro escuro
  '#9D0208', // vinho intenso
  '#6A040F', // vermelho queimado
  '#370617', // bordô escuro
  '#03045E', // azul escuro saturado
  '#023E8A', // azul royal
  '#0077B6', // azul vibrante
  '#0096C7', // ciano forte
  '#00B4D8', // azul caribe
  '#006D77', // verde petróleo forte
  '#14213D', // azul marinho escuro
  '#000814', // preto azulado
  '#001D3D', // azul meia-noite
  '#00296B', // azul escuro puro
  '#003566', // azul naval
  '#6F1D1B', // vinho terroso
  '#5A189A', // roxo profundo escuro
  '#9A031E', // vermelho vibrante escuro
  '#8D0801', // vermelho queimado forte
  '#2C6E49', // verde escuro saturado
  '#1E5128', // verde floresta
  '#264653', // azul petróleo escuro
  '#006400', // verde musgo forte
  '#2F3E46', // cinza escuro azulado
  '#0B132B', // azul noite
  '#1D1A05', // marrom muito escuro
  '#361D32', // roxo escuro acinzentado
  '#5F0F40', // vinho escuro rosado
  '#8F2D56', // magenta escuro
  '#C9184A', // rosa escuro saturado
  '#A4161A', // vermelho barro
  '#511845'  // roxo profundo saturado
];


          // Gera índice baseado no hash do nome do time
          $indiceCor = hexdec(substr(md5($campeonatos['nome_time']), 0, 2)) % count($cores);
          $corFundo = $cores[$indiceCor];
          ?>






          <!-- From Uiverse.io by andrew-demchenk0 -->
          <div class="card">
            <div class="card__img" style="height: 450px; overflow: hidden;">
              <?php
              $foto = !empty($campeonatos['foto_time']) ? '/uploads/' . $campeonatos['foto_time'] : '/uploads/sem_foto.jpg';
              ?>
              <img src="<?php echo $foto; ?>"
                alt="Imagem do Time"
                style="width: 100%; height: 95%; object-fit: cover; border-top-left-radius: 20px; border-top-right-radius: 20px;"
                onerror="this.onerror=null; this.src='/uploads/sem_foto.jpg';">
            </div>


            <div class="card__avatar">
              <div class="avatar-letra" style="background-color: <?php echo $corFundo; ?>;">
                <?php echo $letra; ?>
              </div>
            </div>
            <div class="card__title"><?php echo ucfirst($campeonatos['nome_time']); ?></div>
            <div class="card__subtitle"><?php echo ucfirst($campeonatos['email_campeonato']); ?></div>
            <div class="card__wrapper">
              <button class="card__btn" data-bs-toggle="modal" data-bs-target="#modalTime<?php echo $campeonatos['id_campeonato']; ?>">
                Ver Mais
              </button>
              <button class="card__btn" data-bs-toggle="modal" data-bs-target="#editarTime<?php echo $campeonatos['id_campeonato']; ?>">
                Editar
              </button>


            </div>
          </div>




          <!-- Modal com informações do time e jogadores -->
          <div class="modal fade" id="modalTime<?php echo $campeonatos['id_campeonato']; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $campeonatos['id_campeonato']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalLabel<?php echo $campeonatos['id_campeonato']; ?>">Detalhes do Time</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">

                  <h6 class="text-uppercase mb-3"><strong>Informações do Time</strong></h6>
                  <p><strong>Nome do Time:</strong> <?php echo $campeonatos['nome_time']; ?></p>
                  <p><strong>Email do Responsável:</strong> <?php echo $campeonatos['email_campeonato']; ?></p>
                  <p><strong>Status:</strong> <?php echo $campeonatos['status_time']; ?></p>
                  <p><strong>Data de Cadastro:</strong>
                    <?php echo $campeonatos['data_cadastro_time']; ?>
                  </p>


                  <hr>
                  <h6 class="text-uppercase mb-3"><strong>Jogadores do Time</strong></h6>

                  <?php
                  $contador = 1;
                  foreach ($jogadores as $jogador):
                    if ($jogador['id_campeonato'] == $campeonatos['id_campeonato']):
                  ?>
                      <div class="mb-3 p-3 border rounded bg-light">
                        <p><strong>Jogador <?php echo $contador++; ?>:</strong></p>
                        <p><strong>Nome:</strong> <?php echo !empty($jogador['nome_completo_jogador']) ? $jogador['nome_completo_jogador'] : 'Não informado'; ?></p>
                        <p><strong>RG:</strong> <?php echo !empty($jogador['rg_jogador']) ? $jogador['rg_jogador'] : 'Não informado'; ?></p>
                        <p><strong>Data de Nascimento:</strong>
                          <?php
                          echo !empty($jogador['data_nascimento_jogador'])
                            ? date('d/m/Y', strtotime($jogador['data_nascimento_jogador']))
                            : 'Não informado';
                          ?>
                        </p>
                        <p><strong>Posição:</strong> <?php echo !empty($jogador['posicao_voleibol_jogador']) ? $jogador['posicao_voleibol_jogador'] : 'Não informado'; ?></p>
                        <p><strong>Telefone:</strong> <?php echo !empty($jogador['telefone_jogador']) ? $jogador['telefone_jogador'] : 'Não informado'; ?></p>
                        <p><strong>Status:</strong> <?php echo !empty($jogador['status_jogador']) ? $jogador['status_jogador'] : 'Não informado'; ?></p>
                      </div>
                  <?php
                    endif;
                  endforeach;
                  ?>

                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
              </div>
            </div>
          </div>









          <!-- MODAL PARA EDITAR OS DADOS -->

          <!-- Modal de Edição de Matrícula -->

          <!-- Modal de Edição de Time e Jogadores -->
          <div class="modal fade" id="editarTime<?php echo $campeonatos['id_campeonato']; ?>" tabindex="-1" aria-labelledby="editarLabel<?php echo $campeonatos['id_campeonato']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
              <div class="modal-content">
                <form action="/campeonatoEamistoso/atualizar/<?= $campeonatos['id_campeonato'] ?>" method="POST" enctype="multipart/form-data">

                  <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editarLabel<?php echo $campeonatos['id_campeonato']; ?>">Editar Time e Jogadores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                  </div>

                  <div class="modal-body row g-3">
                    <h6>Informações do Time</h6>
                    <div class="d-flex justify-content-center mb-4">
                      <div style="width: 100%; max-width: 350px; text-align: center;">
                        <label class="form-label d-block">Foto do Time</label>
                        <?php
                        $caminhoImagem = !empty($campeonatos['foto_time']) ? '/uploads/' . $campeonatos['foto_time'] : '/uploads/sem_foto.jpg';
                        ?>
                        <img id="preview-img-<?php echo $campeonatos['id_campeonato']; ?>"
                          src="<?php echo $caminhoImagem; ?>"
                          alt="Imagem do Time"
                          style="width: 100%; height: 350px; object-fit: cover; cursor:pointer; border:1px solid #ccc; padding:5px;"
                          title="Clique para selecionar uma nova imagem">
                        <input type="file" name="foto_time" id="foto_time_<?php echo $campeonatos['id_campeonato']; ?>" style="display: none;">
                      </div>
                    </div>


                    <div class="col-12">
                      <label class="form-label">Nome do Time</label>
                      <input type="text" name="nome_time" class="form-control mb-3" value="<?php echo htmlspecialchars($campeonatos['nome_time']); ?>">

                      <label class="form-label">Email do Responsável</label>
                      <input type="email" name="email_campeonato" class="form-control mb-3" value="<?php echo htmlspecialchars($campeonatos['email_campeonato']); ?>">

                      <label class="form-label">Status</label>
                      <select name="status_time" class="form-select mb-3">
                        <option value="Ativo" <?php echo $campeonatos['status_time'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                        <option value="Inativo" <?php echo $campeonatos['status_time'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                      </select>
                    </div>



                    <hr>
                    <h6>Jogadores</h6>

                    <?php
                    $contadorJogador = 0;
                    foreach ($jogadores as $jogador):
                      if ($jogador['id_campeonato'] == $campeonatos['id_campeonato']):
                        // Garante que só entra se o ID do jogador estiver presente
                        if (!isset($jogador['id_jogador'])) {
                          continue;
                        }
                    ?>
                        <input type="hidden" name="jogadores[<?php echo $contadorJogador; ?>][id_jogador]" value="<?php echo htmlspecialchars($jogador['id_jogador']); ?>">
                        <div class="border rounded p-3 bg-light mb-3">
                          <h6>Jogador <?php echo $contadorJogador + 1; ?></h6>
                          <div class="row g-2">
                            <div class="col-md-4">
                              <label>Nome Completo</label>
                              <input type="text" name="jogadores[<?php echo $contadorJogador; ?>][nome_completo_jogador]" class="form-control" value="<?php echo htmlspecialchars($jogador['nome_completo_jogador']); ?>">
                            </div>
                            <div class="col-md-4">
                              <label>RG</label>
                              <input type="text" name="jogadores[<?php echo $contadorJogador; ?>][rg_jogador]" class="form-control rg" value="<?php echo htmlspecialchars($jogador['rg_jogador']); ?>">
                            </div>
                            <div class="col-md-4">
                              <label>Data de Nascimento</label>
                              <input type="text"
                                name="jogadores[<?php echo $contadorJogador; ?>][data_nascimento_jogador]"
                                class="form-control data"
                                value="<?php
                                        $data = $jogador['data_nascimento_jogador'] ?? '';
                                        if (!empty($data)) {
                                          $dataObj = DateTime::createFromFormat('Y-m-d', $data);
                                          echo $dataObj ? htmlspecialchars($dataObj->format('d/m/Y')) : '';
                                        }
                                        ?>">
                            </div>

                            <div class="col-md-4">
                              <label>Posição</label>
                              <select
                                name="jogadores[<?php echo $contadorJogador; ?>][posicao_voleibol_jogador]"
                                class="form-select" style="text-transform: uppercase;">
                                <option value="" disabled <?php echo empty($jogador['posicao_voleibol_jogador']) ? 'selected' : ''; ?>>Selecione a Posição no Vôlei</option>
                                <option value="levantador" <?php echo ($jogador['posicao_voleibol_jogador'] === 'levantador') ? 'selected' : ''; ?>>Levantador</option>
                                <option value="ponteiro" <?php echo ($jogador['posicao_voleibol_jogador'] === 'ponteiro') ? 'selected' : ''; ?>>Ponteiro</option>
                                <option value="oposto" <?php echo ($jogador['posicao_voleibol_jogador'] === 'oposto') ? 'selected' : ''; ?>>Oposto</option>
                                <option value="central" <?php echo ($jogador['posicao_voleibol_jogador'] === 'central') ? 'selected' : ''; ?>>Central</option>
                                <option value="libero" <?php echo ($jogador['posicao_voleibol_jogador'] === 'libero') ? 'selected' : ''; ?>>Líbero</option>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <label>Telefone</label>
                              <input type="text" name="jogadores[<?php echo $contadorJogador; ?>][telefone_jogador]" class="form-control telefone" value="<?php echo htmlspecialchars($jogador['telefone_jogador']); ?>">
                            </div>
                            <div class="col-md-4">
                              <label>Status</label>
                              <select name="jogadores[<?php echo $contadorJogador; ?>][status_jogador]" class="form-select">
                                <option value="Ativo" <?php echo $jogador['status_jogador'] == 'Ativo' ? 'selected' : ''; ?>>Ativo</option>
                                <option value="Inativo" <?php echo $jogador['status_jogador'] == 'Inativo' ? 'selected' : ''; ?>>Inativo</option>
                              </select>
                            </div>
                          </div>
                        </div>
                    <?php
                        $contadorJogador++;
                      endif;
                    endforeach;
                    ?>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>





        <?php endforeach; ?>
      </div>
      <!-- MODAL PARA EDITAR OS DADOS -->


  </tbody>
</table>

<?php
// Pega só os filtros que interessam para exportar, com nomes corretos que seu backend espera
$params = [];
if (!empty($_GET['status'])) $params['status_time'] = $_GET['status'];          // status_time no backend
if (!empty($_GET['nome'])) $params['nome_time'] = $_GET['nome'];                // nome_time no backend                    // cpf no backend, se usar
if (!empty($_GET['rg'])) $params['rg_jogador'] = $_GET['rg'];                   // rg_jogador no backend
if (!empty($_GET['telefone'])) $params['telefone_jogador'] = $_GET['telefone']; // telefone_jogador no backend
if (!empty($_GET['email'])) $params['email_campeonato'] = $_GET['email'];       // email_campeonato no backend

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


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const visualizarimg = document.getElementById('preview-img-<?php echo $campeonatos['id_campeonato']; ?>');
    const arquivo = document.getElementById('foto_time_<?php echo $campeonatos['id_campeonato']; ?>');

    visualizarimg.addEventListener('click', function() {
      arquivo.click();
    });

    arquivo.addEventListener('change', function() {
      if (arquivo.files && arquivo.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          visualizarimg.src = e.target.result;
        };
        reader.readAsDataURL(arquivo.files[0]);
      }
    });
  });
</script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="preview-img-"]').forEach(function(img) {
      const id = img.id.replace('preview-img-', '');
      const input = document.getElementById('foto_time_' + id);

      img.addEventListener('click', function() {
        input.click();
      });

      input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            img.src = e.target.result;
          };
          reader.readAsDataURL(input.files[0]);
        }
      });
    });
  });
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const rgInput = document.getElementById("rg_jogador");
  const telefoneInput = document.getElementById("telefone_jogador");

  if (rgInput) {
    rgInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length > 9) value = value.slice(0, 9);
      value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");
      e.target.value = value;
    });
  }

  if (telefoneInput) {
    telefoneInput.addEventListener("input", function (e) {
      let value = e.target.value.replace(/\D/g, "");
      if (value.length > 11) value = value.slice(0, 11);
      value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
      e.target.value = value;
    });
  }
});
</script>



</html>