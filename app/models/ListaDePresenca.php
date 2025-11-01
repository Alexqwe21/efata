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
        $sql = "INSERT INTO presencas (matricula_id, data_aula, presente)
                VALUES (:matricula_id, :data_aula, :presente)";
        $stmt = $this->db->prepare($sql);

        foreach ($presencas as $idAluno => $presente) {
            $stmt->execute([
                ':matricula_id' => $idAluno,
                ':data_aula' => $dataAula,
                ':presente' => $presente ? 1 : 0
            ]);
        }
    }

public function listarHistorico($inicio = null, $fim = null)
{
    $sql = "SELECT p.data_aula, m.matricula_nome, p.presente
            FROM presencas p
            JOIN matriculas m ON p.matricula_id = m.matricula_id";

    // 🔹 Se tiver filtro de datas, aplica no WHERE
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



  
}
