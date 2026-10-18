<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class MatriculaController extends Controller
{
    private $matriculaModel;

    public function __construct()
    {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


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
                'atividade' => strip_tags(trim(filter_input(INPUT_POST, 'atividade'))),
                'data_cadastro' => date('Y-m-d H:i:s')
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
            $camposObrigatorios = ['nome', 'cep', 'endereco', 'bairro', 'cidade', 'estado', 'pais', 'telefone', 'cpf', 'data_nascimento', 'email', 'atividade'];

            foreach ($camposObrigatorios as $campo) {
                if (empty($dadosMatricula[$campo])) {
                    $_SESSION['erro'] = "Por favor, preencha o campo obrigatório: $campo";
                    header('Location: ' . BASE_URL . 'matricula');
                    exit;
                }
            }

            $matriculaModel = new Matricula();

            // Verificar se o CPF já existe antes de tentar cadastrar
            if ($matriculaModel->cpfExiste($dadosMatricula['cpf'])) {
                $_SESSION['erro'] = "Este CPF já está cadastrado!";
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            }


            try {
                $matriculaModel->salvarMatriculaComQuestionario($dadosMatricula, $dadosQuestionario);
                require_once 'vendors/fpdf/fpdf.php';

                function safe($texto)
                {
                    return iconv("UTF-8", "ISO-8859-1//TRANSLIT", !empty($texto) ? $texto : 'Não informado');
                }

                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetAutoPageBreak(true, 20); // margem inferior

                // --------- TOPO COM LOGO E TÍTULO ---------
                if (file_exists('assets/img/Logo_Cultura.png')) {
                    $pdf->Image('assets/img/Logo_Cultura.png', 85, 10, 40); // Y = 10, altura = 40
                }
                $pdf->SetY(55); // 10 (topo) + 40 (altura da imagem) + 5 (margem extra)

                $pdf->SetFont('Arial', 'B', 16);
                $pdf->SetTextColor(51, 51, 51);
                $pdf->Cell(0, 10, safe(' Confirmação de Matrícula'), 0, 1, 'C');

                $pdf->SetFont('Arial', 'I', 12);
                $pdf->SetTextColor(100, 100, 100);
                $pdf->Cell(0, 8, safe('Cultura Efatá - Projeto Sociocultural'), 0, 1, 'C');
                $pdf->Ln(5);

                $pdf->SetDrawColor(180, 180, 180);
                $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
                $pdf->Ln(8);

                // --------- DADOS DO ALUNO ---------
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->SetTextColor(40, 40, 40);
                $pdf->Cell(0, 10, safe('Dados do Aluno'), 0, 1);

                $pdf->SetFont('Arial', '', 12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFillColor(245, 245, 245);

                $campos = [
                    'Nome' => $dadosMatricula['nome'],
                    'CPF' => $dadosMatricula['cpf'],
                    'Data de Nascimento' => !empty($dadosMatricula['data_nascimento']) ? date('d/m/Y', strtotime($dadosMatricula['data_nascimento'])) : '',
                    'E-mail' => $dadosMatricula['email'],
                    'Telefone' => $dadosMatricula['telefone'],
                    'Atividade' => $dadosMatricula['atividade']
                ];

                foreach ($campos as $label => $valor) {
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(50, 8, safe($label . ':'), 0, 0, '', true);
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->Cell(0, 8, safe($valor), 0, 1, '', true);
                }
                $pdf->Ln(5);

                // --------- QUESTIONÁRIO DE SAÚDE ---------
                $pdf->SetDrawColor(180, 180, 180);
                $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
                $pdf->Ln(8);

                $pdf->SetFont('Arial', 'B', 14);
                $pdf->SetTextColor(40, 40, 40);
                $pdf->Cell(0, 10, safe('Questionário de Saúde'), 0, 1);

                $pdf->SetFont('Arial', '', 12);
                $pdf->SetTextColor(0, 0, 0);

                // Campos detalhados
                $questoes = [
                    'Possui algum problema de saúde?' => $dadosQuestionario['saude_problemas'],
                    'Outros problemas de saúde' => $dadosQuestionario['saude_outros'],
                    'Faz uso de medicamentos?' => $dadosQuestionario['medicamentos'],
                    'Quais medicamentos?' => $dadosQuestionario['medicamentos_quais'],
                    'Possui alguma lesão?' => $dadosQuestionario['lesao'],
                    'Qual lesão?' => $dadosQuestionario['lesao_qual'],
                    'Está em acompanhamento médico?' => $dadosQuestionario['acompanhamento'],
                    'Especialidade do acompanhamento' => $dadosQuestionario['acompanhamento_especialidade'],
                    'Possui alergias?' => $dadosQuestionario['alergias'],
                    'Quais alergias?' => $dadosQuestionario['alergias_quais'],
                    'Pratica atividade física?' => $dadosQuestionario['atividade_fisica'],
                    'Quais atividades físicas?' => $dadosQuestionario['atividade_fisica_quais'],
                    'Como está seu sono?' => $dadosQuestionario['sono'],
                    'Como está sua alimentação?' => $dadosQuestionario['alimentacao'],
                    'Está apto para atividades físicas?' => $dadosQuestionario['apto'],
                    'Foi feita avaliação médica?' => $dadosQuestionario['avaliacao_medica'],
                    'Quem realizou a avaliação médica?' => $dadosQuestionario['avaliacao_medica_quem']
                ];

                foreach ($questoes as $pergunta => $resposta) {
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->MultiCell(0, 8, safe($pergunta . ':'), 0);
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->SetFillColor(248, 248, 248);
                    $pdf->MultiCell(0, 8, safe($resposta), 0, '', true);
                    $pdf->Ln(2);
                }

                // --------- RODAPÉ ---------
                $pdf->Ln(10);
                $pdf->SetDrawColor(180, 180, 180);
                $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());

                $pdf->SetFont('Arial', 'I', 10);
                $pdf->SetTextColor(90, 90, 90);
                $pdf->Cell(0, 10, safe('Documento gerado automaticamente. Cultura Efatá agradece sua matrícula!'), 0, 1, 'C');


                // Salvar PDF temporariamente
                $caminhoPdf = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'matricula_' . time() . '.pdf';
                $pdf->Output('F', $caminhoPdf);

                // PDF 2: Colaboração
                $pdf2 = new FPDF();
                $pdf2->AddPage();

                if (file_exists('assets/img/Logo_Cultura.png')) {
                    $pdf2->Image('assets/img/Logo_Cultura.png', 80, 10, 50);
                }

                $pdf2->SetY(70);
                $pdf2->SetFont('Arial', 'B', 18);
                $pdf2->SetTextColor(0, 0, 0);
                $pdf2->Cell(0, 12, safe('Informações sobre Colaboração'), 0, 1, 'C');

                $pdf2->Ln(10);

                // Caixa: Introdução
                $pdf2->SetFillColor(230, 240, 255); // Azul claro
                $pdf2->SetDrawColor(100, 100, 255); // Azul escuro
                $pdf2->SetLineWidth(0.5);

                $pdf2->SetFont('Arial', '', 13);
                $pdf2->MultiCell(0, 8, safe('Para melhor rendimento do Projeto Cultura Esporte, estamos solicitando uma colaboração mensal no valor de:'), 1, 'J', true);

                $pdf2->Ln(3);

                $pdf2->SetFont('Arial', 'B', 16);
                $pdf2->SetTextColor(0, 102, 204);
                $pdf2->Cell(0, 10, safe('R$ 10,00 (cinco reais)'), 0, 1, 'C');

                $pdf2->Ln(5);
                $pdf2->SetFont('Arial', '', 13);
                $pdf2->SetTextColor(0, 0, 0);

                $pdf2->SetFillColor(255, 255, 240); // Amarelinho claro
                $pdf2->SetDrawColor(200, 180, 50);  // Amarelo escuro

                $pdf2->MultiCell(0, 8, safe('O valor será direcionado para manutenção do projeto, compras de bola, lanches e demais manutenções.'), 1, 'J', true);

                $pdf2->Ln(10);

                // Caixa: Dados para pagamento
                $pdf2->SetFont('Arial', 'B', 14);
                $pdf2->SetFillColor(240, 240, 240);
                $pdf2->SetDrawColor(180, 180, 180);
                $pdf2->Cell(0, 10, safe('DADOS PARA PAGAMENTO:'), 1, 1, 'C', true);

                $pdf2->SetFont('Arial', '', 13);
                $pdf2->SetFillColor(255, 255, 255);
                $pdf2->Cell(0, 8, safe('- Nome: KATIANE DE SOUZA NARCISO'), 1, 1, 'L', true);
                $pdf2->Cell(0, 8, safe('- Chave PIX (Celular): (11) 9 5194-0032'), 1, 1, 'L', true);

                $pdf2->Ln(5);
                $pdf2->SetFont('Arial', 'I', 12);
                $pdf2->MultiCell(0, 8, safe('OBS: Por favor, mande o comprovante neste número.'), 0, 'J');

                $pdf2->Ln(8);

                // Caixa: Data de pagamento
                $pdf2->SetFont('Arial', 'B', 14);
                $pdf2->SetFillColor(240, 240, 240);
                $pdf2->SetDrawColor(180, 180, 180);
                $pdf2->Cell(0, 10, safe('DATA DE PAGAMENTO:'), 1, 1, 'C', true);

                $pdf2->SetFont('Arial', '', 13);
                $pdf2->SetFillColor(255, 255, 255);
                $pdf2->MultiCell(0, 8, safe('Até o dia 15 útil de cada mês.'), 1, 'J', true);

                $pdf2->Ln(15);

                $pdf2->SetFont('Arial', 'I', 11);
                $pdf2->SetTextColor(90, 90, 90);
                $pdf2->MultiCell(0, 8, safe('Obrigado pela sua colaboração. Projeto Cultura Efatá!'), 0, 'C');

                // Salvar PDF
                $caminhoPdf2 = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'colaboracao_' . time() . '.pdf';
                $pdf2->Output('F', $caminhoPdf2);

                // Envio de E-mail
                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                $nome = $dadosMatricula['nome'];
                $email = $dadosMatricula['email'];
                $atividade = $dadosMatricula['atividade'];

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

                // ---------- ADMIN ----------
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
                // $mail->SMTPDebug = 3;
                // $mail->Debugoutput = 'html';
                $mail->send();

                // ---------- USUÁRIO ----------
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
                $mail->addAttachment($caminhoPdf, 'Comprovante_Matricula_CulturaEfatá.pdf');
                $mail->addAttachment($caminhoPdf2, 'Colaboracao_CulturaEfatá.pdf');
                $mail->send();

                // Remove PDF temporário
                if (file_exists($caminhoPdf)) {
                    unlink($caminhoPdf);
                }

                if (file_exists($caminhoPdf2)) {
                    unlink($caminhoPdf2);
                }


                $_SESSION['sucesso'] = "Matrícula realizada com sucesso! Verifique seu email (inclusive caixa de spam).";
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) {
                    $_SESSION['erro'] = "Este CPF já está cadastrado! Tente novamente.";
                } else {
                    $_SESSION['erro'] = "Erro ao realizar matrícula ou enviar e-mail: " . $e->getMessage();
                }
                header('Location: ' . BASE_URL . 'matricula');
                exit;
            }
        }
    }

    public function matriculas()
    {
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Captura os filtros individualmente
        $status = $_GET['status'] ?? null;
        $nome = $_GET['nome'] ?? null;
        $cpf = $_GET['cpf'] ?? null;
        $rg = $_GET['rg'] ?? null;
        $telefone = $_GET['telefone'] ?? null;
        $email = $_GET['email'] ?? null;

        $dados = [];
        $dados['listarMatriculas'] = $this->matriculaModel->matricula_volei($status, $nome, $cpf, $rg, $telefone, $email);
        $dados['conteudo'] = 'dash/matriculas/listar';

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function atualizar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Campos da tabela matriculas
            $dadosMatricula = [
                'nome' => $_POST['matricula_nome'] ?? '',
                'email' => $_POST['matricula_email'] ?? '',
                'cep' => $_POST['matricula_cep'] ?? '',
                'endereco' => $_POST['matricula_endereco'] ?? '',
                'bairro' => $_POST['matricula_bairro'] ?? '',
                'cidade' => $_POST['matricula_cidade'] ?? '',
                'estado' => $_POST['matricula_estado'] ?? '',
                'pais' => $_POST['matricula_pais'] ?? '',
                'telefone' => $_POST['matricula_telefone'] ?? '',
                'telefone_emergencia' => $_POST['matricula_telefone_emergencia'] ?? '',
                'cpf' => $_POST['matricula_cpf'] ?? '',
                'rg' => $_POST['matricula_rg'] ?? '',
                'data_nasc' => $_POST['matricula_data_nascimento'] ?? '',
                'problemas' => $_POST['matricula_problemas_saude'] ?? '',
                'resp_nome' => $_POST['matricula_responsavel_nome'] ?? '',
                'resp_rg' => $_POST['matricula_responsavel_rg'] ?? '',
                'resp_cpf' => $_POST['matricula_responsavel_cpf'] ?? '',
                'resp_qualidade' => $_POST['matricula_responsavel_qualidade'] ?? '',
                'menor_nome' => $_POST['matricula_menor_nome'] ?? '',
                'menor_rg' => $_POST['matricula_menor_rg'] ?? '',
                'menor_nasc' => $_POST['matricula_menor_nascimento'] ?? '',
                'atividade' => $_POST['matricula_atividade'] ?? '',
                'status' => $_POST['status_matricula'] ?? 'Ativo'
            ];

            // Campos da tabela questionario_saude
            $dadosQuestionario = [
                'problemas' => $_POST['questionario_saude_problemas'] ?? '',
                'outros' => $_POST['questionario_saude_outros'] ?? '',
                'medicamentos' => $_POST['questionario_medicamentos'] ?? '',
                'medicamentos_quais' => $_POST['questionario_medicamentos_quais'] ?? '',
                'lesao' => $_POST['questionario_lesao'] ?? '',
                'lesao_qual' => $_POST['questionario_lesao_qual'] ?? '',
                'acompanhamento' => $_POST['questionario_acompanhamento'] ?? '',
                'especialidade' => $_POST['questionario_acompanhamento_especialidade'] ?? '',
                'alergias' => $_POST['questionario_alergias'] ?? '',
                'alergias_quais' => $_POST['questionario_alergias_quais'] ?? '',
                'atividade_fisica' => $_POST['questionario_atividade_fisica'] ?? '',
                'atividade_fisica_quais' => $_POST['questionario_atividade_fisica_quais'] ?? '',
                'sono' => $_POST['questionario_sono'] ?? '',
                'alimentacao' => $_POST['questionario_alimentacao'] ?? '',
                'apto' => $_POST['questionario_apto'] ?? '',
                'avaliacao_medica' => $_POST['questionario_avaliacao_medica'] ?? '',
                'avaliacao_medica_quem' => $_POST['questionario_avaliacao_medica_quem'] ?? ''
            ];



            $this->matriculaModel->atualizarMatriculaCompleta($id, $dadosMatricula, $dadosQuestionario);

            $_SESSION['sucesso'] = 'Matrícula e questionário atualizados com sucesso!';
            header('Location: ' . BASE_URL . 'matricula/matriculas');
            exit;
        }
    }

    public function exportarPDF()
    {
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        // Filtros
        $status = $_GET['status'] ?? null;
        $nome = $_GET['nome'] ?? null;
        $cpf = $_GET['cpf'] ?? null;
        $rg = $_GET['rg'] ?? null;
        $telefone = $_GET['telefone'] ?? null;
        $email = $_GET['email'] ?? null;

        // Dados do relatório
        $dados = $this->matriculaModel->matricula_volei($status, $nome, $cpf, $rg, $telefone, $email);

        // Ordena alfabeticamente por nome
        usort($dados, fn($a, $b) => strcmp($a['matricula_nome'], $b['matricula_nome']));

        // Carrega HTML do relatório
        ob_start();
        include __DIR__ . '/../views/pdf/relatorio_matriculas.php';
        $html = ob_get_clean();

        // Configurações do DomPDF
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // (Opcional) Numeração de páginas
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(520, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, [0, 0, 0]);

        // Envia para o navegador
        $dompdf->stream('relatorio_matriculas.pdf', ['Attachment' => false]);
        exit;
    }

    public function exportarExcel()
    {
        // Verifica se o usuário está logado e é funcionário
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: /');
            exit;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';



        // Filtros
        $filtro = $_GET['filtro'] ?? '';
        $status = $_GET['status'] ?? '';

        $matriculaModel = new Matricula();
        $matriculas = $matriculaModel->buscarFiltrados($filtro, $status);

        // Ordena em ordem alfabética pelo nome
        usort($matriculas, function ($a, $b) {
            return strcmp($a['matricula_nome'], $b['matricula_nome']);
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatório de Matrículas');

        // Cabeçalhos
        $cabecalhos = [
            'ID',
            'Nome',
            'CEP',
            'Endereço',
            'Bairro',
            'Cidade',
            'Estado',
            'País',
            'Telefone',
            'Telefone Emergência',
            'CPF',
            'RG',
            'Data Nascimento',
            'Email',
            'Problemas de Saúde',
            'Responsável Nome',
            'Responsável RG',
            'Responsável CPF',
            'Qualidade do Responsável',
            'Nome do Menor',
            'RG do Menor',
            'Nascimento do Menor',
            'Atividade',
            'Data de Cadastro',
            'Status'
        ];

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E88E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        // Preenche cabeçalhos
        $coluna = 'A';
        foreach ($cabecalhos as $cabecalho) {
            $sheet->setCellValue("{$coluna}1", $cabecalho);
            $sheet->getStyle("{$coluna}1")->applyFromArray($headerStyle);
            $sheet->getColumnDimension($coluna)->setAutoSize(true);
            $coluna++;
        }

        // Preenche dados
        $linha = 2;
        foreach ($matriculas as $matricula) {
            $sheet->fromArray([
                $matricula['matricula_id'],
                $matricula['matricula_nome'],
                $matricula['matricula_cep'],
                $matricula['matricula_endereco'],
                $matricula['matricula_bairro'],
                $matricula['matricula_cidade'],
                $matricula['matricula_estado'],
                $matricula['matricula_pais'],
                $matricula['matricula_telefone'],
                $matricula['matricula_telefone_emergencia'],
                $matricula['matricula_cpf'],
                $matricula['matricula_rg'],
                $matricula['matricula_data_nascimento'],
                $matricula['matricula_email'],
                $matricula['matricula_problemas_saude'],
                $matricula['matricula_responsavel_nome'],
                $matricula['matricula_responsavel_rg'],
                $matricula['matricula_responsavel_cpf'],
                $matricula['matricula_responsavel_qualidade'],
                $matricula['matricula_menor_nome'],
                $matricula['matricula_menor_rg'],
                $matricula['matricula_menor_nascimento'],
                $matricula['matricula_atividade'],
                $matricula['matricula_data_cadastro'],
                $matricula['status_matricula']
            ], null, "A{$linha}");
            $linha++;
        }

        // Estilo geral das células preenchidas
        $sheet->getStyle("A2:Y" . ($linha - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Congela o cabeçalho
        $sheet->freezePane('A2');

        // Configura headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="matriculas_ordenadas.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function totalMatriculas()
    {
        $matriculaModel = new Matricula();
        $total = $matriculaModel->contarTodas();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['total' => $total]);
    }

    public function graficoPorIdade()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorIdade();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function graficoPorAtividade()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorAtividade();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function graficoPorStatus()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorStatus();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function graficoPorMes()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorMesCadastro();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function graficoPorCidade()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorCidade();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function totalAtivos()
    {
        $matriculaModel = new Matricula();
        $total = $matriculaModel->contarAtivos();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['total' => $total]);
    }

    public function totalInativos()
    {
        $matriculaModel = new Matricula();
        $total = $matriculaModel->contarInativos();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['total' => $total]);
    }

    public function graficoPorBairro()
    {
        $matriculaModel = new Matricula();
        $dados = $matriculaModel->agruparPorBairro();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function verificarCpf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cpf = trim($_POST['cpf'] ?? '');
            $matriculaModel = new Matricula();
            $existe = $matriculaModel->cpfExiste($cpf);
            echo json_encode(['existe' => $existe]);
            exit;
        }
    }
}
