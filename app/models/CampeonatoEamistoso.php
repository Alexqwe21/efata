<?php

class CampeonatoEamistoso extends Model
{


    public function salvarTime($dadosTime)
    {
        try {
            $sql = "INSERT INTO tbl_campeonatos_amistosos (nome_time, foto_time, status_time, data_cadastro_time, email_campeonato)
                    VALUES (:nome_time, :foto_time, :status_time, :data_cadastro_time, :email_campeonato)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome_time', $dadosTime['nome_time']);
            $stmt->bindValue(':foto_time', $dadosTime['foto_time']);
            $stmt->bindValue(':status_time', $dadosTime['status_time']);
            $stmt->bindValue(':data_cadastro_time', $dadosTime['data_cadastro_time']);
            $stmt->bindValue(':email_campeonato', $dadosTime['email_campeonato']);
            $stmt->execute();

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function salvarJogador($dadosJogador)
    {
        try {
            $sql = "INSERT INTO tbl_jogadores (
                        id_campeonato, nome_completo_jogador, rg_jogador,
                        data_nascimento_jogador, posicao_voleibol_jogador,
                        telefone_jogador, status_jogador
                    ) VALUES (
                        :id_campeonato, :nome_completo_jogador, :rg_jogador,
                        :data_nascimento_jogador, :posicao_voleibol_jogador,
                        :telefone_jogador, :status_jogador
                    )";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_campeonato', $dadosJogador['id_campeonato']);
            $stmt->bindValue(':nome_completo_jogador', $dadosJogador['nome_completo_jogador']);
            $stmt->bindValue(':rg_jogador', $dadosJogador['rg_jogador']);
            $stmt->bindValue(':data_nascimento_jogador', $dadosJogador['data_nascimento_jogador']);
            $stmt->bindValue(':posicao_voleibol_jogador', $dadosJogador['posicao_voleibol_jogador']);
            $stmt->bindValue(':telefone_jogador', $dadosJogador['telefone_jogador']);
            $stmt->bindValue(':status_jogador', $dadosJogador['status_jogador']);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            throw $e;
        }
    }



    public function listarCampeonatoAmistoso($filtros = [])
    {
        $sql = "SELECT * FROM tbl_campeonatos_amistosos ca
            INNER JOIN tbl_jogadores jo ON ca.id_campeonato = jo.id_campeonato
            WHERE 1=1";
        $params = [];

        // Filtros do time
        if (!empty($filtros['status_time'])) {
            $sql .= " AND ca.status_time = :status_time";
            $params[':status_time'] = $filtros['status_time'];
        }

        if (!empty($filtros['nome_time'])) {
            $sql .= " AND ca.nome_time LIKE :nome_time";
            $params[':nome_time'] = '%' . $filtros['nome_time'] . '%';
        }

        if (!empty($filtros['email_campeonato'])) {
            $sql .= " AND ca.email_campeonato LIKE :email_campeonato";
            $params[':email_campeonato'] = '%' . $filtros['email_campeonato'] . '%';
        }

        // Filtros dos jogadores
        if (!empty($filtros['nome_jogador'])) {
            $sql .= " AND jo.nome_completo_jogador LIKE :nome_jogador";
            $params[':nome_jogador'] = '%' . $filtros['nome_jogador'] . '%';
        }

        if (!empty($filtros['telefone_jogador'])) {
            $sql .= " AND jo.telefone_jogador LIKE :telefone_jogador";
            $params[':telefone_jogador'] = '%' . $filtros['telefone_jogador'] . '%';
        }

        if (!empty($filtros['rg_jogador'])) {
            $sql .= " AND jo.rg_jogador LIKE :rg_jogador";
            $params[':rg_jogador'] = '%' . $filtros['rg_jogador'] . '%';
        }

        $sql .= " ORDER BY ca.nome_time ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organização dos dados
        $campeonatos = [];
        $jogadores = [];

        foreach ($resultados as $row) {
            $id = $row['id_campeonato'];

            if (!isset($campeonatos[$id])) {
                $dataOriginal = $row['data_cadastro_time'];
                $dataConvertida = DateTime::createFromFormat('Y-m-d H:i:s', $dataOriginal);
                $campeonatos[$id] = [
                    'id_campeonato' => $row['id_campeonato'],
                    'nome_time' => $row['nome_time'],
                    'foto_time' => $row['foto_time'],
                    'status_time' => $row['status_time'],
                    'email_campeonato' => $row['email_campeonato'],
                    'data_cadastro_time' => $dataConvertida
                        ? $dataConvertida->format('d/m/Y H:i')
                        : $dataOriginal
                ];
            }

            $jogadores[] = [
                'id_jogador' => $row['id_jogador'],
                'id_campeonato' => $row['id_campeonato'],
                'nome_completo_jogador' => $row['nome_completo_jogador'],
                'rg_jogador' => $row['rg_jogador'],
                'data_nascimento_jogador' => $row['data_nascimento_jogador'],
                'posicao_voleibol_jogador' => $row['posicao_voleibol_jogador'],
                'telefone_jogador' => $row['telefone_jogador'],
                'status_jogador' => $row['status_jogador']
            ];
        }

        return [
            'campeonatos' => array_values($campeonatos),
            'jogadores' => $jogadores
        ];
    }



    public function atualizarTimeEJogadores($idCampeonato, $dadosTime, $jogadores, $fotoTime = null)
    {
        // Atualiza o time
        $sqlTime = "UPDATE tbl_campeonatos_amistosos SET 
                    nome_time = :nome_time,
                    email_campeonato = :email,
                    status_time = :status";

        // Se veio uma nova imagem, inclui no SQL
        if (!empty($fotoTime)) {
            $sqlTime .= ", foto_time = :foto";
        }

        $sqlTime .= " WHERE id_campeonato = :id";

        $stmt = $this->db->prepare($sqlTime);

        $params = [
            ':nome_time' => $dadosTime['nome_time'],
            ':email' => $dadosTime['email_campeonato'],
            ':status' => $dadosTime['status_time'],
            ':id' => $idCampeonato
        ];

        if (!empty($fotoTime)) {
            $params[':foto'] = $fotoTime;
        }

        $stmt->execute($params);

        // Atualiza os jogadores
        foreach ($jogadores as $jogador) {
            $sqlJogador = "UPDATE tbl_jogadores SET 
                        nome_completo_jogador = :nome,
                        rg_jogador = :rg,
                        data_nascimento_jogador = :nascimento,
                        posicao_voleibol_jogador = :posicao,
                        telefone_jogador = :telefone,
                        status_jogador = :status
                    WHERE id_jogador = :id";

            $stmt = $this->db->prepare($sqlJogador);
            $stmt->execute([
                ':nome' => $jogador['nome_completo_jogador'],
                ':rg' => $jogador['rg_jogador'],
                ':nascimento' => $jogador['data_nascimento_jogador'],
                ':posicao' => $jogador['posicao_voleibol_jogador'],
                ':telefone' => $jogador['telefone_jogador'],
                ':status' => $jogador['status_jogador'],
                ':id' => $jogador['id_jogador']
            ]);
        }

        return true;
    }


    public function contarTodosTimes()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM tbl_campeonatos_amistosos");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function agruparPorStatus()
    {
        $sql = "SELECT status_time AS label, COUNT(*) AS valor
            FROM tbl_campeonatos_amistosos
            GROUP BY status_time";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPosicoesJogadores()
    {
        $sql = "SELECT posicao_voleibol_jogador AS label, COUNT(*) AS valor
            FROM tbl_jogadores
            GROUP BY posicao_voleibol_jogador";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function quantidadeJogadoresPorTime()
    {
        $sql = "SELECT c.nome_time AS label, COUNT(j.id_jogador) AS valor
            FROM tbl_campeonatos_amistosos c
            LEFT JOIN tbl_jogadores j ON j.id_campeonato = c.id_campeonato
            GROUP BY c.nome_time";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function calcularMediaIdadePorTime()
    {
        $sql = "
        SELECT 
            c.nome_time AS label,
            ROUND(AVG(TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE())), 1) AS valor
        FROM 
            tbl_jogadores j
        INNER JOIN 
            tbl_campeonatos_amistosos c ON j.id_campeonato = c.id_campeonato
        WHERE 
            j.data_nascimento_jogador IS NOT NULL
        GROUP BY 
            c.id_campeonato
        ORDER BY 
            valor DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function agruparPorIdadeJogadores()
    {
        $sql = "
        SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE()) BETWEEN 0 AND 12 THEN '0-12 anos'
                WHEN TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE()) BETWEEN 13 AND 17 THEN '13-17 anos'
                WHEN TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE()) BETWEEN 18 AND 25 THEN '18-25 anos'
                WHEN TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE()) BETWEEN 26 AND 35 THEN '26-35 anos'
                WHEN TIMESTAMPDIFF(YEAR, j.data_nascimento_jogador, CURDATE()) BETWEEN 36 AND 50 THEN '36-50 anos'
                ELSE '50+ anos'
            END AS label,
            COUNT(*) AS valor
        FROM tbl_jogadores j
        WHERE j.data_nascimento_jogador IS NOT NULL
        GROUP BY label
        ORDER BY label
    ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarPorNomeTime($nomeTime)
    {
        $sql = "SELECT * FROM tbl_campeonatos_amistosos WHERE nome_time = :nome_time LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_time', $nomeTime);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function adicionarJogador($dados)
    {
        $sql = "INSERT INTO tbl_jogadores 
        (id_campeonato, nome_completo_jogador, rg_jogador, data_nascimento_jogador, telefone_jogador, posicao_voleibol_jogador, status_jogador) 
        VALUES 
        (:id_campeonato, :nome_completo_jogador, :rg_jogador, :data_nascimento_jogador, :telefone_jogador, :posicao_voleibol_jogador, :status_jogador)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($dados);
    }

    public function contarJogadoresPorStatus()
    {
        $sql = "SELECT status_jogador AS label, COUNT(*) AS valor FROM tbl_jogadores GROUP BY status_jogador";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function contarJogadoresPorStatusPorTime()
    {
        $sql = "
        SELECT t.nome_time AS time, j.status_jogador AS status, COUNT(*) AS quantidade
        FROM tbl_jogadores j
        INNER JOIN tbl_campeonatos_amistosos t ON t.id_campeonato = j.id_campeonato
        GROUP BY t.nome_time, j.status_jogador
        ORDER BY t.nome_time
    ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
