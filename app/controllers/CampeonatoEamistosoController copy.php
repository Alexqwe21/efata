<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CampeonatoEamistosoController extends Controller
{

    private $campeonatoEamistosoModel;

    public function __construct()
    {
        // Inicializa a sessão se ainda não estiver iniciada
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }


        $this->campeonatoEamistosoModel = new CampeonatoEamistoso;
    }


    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';



        //var_dump($dados);

        $this->carregarViews('campeonatoEamistoso', $dados);
    }



    public function salvarTimeEJogadores()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $nomeTime = strip_tags(trim($_POST['nome_time']));
            $emailTime = strip_tags(trim($_POST['email_campeonato']));
            $statusTime = 'Ativo';
            $fotoTime = '';

            $jogadores = $_POST['jogadores'] ?? [];

            if (empty($nomeTime) || empty($jogadores)) {
                $_SESSION['erro'] = "Informe o nome do time e pelo menos um jogador.";
                header('Location: ' . BASE_URL . 'cadastro-time');
                exit;
            }



            $campeonatoEamistosoModel = new CampeonatoEamistoso();

            // Verifica se já existe um time com esse nome
            $timeExistente = $campeonatoEamistosoModel->buscarPorNomeTime($nomeTime);
            if ($timeExistente) {
                $_SESSION['erro'] = "Este time já está cadastrado. Verifique seu e-mail ou tente com outro nome.";
                header('Location: ' . BASE_URL . 'campeonatoEamistoso');
                exit;
            }


            try {
                $idTime = $campeonatoEamistosoModel->salvarTime([
                    'nome_time' => $nomeTime,
                    'foto_time' => $fotoTime,
                    'status_time' => $statusTime,
                    'data_cadastro_time' => date('Y-m-d H:i:s'),
                    'email_campeonato' => $emailTime
                ]);

                foreach ($jogadores as $jogador) {
                    $campeonatoEamistosoModel->salvarJogador([
                        'id_campeonato' => $idTime,
                        'nome_completo_jogador' => strip_tags(trim($jogador['nome_completo'] ?? '')),
                        'rg_jogador' => strip_tags(trim($jogador['rg'] ?? '')),
                        'data_nascimento_jogador' => $this->formatarData($jogador['data_nascimento'] ?? ''),
                        'posicao_voleibol_jogador' => strip_tags(trim($jogador['posicao'] ?? '')),
                        'telefone_jogador' => strip_tags(trim($jogador['telefone'] ?? '')),
                        'status_jogador' => 'Ativo'
                    ]);
                }

                // ------- PDF --------
                require_once 'vendors/fpdf/fpdf.php';

                function safe($texto)
                {
                    return iconv("UTF-8", "ISO-8859-1//TRANSLIT", !empty($texto) ? $texto : 'Não informado');
                }

                $pdf = new FPDF();
                $pdf->AddPage();
                $pdf->SetAutoPageBreak(true, 20);

                if (file_exists('assets/img/Logo_Cultura.png')) {
                    $pdf->Image('assets/img/Logo_Cultura.png', 85, 10, 40);
                }
                $pdf->SetY(55);

                $pdf->SetFont('Arial', 'B', 16);
                $pdf->Cell(0, 10, safe('Confirmação de Inscrição do Time'), 0, 1, 'C');

                $pdf->SetFont('Arial', 'I', 12);
                $pdf->Cell(0, 8, safe('Cultura Efatá - Campeonato e Amistoso'), 0, 1, 'C');
                $pdf->Ln(5);
                $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
                $pdf->Ln(8);

                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 10, safe('Dados do Time'), 0, 1);

                $pdf->SetFont('Arial', '', 12);
                $camposTime = [
                    'Nome do Time' => $nomeTime,
                    'E-mail' => $emailTime,
                    'Status' => $statusTime,
                    'Data de Cadastro' => date('d/m/Y H:i:s')
                ];

                foreach ($camposTime as $label => $valor) {
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(50, 8, safe($label . ':'), 0, 0);
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->Cell(0, 8, safe($valor), 0, 1);
                }
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 14);
                $pdf->Cell(0, 10, safe('Jogadores Cadastrados'), 0, 1);

                $pdf->SetFont('Arial', '', 11);
                foreach ($jogadores as $index => $jogador) {
                    $pdf->SetFont('Arial', 'B', 11);
                    $pdf->Cell(0, 8, safe('Jogador ' . ($index + 1)), 0, 1);
                    $pdf->SetFont('Arial', '', 11);

                    $pdf->Cell(60, 6, safe('Nome: ' . ($jogador['nome_completo'] ?? '')), 0, 1);
                    $pdf->Cell(60, 6, safe('RG: ' . ($jogador['rg'] ?? '')), 0, 1);
                    $pdf->Cell(60, 6, safe('Data de Nascimento: ' . ($jogador['data_nascimento'] ?? '')), 0, 1);
                    $pdf->Cell(60, 6, safe('Posição: ' . ($jogador['posicao'] ?? '')), 0, 1);
                    $pdf->Cell(60, 6, safe('Telefone: ' . ($jogador['telefone'] ?? '')), 0, 1);
                    $pdf->Ln(3);
                }

                // Criar diretório temporário se necessário
                $caminhoPasta = 'uploads/temp';
                if (!is_dir($caminhoPasta)) {
                    mkdir($caminhoPasta, 0777, true);
                }

                $caminhoPdf = $caminhoPasta . '/comprovante_time_' . $idTime . '.pdf';
                $pdf->Output('F', $caminhoPdf);

                // ------- E-MAIL --------
                require_once("vendors/phpmailer/PHPMailer.php");
                require_once("vendors/phpmailer/SMTP.php");
                require_once("vendors/phpmailer/Exception.php");

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

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

                // Enviar para organização
                $mail->setFrom(USER_EMAIL, 'Nova Inscrição - Cultura Efatá');
                $mail->addAddress(USER_EMAIL, 'Organização Cultura Efatá');
                $mail->Subject = '📥 Nova Inscrição de Time no Campeonato';
                $mail->msgHTML("<p><strong>Time:</strong> $nomeTime</p><p><strong>Email:</strong> $emailTime</p><p><strong>Status:</strong> $statusTime</p><p>✅ Novo time cadastrado com sucesso!</p>");
                $mail->AltBody = "Novo time: $nomeTime - $emailTime";
                $mail->addAttachment($caminhoPdf, 'Comprovante_Inscricao_Time.pdf');
                $mail->send();

                // Enviar para o time
                $mail->clearAddresses();
                $mail->addAddress($emailTime, $nomeTime);
                $mail->Subject = '✅ Confirmação de Inscrição - Cultura Efatá';
                $mail->msgHTML("<div style='font-family: Arial, sans-serif; padding: 20px;'><h2 style='color: #4CAF50;'>🎉 Inscrição Confirmada!</h2><p>Olá <strong>$nomeTime</strong>,</p><p>Obrigado por se inscrever em nosso campeonato/amistoso.</p><p>Segue em anexo o comprovante com os dados do time e jogadores.</p><p><strong>Equipe Cultura Efatá</strong></p></div>");
                $mail->AltBody = "Olá $nomeTime,\n\nSua inscrição foi confirmada!\n\nSegue o comprovante da inscrição em anexo.\n\nEquipe Cultura Efatá";
                $mail->addAttachment($caminhoPdf, 'Comprovante_Inscricao_Time.pdf');
                $mail->send();

                // Apaga o PDF
                if (file_exists($caminhoPdf)) {
                    unlink($caminhoPdf);
                }

                $_SESSION['sucesso'] = "Cadastro realizado! Verifique seu e-mail ou spam para a confirmação.";
                header('Location: ' . BASE_URL . 'campeonatoEamistoso');
                exit;
            } catch (PDOException $e) {
                $_SESSION['erro'] = "Erro ao salvar time e jogadores: " . $e->getMessage();
                header('Location: ' . BASE_URL . 'campeonatoEamistoso');
                exit;
            }
        }
    }



    private function formatarData($data)
    {
        if (!empty($data)) {
            $date = DateTime::createFromFormat('d/m/Y', $data);
            return $date ? $date->format('Y-m-d') : null;
        }
        return null;
    }



    public function campeonatoListar()
    {
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Coleta os filtros da URL
        $filtros = [
            'nome_time' => $_GET['nome_time'] ?? '',
            'email_campeonato' => $_GET['email_campeonato'] ?? '',
            'status_time' => $_GET['status_time'] ?? '',
            'nome_jogador' => $_GET['nome_jogador'] ?? '',
            'telefone_jogador' => $_GET['telefone_jogador'] ?? '',
            'rg_jogador' => $_GET['rg_jogador'] ?? ''
        ];

        // Consulta os dados filtrados
        $retorno = $this->campeonatoEamistosoModel->listarCampeonatoAmistoso($filtros);

        $dados = [
            'listarCampeonato' => $retorno['campeonatos'],
            'jogadores' => $retorno['jogadores'],
            'conteudo' => 'dash/campeonato/listar',
            'filtros' => $filtros // Passa os filtros para manter os valores no formulário
        ];

        $this->carregarViews('dash/dashboard', $dados);
    }



    public function atualizar($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dadosTime = [
                'nome_time' => $_POST['nome_time'],
                'email_campeonato' => $_POST['email_campeonato'],
                'status_time' => $_POST['status_time'],
            ];

            // Upload da imagem do time
            $fotoTime = $this->uploadFoto($_FILES['foto_time'] ?? []);

            $jogadores = [];

            // var_dump($fotoTime);
            // exit;

            foreach ($_POST['jogadores'] as $jogador) {
                $dataNascimento = null;
                if (!empty($jogador['data_nascimento_jogador'])) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $jogador['data_nascimento_jogador']);
                    if ($dateObj !== false) {
                        $dataNascimento = $dateObj->format('Y-m-d');
                    }
                }

                $jogadores[] = [
                    'id_jogador' => $jogador['id_jogador'],
                    'nome_completo_jogador' => $jogador['nome_completo_jogador'],
                    'rg_jogador' => $jogador['rg_jogador'],
                    'data_nascimento_jogador' => $dataNascimento,
                    'posicao_voleibol_jogador' => $jogador['posicao_voleibol_jogador'],
                    'telefone_jogador' => $jogador['telefone_jogador'],
                    'status_jogador' => $jogador['status_jogador'],
                ];
            }

            try {
                $campeonatoEamistosoModel = new CampeonatoEamistoso();
                $campeonatoEamistosoModel->atualizarTimeEJogadores($id, $dadosTime, $jogadores, $fotoTime);

                $_SESSION['sucesso'] = 'Time e jogadores atualizados com sucesso!';
            } catch (Exception $e) {
                $_SESSION['erro'] = 'Erro ao atualizar time ou jogadores: ' . $e->getMessage();
            }

            header('Location: ' . BASE_URL . 'campeonatoEamistoso/campeonatoListar');
            exit;
        }
    }

    // Função de upload da imagem
    private function uploadFoto($file)
    {
        $dir = __DIR__ . '/../../uploads/';

        if (!file_exists($dir . 'time/')) {
            mkdir($dir . 'time/', 0755, true);
        }

        if (isset($file['tmp_name']) && !empty($file['tmp_name'])) {
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $nome_arquivo = 'time/' . uniqid() . '.' . $ext;

            if (move_uploaded_file($file['tmp_name'], $dir . $nome_arquivo)) {
                return $nome_arquivo;
            }
        }

        // Retorna a imagem padrão caso não tenha sido enviada uma nova
        return null;
    }


    public function exportarPDFCampeonatos()
    {
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        // Coleta os filtros da URL
        $filtros = [
            'status_time' => $_GET['status'] ?? null,
            'nome_time' => $_GET['nome'] ?? null,
            'email_campeonato' => $_GET['email'] ?? null,
            'nome_jogador' => $_GET['nome_jogador'] ?? null,
            'telefone_jogador' => $_GET['telefone'] ?? null,
            'rg_jogador' => $_GET['rg'] ?? null
        ];

        // Busca os dados filtrados
        $retorno = $this->campeonatoEamistosoModel->listarCampeonatoAmistoso($filtros);

        $dados['listarCampeonato'] = $retorno['campeonatos'];
        $dados['jogadores'] = $retorno['jogadores'];

        // Ordena os times por nome
        usort($dados['listarCampeonato'], fn($a, $b) => strcmp($a['nome_time'], $b['nome_time']));

        // Extrai variáveis para a view
        $listarCampeonato = $dados['listarCampeonato'];
        $jogadores = $dados['jogadores'];

        // Carrega a view HTML do PDF
        ob_start();
        include __DIR__ . '/../views/pdf/relatorio_campeonatos.php';
        $html = ob_get_clean();

        // Configura o DomPDF
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Numeração de páginas
        $canvas = $dompdf->get_canvas();
        $canvas->page_text(520, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 9, [0, 0, 0]);

        // Gera o PDF no navegador
        $dompdf->stream('relatorio_campeonatos.pdf', ['Attachment' => false]);
        exit;
    }


    public function exportarExcelCampeonatos()
    {
        // Verifica se o usuário está logado e é funcionário
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: /');
            exit;
        }

        require_once __DIR__ . '/../../vendor/autoload.php';

        // Captura os filtros que você usa no sistema, adapte se necessário
        $filtros = [
            'status_time' => $_GET['status'] ?? null,
            'nome_time' => $_GET['nome'] ?? null,
            'email_campeonato' => $_GET['email'] ?? null,
            'nome_jogador' => $_GET['nome_jogador'] ?? null,
            'telefone_jogador' => $_GET['telefone'] ?? null,
            'rg_jogador' => $_GET['rg'] ?? null,
        ];

        // Busca dados filtrados pelo modelo (função que você já tem)
        $retorno = $this->campeonatoEamistosoModel->listarCampeonatoAmistoso($filtros);

        $campeonatos = $retorno['campeonatos'];
        $jogadores = $retorno['jogadores'];

        // Ordena os campeonatos pelo nome_time
        usort($campeonatos, fn($a, $b) => strcmp($a['nome_time'], $b['nome_time']));

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Relatório de Campeonatos');

        // Cabeçalhos
        $cabecalhos = [
            'ID Time',
            'Nome Time',
            'Status Time',
            'Email Time',
            'Data Cadastro Time',
            'ID Jogador',
            'Nome Jogador',
            'RG Jogador',
            'Data Nascimento Jogador',
            'Posição',
            'Telefone Jogador',
            'Status Jogador'
        ];

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E88E5']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ];

        // Preenche cabeçalhos na primeira linha
        $coluna = 'A';
        foreach ($cabecalhos as $cabecalho) {
            $sheet->setCellValue("{$coluna}1", $cabecalho);
            $sheet->getStyle("{$coluna}1")->applyFromArray($headerStyle);
            $sheet->getColumnDimension($coluna)->setAutoSize(true);
            $coluna++;
        }

        // Preenche dados - cada jogador em linha com seu time
        $linha = 2;
        foreach ($campeonatos as $time) {
            foreach ($jogadores as $jogador) {
                if ($jogador['id_campeonato'] == $time['id_campeonato']) {
                    $sheet->fromArray([
                        $time['id_campeonato'],
                        $time['nome_time'],
                        $time['status_time'],
                        $time['email_campeonato'],
                        $time['data_cadastro_time'],
                        $jogador['id_jogador'],
                        $jogador['nome_completo_jogador'],
                        $jogador['rg_jogador'],
                        !empty($jogador['data_nascimento_jogador']) ? date('d/m/Y', strtotime($jogador['data_nascimento_jogador'])) : '',
                        $jogador['posicao_voleibol_jogador'],
                        $jogador['telefone_jogador'],
                        $jogador['status_jogador']
                    ], null, "A{$linha}");
                    $linha++;
                }
            }
        }

        // Estilo geral das células preenchidas
        $sheet->getStyle("A2:L" . ($linha - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]
        ]);

        // Congela o cabeçalho
        $sheet->freezePane('A2');

        // Configura headers HTTP para download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="relatorio_campeonatos.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



    public function totalTimes()
    {
        $model = new CampeonatoEamistoso();
        $total = $model->contarTodosTimes();
        echo json_encode(['total' => $total]);
    }

    public function graficoPorStatusTime()
    {
        $model = new CampeonatoEamistoso();
        $dados = $model->agruparPorStatus();
        echo json_encode($dados);
    }

    public function graficoPorPosicaoJogador()
    {
        $model = new CampeonatoEamistoso();
        $dados = $model->agruparPosicoesJogadores();
        echo json_encode($dados);
    }

    public function graficoPorQtdJogadoresTime()
    {
        $model = new CampeonatoEamistoso();
        $dados = $model->quantidadeJogadoresPorTime();
        echo json_encode($dados);
    }


    public function graficoMediaIdadeJogadores()
    {
        $dados = $this->campeonatoEamistosoModel->calcularMediaIdadePorTime();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }


    public function graficoPorIdade()
    {
        $dados = $this->campeonatoEamistosoModel->agruparPorIdadeJogadores();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados);
    }

    public function adicionarJogador()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCampeonato = $_POST['id_campeonato'];
            $nome = $_POST['nome_completo'];
            $rg = $_POST['rg'];
            $nascimento = $this->formatarData($_POST['data_nascimento']);
            $telefone = $_POST['telefone'];
            $posicao = $_POST['posicao'];

            $campeonatoEamistosoModel = new CampeonatoEamistoso();
            $campeonatoEamistosoModel->adicionarJogador([
                'id_campeonato' => $idCampeonato,
                'nome_completo_jogador' => $nome,
                'rg_jogador' => $rg,
                'data_nascimento_jogador' => $nascimento,
                'telefone_jogador' => $telefone,
                'posicao_voleibol_jogador' => $posicao,
                'status_jogador' => 'Ativo'
            ]);

            // var_dump( $idCampeonato,  $nome,  $rg , $nascimento ,  $telefone , $posicao  );
            // exit;

            $_SESSION['sucesso'] = "Jogador adicionado com sucesso!";
            header("Location: " . BASE_URL . "campeonatoEamistoso/campeonatoListar");
            exit;
        }
    }



    public function graficoStatusTotalJogadores()
    {
        $dados = $this->campeonatoEamistosoModel->contarJogadoresPorStatus();
        echo json_encode($dados);
    }

    public function graficoStatusJogadoresPorTime()
    {
        $dadosBrutos = $this->campeonatoEamistosoModel->contarJogadoresPorStatusPorTime();

        $dados = [];
        foreach ($dadosBrutos as $row) {
            $dados[$row['time']][$row['status']] = (int) $row['quantidade'];
        }

        $response = [];
        foreach ($dados as $time => $status) {
            $response[] = [
                'label' => $time,
                'Ativo' => $status['Ativo'] ?? 0,
                'Inativo' => $status['Inativo'] ?? 0
            ];
        }

        echo json_encode($response);
    }
}
