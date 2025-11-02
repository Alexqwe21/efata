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

            $presencaModel = new ListaDePresenca();
            $presencaModel->salvarPresencas($dataAula, $presencas);

            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['sucesso'] = "Aula salva com sucesso!";
        }

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

    // Monta o HTML do PDF
    $html = '
        <h2 style="text-align:center;">Relatório de Presenças</h2>
        <p style="text-align:center;">
            Período: ' . date('d/m/Y', strtotime($inicio)) . ' até ' . date('d/m/Y', strtotime($fim)) . '
        </p>
        <table border="1" cellspacing="0" cellpadding="6" width="100%">
            <thead>
                <tr style="background:#f0f0f0;">
                    <th>Data da Aula</th>
                    <th>Aluno</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($historico as $linha) {
        $html .= '
            <tr>
                <td>' . date('d/m/Y', strtotime($linha['data_aula'])) . '</td>
                <td>' . htmlspecialchars($linha['nome_aluno']) . '</td>
                <td>' . ($linha['status'] == 1 ? 'Presente' : 'Faltou') . '</td>
            </tr>
        ';
    }

    $html .= '
            </tbody>
        </table>
        <br><p style="text-align:right;">Gerado em ' . date('d/m/Y H:i') . '</p>
    ';

    // Gera o PDF
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
    $sheet->setCellValue('A1', 'Data da Aula')
          ->setCellValue('B1', 'Aluno')
          ->setCellValue('C1', 'Status');

    // Conteúdo
    $row = 2;
    foreach ($historico as $linha) {
        $sheet->setCellValue('A'.$row, date('d/m/Y', strtotime($linha['data_aula'])));
        $sheet->setCellValue('B'.$row, $linha['nome_aluno']);
        $sheet->setCellValue('C'.$row, $linha['status'] == 1 ? 'Presente' : 'Faltou');
        $row++;
    }

    // Formatação simples
    foreach (range('A','C') as $col) {
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
