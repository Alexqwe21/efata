<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      font-size: 11px;
      color: #333;
      margin: 20px;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    .logo {
      text-align: center;
      margin-bottom: 10px;
    }

    .logo img {
      max-height: 60px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #ccc;
      padding: 7px 10px;
      text-align: left;
    }

    th {
      background-color: #1e88e5;
      color: #fff;
      font-size: 11px;
    }

    tr:nth-child(even) {
      background-color: #f4f8fb;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-style: italic;
      font-size: 10px;
      color: #666;
    }

    .titulo-secundario {
      text-align: center;
      font-size: 12px;
      color: #666;
      margin-bottom: 5px;
    }
  </style>
</head>

<body>


  <div class="logo" style="text-align: center; margin-bottom: 20px;">
    <span style="font-size: 25px; color: black; font-family: Inter;">CULTURA EFATÁ</span>
  </div>


  <h2>Relatório de Matrículas</h2>
  <div class="titulo-secundario">Cultura Efatá</div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>RG</th>
        <th>Telefone</th>
        <th>E-mail</th>
        <th>Status</th>
        <th>Atividade</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($dados as $linha): ?>
        <tr>
          <td><?= $linha['matricula_id']; ?></td>
          <td><?= $linha['matricula_nome']; ?></td>
          <td><?= $linha['matricula_cpf']; ?></td>
          <td><?= $linha['matricula_rg']; ?></td>
          <td><?= $linha['matricula_telefone']; ?></td>
          <td><?= $linha['matricula_email']; ?></td>
          <td><?= $linha['status_matricula']; ?></td>
          <td><?= $linha['matricula_atividade']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
    Documento gerado automaticamente em <?= date('d/m/Y H:i'); ?> - Cultura Efatá
  </div>

</body>

</html>