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
}
