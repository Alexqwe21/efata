<?php

class ListaDePresencaController extends Controller
{
   public function ListarPresenca()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
        header('Location: ' . BASE_URL);
        exit;
    }

    $filtro = $_GET['filtro'] ?? ''; // recebe filtro de nome, se houver
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

            // Mensagem de sucesso
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
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

    // 🔹 Captura as datas enviadas pelo formulário (se existirem)
    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;

    $presencaModel = new ListaDePresenca();

    // 🔹 Chama o model passando as datas
    $historico = $presencaModel->listarHistorico($inicio, $fim);

    $dados = [
        'historico' => $historico,
        'inicio' => $inicio,
        'fim' => $fim,
        'conteudo' => 'dash/listadepresenca/historico'
    ];

    $this->carregarViews('dash/dashboard', $dados);
}

}
