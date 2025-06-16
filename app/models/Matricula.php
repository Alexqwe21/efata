<?php

class Matricula extends Model


{
    public function salvarMatriculaComQuestionario($dadosMatricula, $dadosQuestionario)
    {
        try {
            $this->db->beginTransaction();

            // 1. Inserir na tabela matriculas
            $sqlMatricula = "INSERT INTO matriculas (
    matricula_nome,
    matricula_cep,
    matricula_endereco,
    matricula_bairro,
    matricula_cidade,
    matricula_estado,
    matricula_pais,
    matricula_telefone,
    matricula_telefone_emergencia,
    matricula_cpf,
    matricula_rg,
    matricula_data_nascimento,
    matricula_email,
    matricula_problemas_saude,
    matricula_responsavel_nome,
    matricula_responsavel_rg,
    matricula_responsavel_cpf,
    matricula_responsavel_qualidade,
    matricula_menor_nome,
    matricula_menor_rg,
    matricula_menor_nascimento,
    matricula_atividade,
    matricula_data_cadastro
) VALUES (
    :nome,
    :cep,
    :endereco,
    :bairro,
    :cidade,
    :estado,
    :pais,
    :telefone,
    :telefone_emergencia,
    :cpf,
    :rg,
    :data_nascimento,
    :email,
    :problemas_saude,
    :responsavel_nome,
    :responsavel_rg,
    :responsavel_cpf,
    :responsavel_qualidade,
    :menor_nome,
    :menor_rg,
    :menor_nascimento,
    :atividade,
    :data_cadastro
)";


            $stmt = $this->db->prepare($sqlMatricula);
            $stmt->execute([
                ':nome' => $dadosMatricula['nome'],
                ':cep' => $dadosMatricula['cep'],
                ':endereco' => $dadosMatricula['endereco'],
                ':bairro' => $dadosMatricula['bairro'],
                ':cidade' => $dadosMatricula['cidade'],
                ':estado' => $dadosMatricula['estado'],
                ':pais' => $dadosMatricula['pais'],
                ':telefone' => $dadosMatricula['telefone'],
                ':telefone_emergencia' => $dadosMatricula['telefone_emergencia'],
                ':cpf' => $dadosMatricula['cpf'],
                ':rg' => $dadosMatricula['rg'],
                ':data_nascimento' => $dadosMatricula['data_nascimento'],
                ':email' => $dadosMatricula['email'],
                ':problemas_saude' => $dadosMatricula['problemas_saude'],
                ':responsavel_nome' => $dadosMatricula['responsavel_nome'],
                ':responsavel_rg' => $dadosMatricula['responsavel_rg'],
                ':responsavel_cpf' => $dadosMatricula['responsavel_cpf'],
                ':responsavel_qualidade' => $dadosMatricula['responsavel_qualidade'],
                ':menor_nome' => $dadosMatricula['menor_nome'],
                ':menor_rg' => $dadosMatricula['menor_rg'],
                ':menor_nascimento' => $dadosMatricula['menor_nascimento'],
                ':atividade' => $dadosMatricula['atividade'],
                ':data_cadastro' => date('Y-m-d H:i:s')
            ]);


            $matriculaId = $this->db->lastInsertId();

            // 2. Inserir na tabela questionario_saude
            $sqlQuestionario = "INSERT INTO questionario_saude (
                matricula_id,
                questionario_saude_problemas,
                questionario_saude_outros,
                questionario_medicamentos,
                questionario_medicamentos_quais,
                questionario_lesao,
                questionario_lesao_qual,
                questionario_acompanhamento,
                questionario_acompanhamento_especialidade,
                questionario_alergias,
                questionario_alergias_quais,
                questionario_atividade_fisica,
                questionario_atividade_fisica_quais,
                questionario_sono,
                questionario_alimentacao,
                questionario_apto,
                questionario_avaliacao_medica,
                questionario_avaliacao_medica_quem
            ) VALUES (
                :matricula_id,
                :saude_problemas,
                :saude_outros,
                :medicamentos,
                :medicamentos_quais,
                :lesao,
                :lesao_qual,
                :acompanhamento,
                :acompanhamento_especialidade,
                :alergias,
                :alergias_quais,
                :atividade_fisica,
                :atividade_fisica_quais,
                :sono,
                :alimentacao,
                :apto,
                :avaliacao_medica,
                :avaliacao_medica_quem
            )";

