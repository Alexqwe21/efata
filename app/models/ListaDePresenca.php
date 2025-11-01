<?php

class ListaDePresenca extends Model
{

   // Lista todos os alunos ativos
    public function listarAlunos()
    {
        $sql = "SELECT matricula_id, matricula_nome 
                FROM matriculas 
                WHERE status_matricula = 'Ativo'";
        $stmt = $this->db->prepare($sql);
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
  
}
