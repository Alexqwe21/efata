<?php

class LoginController extends Controller
{


    private $loginModel;

    public function __construct()
    {


        $this->loginModel = new Funcionario;
    }



    public function index()
    {

        session_start();

        $dados = array();

        if (isset($_SESSION['login-erro'])) {
            $dados['erro'] = $_SESSION['login-erro'];
            unset($_SESSION['login-erro']); // limpa após exibir
        }
        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';


        $this->carregarViews('login', $dados);
    }


    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);




            if (!$email || !$senha) {
                $_SESSION['login-erro'] = 'Preencha todos os campos corretamente.';
                header('Location: ' . BASE_URL . 'login');
                exit;
            }

            // Buscar funcionário no banco
            $funcionarioModel = new Funcionario();
            $usuario = $funcionarioModel->buscarFunc($email);

            if ($usuario && $senha === $usuario['senha_funcionario']) {
                $_SESSION['userEmail'] = $email;
                $_SESSION['userTipo'] = 'Funcionario';
                $_SESSION['userId'] = $usuario['id_funcionario']; // <-- PADRONIZADO

               
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            } else {
                $_SESSION['login-erro'] = 'E-mail ou senha inválidos.';
                header('Location: ' . BASE_URL . 'login');
                exit;
            }
        }
    }




   public function sair()
{
    session_start();
    session_unset();
    session_destroy();

    // Remove cookie da sessão (opcional, reforço de segurança)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    header('Location: ' . BASE_URL);
    exit;
}

}
