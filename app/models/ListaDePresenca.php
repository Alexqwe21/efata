<?php

class ListaDePresenca extends Model
{

   // Lista todos os alunos ativos
   public function listarAlunos($filtro = '')
{
    $sql = "SELECT matricula_id, matricula_nome 
            FROM matriculas 
            WHERE status_matricula = 'Ativo'";

    if ($filtro) {
        $sql .= " AND matricula_nome LIKE :filtro";
    }

    $stmt = $this->db->prepare($sql);

    if ($filtro) {
        $stmt->bindValue(':filtro', "%$filtro%", PDO::PARAM_STR);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    // Salva presenças no banco
   public function salvarPresencas($dataAula, $presencas)
{
    $local = "CEU SÃO MIGUEL - INSTITUTO BACARRELI";

    // Identifica o dia da semana da data
    $diaSemana = date('N', strtotime($dataAula)); 
    // 6 = Sábado, 7 = Domingo

    if ($diaSemana == 6) {
        $dia = "Sábado";
        $horario = "18:00:00";
    } elseif ($diaSemana == 7) {
        $dia = "Domingo";
        $horario = "16:00:00";
    } else {
        // Caso seja um dia inválido
        $dia = null;
        $horario = null;
    }

    foreach ($presencas as $matriculaId => $presente) {

        $sql = "INSERT INTO presencas 
                (matricula_id, data_aula, presente, local, dia, horario)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $matriculaId,
            $dataAula,
            $presente,
            $local,
            $dia,
            $horario
        ]);
    }
}


public function listarHistorico($inicio = null, $fim = null)
{
    $sql = "SELECT p.data_aula, m.matricula_nome, p.presente
            FROM presencas p
            JOIN matriculas m ON p.matricula_id = m.matricula_id";

    $params = [];

    if (!empty($inicio) && !empty($fim)) {
        $sql .= " WHERE p.data_aula BETWEEN :inicio AND :fim";
        $params[':inicio'] = $inicio;
        $params[':fim'] = $fim;
    }

    $sql .= " ORDER BY p.data_aula DESC, m.matricula_nome";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function listarPorPeriodo($inicio, $fim)
{
    $sql = "SELECT 
                p.data_aula, 
                m.matricula_nome AS nome_aluno, 
                p.presente AS status,
                p.local,
                p.dia,
                p.horario
            FROM presencas p
            JOIN matriculas m ON p.matricula_id = m.matricula_id
            WHERE p.data_aula BETWEEN :inicio AND :fim
            ORDER BY p.data_aula ASC, m.matricula_nome ASC";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':inicio', $inicio);
    $stmt->bindValue(':fim', $fim);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





  
}
