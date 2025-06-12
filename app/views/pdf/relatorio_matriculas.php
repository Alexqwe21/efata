<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #333;
      padding: 6px 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-style: italic;
      font-size: 11px;
    }
  </style>
</head>
<body>

  <h2>Relatório de Matrículas - Cultura Efatá</h2>

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
          <td><?php echo $linha['matricula_id']; ?></td>
          <td><?php echo $linha['matricula_nome']; ?></td>
          <td><?php echo $linha['matricula_cpf']; ?></td>
          <td><?php echo $linha['matricula_rg']; ?></td>
          <td><?php echo $linha['matricula_telefone']; ?></td>
          <td><?php echo $linha['matricula_email']; ?></td>
          <td><?php echo $linha['status_matricula']; ?></td>
          <td><?php echo $linha['matricula_atividade']; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
    Documento gerado automaticamente em <?php echo date('d/m/Y H:i'); ?>
  </div>

</body>
</html>
