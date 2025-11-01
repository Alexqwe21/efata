<?php

class ListaDePresencaController extends Controller
{
    public function ListarPresenca()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $presencaModel = new ListaDePresenca();
        $alunos = $presencaModel->listarAlunos();

        $dados = [
            'alunos' => $alunos
        ];

        // Caminho da view dentro do dashboard
        $dados['conteudo'] = 'dash/listadepresenca/listar';

// var_dump($dados);
// exit;        

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

}