            $stmt = $this->db->prepare($sqlQuestionario);
            $stmt->execute([
                ':matricula_id' => $matriculaId,
                ':saude_problemas' => $dadosQuestionario['saude_problemas'],
                ':saude_outros' => $dadosQuestionario['saude_outros'],
                ':medicamentos' => $dadosQuestionario['medicamentos'],
                ':medicamentos_quais' => $dadosQuestionario['medicamentos_quais'],
                ':lesao' => $dadosQuestionario['lesao'],
                ':lesao_qual' => $dadosQuestionario['lesao_qual'],
                ':acompanhamento' => $dadosQuestionario['acompanhamento'],
                ':acompanhamento_especialidade' => $dadosQuestionario['acompanhamento_especialidade'],
                ':alergias' => $dadosQuestionario['alergias'],
                ':alergias_quais' => $dadosQuestionario['alergias_quais'],
                ':atividade_fisica' => $dadosQuestionario['atividade_fisica'],
                ':atividade_fisica_quais' => $dadosQuestionario['atividade_fisica_quais'],
                ':sono' => $dadosQuestionario['sono'],
                ':alimentacao' => $dadosQuestionario['alimentacao'],
                ':apto' => $dadosQuestionario['apto'],
                ':avaliacao_medica' => $dadosQuestionario['avaliacao_medica'],
                ':avaliacao_medica_quem' => $dadosQuestionario['avaliacao_medica_quem']
            ]);

            $this->db->commit();

