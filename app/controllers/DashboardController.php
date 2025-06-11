<?php

class DashboardController extends Controller
{

 public function index()
{
    // Inicia a sessão se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    
   

    // Verifica se o funcionário está logado
    if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
        header('Location: ' . BASE_URL);
        exit();
    }

   
    // Instancia o modelo de Funcionário
    $funcionarioModel = new Funcionario();

    // Busca os dados pelo ID do funcionário
    $funcionario = $funcionarioModel->buscarPorId($_SESSION['userId']);

    // Se não encontrar, força logout
    if (!$funcionario) {
        header('Location: ' . BASE_URL . 'login/sair');
        exit();
    }

    // Atualiza a sessão com os dados do funcionário
    $_SESSION['userNome']     = $funcionario['nome_funcionario'];
    $_SESSION['userFoto']     = $funcionario['foto_funcionario'];
    $_SESSION['userEndereco'] = $funcionario['endereco_funcionario'] ?? 'Endereço não disponível';

    // Dados para a view
    $dados = array(
        'titulo'        => 'Dashboard - Cultura Efatá',
        'nomeUser'      => $_SESSION['userNome'],
        'idUser'        => $_SESSION['userId'],
        'tipoUser'      => $_SESSION['userTipo'],
        'userEndereco'  => $_SESSION['userEndereco'],
        'fotoUser'      => !empty($_SESSION['userFoto'])
            ? BASE_URL . $_SESSION['userFoto']
            : BASE_URL . 'uploads/funcionario/default.svg'
    );

    // Carrega a view
    $this->carregarViews('dash/dashboard', $dados);
}

}
