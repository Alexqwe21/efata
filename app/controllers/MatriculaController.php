<?php

class MatriculaController extends Controller
{


    private $matriculaModel;

    public function __construct()
    {


        $this->matriculaModel = new Matricula;

    }

    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';



        //var_dump($dados);

        $this->carregarViews('matricula', $dados);
    }


    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start(); // iniciar sessão para usar $_SESSION

            // Captura e limpa dados da matrícula
            $dadosMatricula = [
                'nome' => strip_tags(trim(filter_input(INPUT_POST, 'nome'))),
                'cep' => strip_tags(trim(filter_input(INPUT_POST, 'cep'))),
                'endereco' => strip_tags(trim(filter_input(INPUT_POST, 'endereco'))),
                'bairro' => strip_tags(trim(filter_input(INPUT_POST, 'bairro'))),
                'cidade' => strip_tags(trim(filter_input(INPUT_POST, 'cidade'))),
                'estado' => strtoupper(strip_tags(trim(filter_input(INPUT_POST, 'estado')))),
                'pais' => strip_tags(trim(filter_input(INPUT_POST, 'pais'))),
                'telefone' => strip_tags(trim(filter_input(INPUT_POST, 'telefone'))),
                'telefone_emergencia' => strip_tags(trim(filter_input(INPUT_POST, 'telefone_emergencia'))),
                'cpf' => strip_tags(trim(filter_input(INPUT_POST, 'cpf'))),
                'rg' => strip_tags(trim(filter_input(INPUT_POST, 'rg'))),
                'data_nascimento' => strip_tags(trim(filter_input(INPUT_POST, 'data_nascimento'))),
                'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
                'problemas_saude' => strip_tags(trim(filter_input(INPUT_POST, 'problemas_saude'))),
                'responsavel_nome' => strip_tags(trim(filter_input(INPUT_POST, 'responsavel_nome'))),
                'responsavel_rg' => strip_tags(trim(filter_input(INPUT_POST, 'responsavel_rg'))),
                'responsavel_cpf' => strip_tags(trim(filter_input(INPUT_POST, 'responsavel_cpf'))),
                'responsavel_qualidade' => strip_tags(trim(filter_input(INPUT_POST, 'responsavel_qualidade'))),
                'menor_nome' => strip_tags(trim(filter_input(INPUT_POST, 'menor_nome'))),
                'menor_rg' => strip_tags(trim(filter_input(INPUT_POST, 'menor_rg'))),
                'menor_nascimento' => strip_tags(trim(filter_input(INPUT_POST, 'menor_nascimento'))),
                'atividade' => strip_tags(trim(filter_input(INPUT_POST, 'atividade')))
            ];

            // Captura e limpa dados do questionário
            $dadosQuestionario = [
                'saude_problemas' => implode(',', $_POST['saude_problemas'] ?? []),
                'saude_outros' => strip_tags(trim(filter_input(INPUT_POST, 'saude_outros'))),
                'medicamentos' => strip_tags(trim(filter_input(INPUT_POST, 'medicamentos'))),
                'medicamentos_quais' => strip_tags(trim(filter_input(INPUT_POST, 'medicamentos_quais'))),
                'lesao' => strip_tags(trim(filter_input(INPUT_POST, 'lesao'))),
                'lesao_qual' => strip_tags(trim(filter_input(INPUT_POST, 'lesao_qual'))),
                'acompanhamento' => strip_tags(trim(filter_input(INPUT_POST, 'acompanhamento'))),
                'acompanhamento_especialidade' => strip_tags(trim(filter_input(INPUT_POST, 'acompanhamento_especialidade'))),
                'alergias' => strip_tags(trim(filter_input(INPUT_POST, 'alergias'))),
                'alergias_quais' => strip_tags(trim(filter_input(INPUT_POST, 'alergias_quais'))),
                'atividade_fisica' => strip_tags(trim(filter_input(INPUT_POST, 'atividade_fisica'))),
                'atividade_fisica_quais' => strip_tags(trim(filter_input(INPUT_POST, 'atividade_fisica_quais'))),
                'sono' => strip_tags(trim(filter_input(INPUT_POST, 'sono'))),
                'alimentacao' => strip_tags(trim(filter_input(INPUT_POST, 'alimentacao'))),
                'apto' => strip_tags(trim(filter_input(INPUT_POST, 'apto'))),
                'avaliacao_medica' => strip_tags(trim(filter_input(INPUT_POST, 'avaliacao_medica'))),
                'avaliacao_medica_quem' => strip_tags(trim(filter_input(INPUT_POST, 'avaliacao_medica_quem')))
            ];

            // Formatar data de nascimento do menor, se existir
            if (!empty($dadosMatricula['menor_nascimento'])) {
                $data = DateTime::createFromFormat('d/m/Y', $dadosMatricula['menor_nascimento']);
                $dadosMatricula['menor_nascimento'] = $data ? $data->format('Y-m-d') : null;
            } else {
                $dadosMatricula['menor_nascimento'] = null;
            }

            // Formatar data de nascimento principal
            if (!empty($dadosMatricula['data_nascimento'])) {
                $data = DateTime::createFromFormat('d/m/Y', $dadosMatricula['data_nascimento']);
                $dadosMatricula['data_nascimento'] = $data ? $data->format('Y-m-d') : null;
            } else {
                $dadosMatricula['data_nascimento'] = null;
            }

            // Validação básica dos campos obrigatórios
            $camposObrigatorios = ['nome', 'cep', 'endereco', 'bairro', 'cidade', 'estado', 'pais', 'telefone', 'cpf',  'data_nascimento', 'email', 'atividade'];

            foreach ($camposObrigatorios as $campo) {
                if (empty($dadosMatricula[$campo])) {
                    $_SESSION['erro'] = "Por favor, preencha o campo obrigatório: $campo";
                    header('Location: ' . BASE_URL . 'matricula');
                    exit;
                }
            }
            $matriculaModel = new Matricula();

            try {
                $matriculaModel->salvarMatriculaComQuestionario($dadosMatricula, $dadosQuestionario);

                $_SESSION['sucesso'] = "Matrícula realizada com sucesso! Verifique o email ou a caixa de spam.";

                header('Location: ' . BASE_URL . 'matricula'); // redireciona para o formulário
                exit;
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro ao realizar matrícula: " . $e->getMessage();
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            }

        }
    }





}
