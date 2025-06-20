<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Campeonatos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2 {
            background-color: #eee;
            padding: 5px;
            border-radius: 4px;
        }
        .time {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .jogadores {
            margin-left: 20px;
        }
        .jogadores table {
            width: 100%;
            border-collapse: collapse;
        }
        .jogadores th, .jogadores td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: left;
        }
        .jogadores th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Relatório de Campeonatos e Jogadores</h1>

    <?php
    // Usa variáveis locais para garantir que estão definidas
    $campeonatos = $listarCampeonato ?? [];
    $jogadores = $jogadores ?? [];
    ?>

    <?php if (count($campeonatos) === 0): ?>
        <p><em>Nenhum campeonato encontrado.</em></p>
    <?php else: ?>
        <?php foreach ($campeonatos as $time): ?>
            <div class="time">
                <h2><?= htmlspecialchars($time['nome_time']) ?> (<?= htmlspecialchars($time['status_time']) ?>)</h2>
                <p><strong>Email do Responsável:</strong> <?= htmlspecialchars($time['email_campeonato']) ?></p>
                <p><strong>Data de Cadastro:</strong> <?= htmlspecialchars($time['data_cadastro_time']) ?></p>

                <div class="jogadores">
                    <h4>Jogadores:</h4>

                    <?php
                    // Filtra os jogadores do time atual
                    $jogadoresDoTime = array_filter($jogadores, fn($j) => $j['id_campeonato'] == $time['id_campeonato']);
                    ?>

                    <?php if (count($jogadoresDoTime) === 0): ?>
                        <p><em>Não há jogadores cadastrados para este time.</em></p>
                    <?php else: ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>RG</th>
                                    <th>Data Nasc.</th>
                                    <th>Posição</th>
                                    <th>Telefone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jogadoresDoTime as $jogador): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($jogador['nome_completo_jogador']) ?></td>
                                        <td><?= htmlspecialchars($jogador['rg_jogador']) ?></td>
                                        <td>
                                            <?php
                                            $dt = $jogador['data_nascimento_jogador'] ?? '';
                                            echo !empty($dt) ? date('d/m/Y', strtotime($dt)) : '';
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($jogador['posicao_voleibol_jogador']) ?></td>
                                        <td><?= htmlspecialchars($jogador['telefone_jogador']) ?></td>
                                        <td><?= htmlspecialchars($jogador['status_jogador']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