            return $matriculaId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }


    public function matricula_volei($status = null, $nome = null, $cpf = null, $rg = null, $telefone = null, $email = null)
    {
        $sql = "SELECT * FROM matriculas m 
        INNER JOIN questionario_saude q ON m.matricula_id = q.matricula_id 
        WHERE 1=1 ";

        $params = [];

        if (!empty($status)) {
            $sql .= " AND m.status_matricula = :status";
            $params[':status'] = $status;
        }

        if (!empty($nome)) {
            $sql .= " AND m.matricula_nome LIKE :nome";
            $params[':nome'] = '%' . $nome . '%';
        }

        if (!empty($cpf)) {
            $sql .= " AND m.matricula_cpf LIKE :cpf";
            $params[':cpf'] = '%' . $cpf . '%';
        }

        if (!empty($rg)) {
            $sql .= " AND m.matricula_rg LIKE :rg";
            $params[':rg'] = '%' . $rg . '%';
        }

        if (!empty($telefone)) {
            $sql .= " AND m.matricula_telefone LIKE :telefone";
            $params[':telefone'] = '%' . $telefone . '%';
        }

        if (!empty($email)) {
            $sql .= " AND m.matricula_email LIKE :email";
            $params[':email'] = '%' . $email . '%';
        }


        $sql .= " ORDER BY m.matricula_nome ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $matriculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($matriculas as &$matricula) {
            $matricula['matricula_data_cadastro'] = date('d/m/Y H:i:s', strtotime($matricula['matricula_data_cadastro']));
        }

        return $matriculas;
    }




    public function atualizarMatriculaCompleta($id, $dadosMatricula, $dadosQuestionario)
    {
        $this->db->beginTransaction();

        try {
            // Atualiza dados da matrícula
            $sqlMatricula = "UPDATE matriculas SET 
            matricula_nome = :nome,
            matricula_email = :email,
            matricula_cep = :cep,
            matricula_endereco = :endereco,
            matricula_bairro = :bairro,
            matricula_cidade = :cidade,
            matricula_estado = :estado,
            matricula_pais = :pais,
            matricula_telefone = :telefone,
            matricula_telefone_emergencia = :telefone_emergencia,
            matricula_cpf = :cpf,
            matricula_rg = :rg,
            matricula_data_nascimento = :data_nasc,
            matricula_problemas_saude = :problemas,
            matricula_responsavel_nome = :resp_nome,
            matricula_responsavel_rg = :resp_rg,
            matricula_responsavel_cpf = :resp_cpf,
            matricula_responsavel_qualidade = :resp_qualidade,
            matricula_menor_nome = :menor_nome,
            matricula_menor_rg = :menor_rg,
            matricula_menor_nascimento = :menor_nasc,
            matricula_atividade = :atividade,
            status_matricula = :status
        WHERE matricula_id = :id";

            $stmt = $this->db->prepare($sqlMatricula);
            $stmt->execute(array_merge($dadosMatricula, ['id' => $id]));

            // Atualiza questionário
            $sqlQuestionario = "UPDATE questionario_saude SET
            questionario_saude_problemas = :problemas,
            questionario_saude_outros = :outros,
            questionario_medicamentos = :medicamentos,
            questionario_medicamentos_quais = :medicamentos_quais,
            questionario_lesao = :lesao,
            questionario_lesao_qual = :lesao_qual,
            questionario_acompanhamento = :acompanhamento,
            questionario_acompanhamento_especialidade = :especialidade,
            questionario_alergias = :alergias,
            questionario_alergias_quais = :alergias_quais,
            questionario_atividade_fisica = :atividade_fisica,
            questionario_atividade_fisica_quais = :atividade_fisica_quais,
            questionario_sono = :sono,
            questionario_alimentacao = :alimentacao,
            questionario_apto = :apto,
            questionario_avaliacao_medica = :avaliacao_medica,
            questionario_avaliacao_medica_quem = :avaliacao_medica_quem
        WHERE matricula_id = :id";

            $stmt2 = $this->db->prepare($sqlQuestionario);
            $stmt2->execute(array_merge($dadosQuestionario, ['id' => $id]));

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }


    public function buscarFiltrados($filtro = '', $status = '')
    {
        $sql = "SELECT * FROM matriculas WHERE 1";

        if (!empty($filtro)) {
            $sql .= " AND nome LIKE :filtro";
        }

        if (!empty($status)) {
            $sql .= " AND status = :status";
        }

        $stmt = $this->db->prepare($sql);

        if (!empty($filtro)) {
            $stmt->bindValue(':filtro', "%{$filtro}%");
        }

        if (!empty($status)) {
            $stmt->bindValue(':status', $status);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTodas()
    {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM matriculas");
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    public function agruparPorIdade()
    {
        $sql = "
            SELECT 
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, matricula_data_nascimento, CURDATE()) BETWEEN 0 AND 12 THEN '0-12 anos'
                    WHEN TIMESTAMPDIFF(YEAR, matricula_data_nascimento, CURDATE()) BETWEEN 13 AND 17 THEN '13-17 anos'
                    WHEN TIMESTAMPDIFF(YEAR, matricula_data_nascimento, CURDATE()) BETWEEN 18 AND 25 THEN '18-25 anos'
                    WHEN TIMESTAMPDIFF(YEAR, matricula_data_nascimento, CURDATE()) BETWEEN 26 AND 35 THEN '26-35 anos'
                    WHEN TIMESTAMPDIFF(YEAR, matricula_data_nascimento, CURDATE()) BETWEEN 36 AND 50 THEN '36-50 anos'
                    ELSE '50+ anos'
                END AS label,
                COUNT(*) AS valor
            FROM matriculas
            GROUP BY label
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPorAtividade()
    {
        $sql = "
                 SELECT matricula_atividade AS label, COUNT(*) AS valor
FROM matriculas
GROUP BY matricula_atividade
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPorStatus()
    {
        $sql = "
            SELECT status_matricula AS label, COUNT(*) AS valor
            FROM matriculas
            GROUP BY status_matricula
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPorMesCadastro()
    {
        $sql = "
            SELECT 
                DATE_FORMAT(matricula_data_cadastro, '%m/%Y') AS label,
                COUNT(*) AS valor
            FROM matriculas
            GROUP BY label
            ORDER BY MIN(matricula_data_cadastro)
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPorCidade()
    {
        $sql = "
            SELECT matricula_cidade AS label, COUNT(*) AS valor
            FROM matriculas
            GROUP BY matricula_cidade
            ORDER BY valor DESC
        ";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparPorBairro()
    {
        $sql = "SELECT matricula_bairro AS label, COUNT(*) AS valor 
            FROM matriculas 
            GROUP BY matricula_bairro 
            ORDER BY valor DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarAtivos()
    {
        $sql = "SELECT COUNT(*) AS total FROM matriculas WHERE status_matricula = 'Ativo'";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function contarInativos()
    {
        $sql = "SELECT COUNT(*) AS total FROM matriculas WHERE status_matricula = 'Inativo'";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }




    public function cpfExiste($cpf)
    {
        $sql = "SELECT COUNT(*) as total FROM matriculas WHERE matricula_cpf = :cpf";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0;
    }
}
