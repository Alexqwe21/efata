<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class ListaDePresencaController extends Controller
{
    private $ListaDePresencaModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->ListaDePresencaModel = new ListaDePresenca;
    }

    public function index()
    {
        // Verificação de login (segue teu padrão)
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $dados = array();
        $dados['mensagem'] = 'Bem-vindo';
        $dados['nome'] = 'Alex';
        $dados['conteudo'] = 'dash/listadepresenca/listar'; // caminho da view interna
var_dump("cheguei aqui");
exit;
        // Chama o layout principal do dashboard
        $this->carregarViews('dash/dashboard', $dados);
    }
}

