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
            session_start();

            // Dados da matrícula
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

            // Dados do questionário
            $dadosQuestionario = [
                'saude_problemas' => implode(', ', $_POST['saude_problemas'] ?? []),
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

            // Formatar datas
            $dadosMatricula['menor_nascimento'] = !empty($dadosMatricula['menor_nascimento']) ?
                (DateTime::createFromFormat('d/m/Y', $dadosMatricula['menor_nascimento']) ?: null)?->format('Y-m-d') : null;
            $dadosMatricula['data_nascimento'] = !empty($dadosMatricula['data_nascimento']) ?
                (DateTime::createFromFormat('d/m/Y', $dadosMatricula['data_nascimento']) ?: null)?->format('Y-m-d') : null;

            // Campos obrigatórios
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

                // Gera o PDF
                require_once 'vendors/fpdf/fpdf.php';

                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(0, 10, 'Confirmação de Matrícula - Cultura Efatá', 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->SetFont('Arial', '', 12);

                $pdf->Cell(50, 8, 'Nome:', 0, 0);
                $pdf->Cell(0, 8, $dadosMatricula['nome'], 0, 1);

                $pdf->Cell(50, 8, 'CPF:', 0, 0);
                $pdf->Cell(0, 8, $dadosMatricula['cpf'], 0, 1);

                $pdf->Cell(50, 8, 'Data Nascimento:', 0, 0);
                $dtNasc = !empty($dadosMatricula['data_nascimento']) ? date('d/m/Y', strtotime($dadosMatricula['data_nascimento'])) : '';
                $pdf->Cell(0, 8, $dtNasc, 0, 1);

                $pdf->Cell(50, 8, 'E-mail:', 0, 0);
                $pdf->Cell(0, 8, $dadosMatricula['email'], 0, 1);

                $pdf->Cell(50, 8, 'Telefone:', 0, 0);
                $pdf->Cell(0, 8, $dadosMatricula['telefone'], 0, 1);

                $pdf->Cell(50, 8, 'Atividade:', 0, 0);
                $pdf->Cell(0, 8, $dadosMatricula['atividade'], 0, 1);

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 8, 'Questionário de Saúde', 0, 1);
                $pdf->SetFont('Arial', '', 12);

                $pdf->MultiCell(0, 7, "Problemas de Saúde: " . $dadosQuestionario['saude_problemas']);
                $pdf->MultiCell(0, 7, "Outros Problemas: " . $dadosQuestionario['saude_outros']);
                $pdf->MultiCell(0, 7, "Medicamentos: " . $dadosQuestionario['medicamentos']);
                $pdf->MultiCell(0, 7, "Lesão: " . $dadosQuestionario['lesao']);
                $pdf->MultiCell(0, 7, "Acompanhamento Médico: " . $dadosQuestionario['acompanhamento']);
                $pdf->MultiCell(0, 7, "Alergias: " . $dadosQuestionario['alergias']);
                $pdf->MultiCell(0, 7, "Atividade Física: " . $dadosQuestionario['atividade_fisica']);

                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'I', 10);
                $pdf->Cell(0, 7, 'Documento gerado automaticamente. Cultura Efatá agradece sua matrícula.', 0, 1, 'C');

                $caminhoPdf = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'matricula_' . time() . '.pdf';
                $pdf->Output('F', $caminhoPdf);

                // Envio de e-mail
                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                $nome = $dadosMatricula['nome'];
                $email = $dadosMatricula['email'];
                $atividade = $dadosMatricula['atividade'];

                // Configuração SMTP
                $mail->isSMTP();
                $mail->Host = HOTS_EMAIL;
                $mail->Port = PORT_EMAIL;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Username = USER_EMAIL;
                $mail->Password = PASS_EMAIL;
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
                $mail->isHTML(true);

                // --------- Enviar para o ADMIN ---------
                $mail->setFrom(USER_EMAIL, 'Nova Matrícula - Cultura Efatá');
                $mail->addAddress(USER_EMAIL, 'Cultura Efatá');
                $mail->Subject = '📥 Nova Matrícula Realizada';
                $mail->msgHTML("
                <p><strong>Nome:</strong> $nome</p>
                <p><strong>E-mail:</strong> $email</p>
                <p><strong>Atividade:</strong> $atividade</p>
                <p>✅ Matrícula realizada com sucesso!</p>
            ");
                $mail->AltBody = "Nova matrícula: $nome - $email - Atividade: $atividade";
                $mail->send();

                // --------- Enviar para o USUÁRIO ---------
                $mail->clearAddresses();
                $mail->addAddress($email, $nome);
                $mail->Subject = '✅ Confirmação de Matrícula - Cultura Efatá';

                $mail->msgHTML("
                <div style='font-family: Arial, sans-serif; padding: 20px;'>
                    <h2 style='color: #4CAF50;'>🎉 Matrícula Confirmada!</h2>
                    <p>Olá <strong>$nome</strong>,</p>
                    <p>Obrigado por se inscrever na atividade <strong>$atividade</strong> com a gente!</p>
                    <p>Segue em anexo o comprovante da sua matrícula.</p>
                    <p>Fique atento ao seu e-mail para mais informações e atualizações.</p>
                    <p><strong>Equipe Cultura Efatá</strong></p>
                </div>
            ");
                $mail->AltBody = "Olá $nome,\n\nSua matrícula na atividade '$atividade' foi confirmada!\n\nSegue o comprovante da matrícula em anexo.\n\nEquipe Cultura Efatá";

                // Anexa o PDF
                $mail->addAttachment($caminhoPdf, 'Comprovante_Matricula_CulturaEfatá.pdf');

                $mail->send();

                // Apaga o arquivo temporário do PDF
                if (file_exists($caminhoPdf)) {
                    unlink($caminhoPdf);
                }

                $_SESSION['sucesso'] = "Matrícula realizada com sucesso! Verifique seu email (inclusive caixa de spam).";
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro ao realizar matrícula ou enviar e-mail: " . $mail->ErrorInfo;
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            }
        }
    }
}
