<?php
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ListaDePresencaController extends Controller
{
    public function ListarPresenca()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $filtro = $_GET['filtro'] ?? ''; // filtro por nome, se houver
        $presencaModel = new ListaDePresenca();
        $alunos = $presencaModel->listarAlunos($filtro);

        $dados = [
            'alunos' => $alunos,
            'filtro' => $filtro,
            'conteudo' => 'dash/listadepresenca/listar'
        ];

        $this->carregarViews('dash/dashboard', $dados);
    }

    public function salvarPresenca()
{
    if (!empty($_POST['data_aula']) && !empty($_POST['presenca'])) {

        $dataAula = $_POST['data_aula'];
        $presencas = $_POST['presenca'];

        // Chama o Model
        $presencaModel = new ListaDePresenca();
        $presencaModel->salvarPresencas($dataAula, $presencas);

        // Mensagem de sucesso
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['sucesso'] = "Aula salva com sucesso!";
    }

    // Redireciona para a listagem
    header("Location: " . BASE_URL . "ListaDePresenca/Listarpresenca");
    exit;
}


    public function HistoricoPresenca()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        // Captura as datas enviadas pelo formulário
        $inicio = $_GET['inicio'] ?? null;
        $fim = $_GET['fim'] ?? null;

        $presencaModel = new ListaDePresenca();
        $historico = $presencaModel->listarHistorico($inicio, $fim);

        $dados = [
            'historico' => $historico,
            'inicio' => $inicio,
            'fim' => $fim,
            'conteudo' => 'dash/listadepresenca/historico'
        ];

        $this->carregarViews('dash/dashboard', $dados);
    }

public function exportarPresencaPDF()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
        header('Location: ' . BASE_URL);
        exit;
    }

    require_once __DIR__ . '/../../vendor/autoload.php';

    // Captura o período selecionado
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;

    if (empty($inicio) || empty($fim)) {
        echo "Por favor, selecione Data Inicial e Data Final.";
        exit;
    }

    $presencaModel = new ListaDePresenca();
    $historico = $presencaModel->listarPorPeriodo($inicio, $fim);

    if (empty($historico)) {
        echo "Nenhum registro encontrado para o período selecionado.";
        exit;
    }

    // ----------- DADOS AUTOMÁTICOS DO LOCAL/DIA/HORÁRIO ---------------- //

    // Local é fixo
    $localTexto = "CEU SÃO MIGUEL - INSTITUTO BACARRELLI";

    // Pega a primeira data do período para identificar dia e horário
    $primeiraData = $historico[0]['data_aula'];
    $diaSemana = date('N', strtotime($primeiraData)); // 6 = sábado / 7 = domingo

    if ($diaSemana == 6) {
        $diaTexto = "SÁBADO";
        $horarioTexto = "18:00";
    } elseif ($diaSemana == 7) {
        $diaTexto = "DOMINGO";
        $horarioTexto = "16:00";
    } else {
        $diaTexto = "DIA INVÁLIDO";
        $horarioTexto = "-";
    }

    // Deixa tudo maiúsculo
    $localTexto    = strtoupper($localTexto);
    $diaTexto      = strtoupper($diaTexto);
    $horarioTexto  = strtoupper($horarioTexto);

    // ----------- MONTAGEM DO HTML DO PDF ---------------- //

    $html = '
        <h2 style="text-align:center;">RELATÓRIO DE PRESENÇAS</h2>

        <p><strong>LOCAL:</strong> ' . $localTexto . '</p>
        <p><strong>DIA:</strong> ' . $diaTexto . '</p>
        <p><strong>HORÁRIO:</strong> ' . $horarioTexto . '</p>

        <p style="text-align:center;">
            PERÍODO: ' . strtoupper(date('d/m/Y', strtotime($inicio)) . ' ATÉ ' . date('d/m/Y', strtotime($fim))) . '
        </p>

        <table border="1" cellspacing="0" cellpadding="6" width="100%">
            <thead>
                <tr style="background:#f0f0f0;">
                    <th>DATA DA AULA</th>
                    <th>ALUNO</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($historico as $linha) {

        $html .= '
            <tr>
                <td>' . date('d/m/Y', strtotime($linha['data_aula'])) . '</td>
                <td>' . strtoupper(htmlspecialchars($linha['nome_aluno'])) . '</td>
                <td>' . strtoupper(($linha['status'] == 1 ? "Presente" : "Faltou")) . '</td>
            </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>

        <br><p style="text-align:right;">GERADO EM ' . date('d/m/Y H:i') . '</p>
    ';

    // ----------- GERAÇÃO DO PDF ---------------- //

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $fileName = "presenca_" . date('Ymd_His') . ".pdf";
    $dompdf->stream($fileName, ["Attachment" => true]);
    exit;
}



public function exportarPresencaExcel()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
        header('Location: ' . BASE_URL);
        exit;
    }

    // Captura o período selecionado
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;

    if (empty($inicio) || empty($fim)) {
        echo "Por favor, selecione Data Inicial e Data Final.";
        exit;
    }

    $presencaModel = new ListaDePresenca();
    $historico = $presencaModel->listarPorPeriodo($inicio, $fim);

    if (empty($historico)) {
        echo "Nenhum registro encontrado para o período selecionado.";
        exit;
    }

    // Cria a planilha
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Relatório de Presenças');

    // Cabeçalho
    $sheet->setCellValue('A1', 'DATA DA AULA')
          ->setCellValue('B1', 'ALUNO')
          ->setCellValue('C1', 'STATUS')
          ->setCellValue('D1', 'LOCAL')
          ->setCellValue('E1', 'DIA')
          ->setCellValue('F1', 'HORÁRIO');

    // Conteúdo
    $row = 2;
    foreach ($historico as $linha) {

        // Nome do aluno em MAIÚSCULO
        $nomeAluno = strtoupper($linha['nome_aluno']);

        // Status em MAIÚSCULO
        $status = $linha['status'] == 1 ? 'PRESENTE' : 'FALTOU';

        // Local, dia e horário em MAIÚSCULO
        $local = strtoupper($linha['local'] ?? '');
        $dia   = strtoupper($linha['dia'] ?? '');
        $hora  = $linha['horario'] ? date('H:i', strtotime($linha['horario'])) : '';

        $sheet->setCellValue('A'.$row, date('d/m/Y', strtotime($linha['data_aula'])));
        $sheet->setCellValue('B'.$row, $nomeAluno);
        $sheet->setCellValue('C'.$row, $status);
        $sheet->setCellValue('D'.$row, $local);
        $sheet->setCellValue('E'.$row, $dia);
        $sheet->setCellValue('F'.$row, $hora);

        $row++;
    }

    // Ajuste automático de colunas
    foreach (range('A','F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Define cabeçalho HTTP para download
    $fileName = "presenca_" . date('Ymd_His') . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}




}
