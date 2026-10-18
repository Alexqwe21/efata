<?php
// app/controllers/BlogcomentariosController.php
// Moderação dos comentários do blog (exige login de funcionário):
//   /blogcomentarios                    -> lista (?status=pendente|aprovado|spam&pagina=2)
//   /blogcomentarios/aprovar/{id}       -> (POST)
//   /blogcomentarios/spam/{id}          -> (POST)
//   /blogcomentarios/pendente/{id}      -> (POST) volta para pendente
//   /blogcomentarios/excluir/{id}       -> (POST)

class BlogcomentariosController extends Controller
{
    private $comentarioModel;
    private $porPagina = 20;
    private $statusValidos = ['pendente', 'aprovado', 'spam'];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userId']) || ($_SESSION['userTipo'] ?? '') !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->comentarioModel = new BlogComentario();
    }

    public function index()
    {
        $status = $_GET['status'] ?? 'pendente';
        if (!in_array($status, $this->statusValidos, true)) {
            $status = 'pendente';
        }

        $totais       = $this->comentarioModel->totaisPorStatus();
        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $totalPaginas = max(1, (int) ceil($totais[$status] / $this->porPagina));

        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }

        $dados = [
            'tituloPagina' => 'Comentários do blog',
            'status'       => $status,
            'totais'       => $totais,
            'comentarios'  => $this->comentarioModel->listarPorStatus($status, $this->porPagina, ($pagina - 1) * $this->porPagina),
            'pagina'       => $pagina,
            'totalPaginas' => $totalPaginas,
            'flash'        => $this->pegarFlash(),
            'csrf'         => $this->csrfToken(),
            'conteudo'     => 'dash/blog/comentarios',
        ];

        $this->carregarViews('dash/dashboard', $dados);
    }

    public function aprovar($id = 0)
    {
        $this->mudar($id, 'aprovado', 'Comentário aprovado. Ele já aparece no post.');
    }

    public function spam($id = 0)
    {
        $this->mudar($id, 'spam', 'Comentário movido para Spam.');
    }

    public function pendente($id = 0)
    {
        $this->mudar($id, 'pendente', 'Comentário voltou para Pendentes.');
    }

    public function excluir($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $this->comentarioModel->excluir((int) $id);
        $this->flash('Comentário excluído.');
        $this->voltar();
    }

    // -----------------------

    private function mudar($id, $status, $mensagem)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $this->comentarioModel->mudarStatus((int) $id, $status);
        $this->flash($mensagem);
        $this->voltar();
    }

    // Volta para a mesma aba/página em que a pessoa estava
    private function voltar()
    {
        $status = $_POST['status'] ?? 'pendente';
        if (!in_array($status, $this->statusValidos, true)) {
            $status = 'pendente';
        }

        $pagina = max(1, (int) ($_POST['pagina'] ?? 1));

        header('Location: ' . BASE_URL . 'blogcomentarios?status=' . $status . ($pagina > 1 ? '&pagina=' . $pagina : ''));
        exit;
    }

    private function flash($msg, $tipo = 'sucesso')
    {
        $_SESSION['blogcoment_flash'] = ['tipo' => $tipo, 'msg' => $msg];
    }

    private function pegarFlash()
    {
        $f = $_SESSION['blogcoment_flash'] ?? null;
        unset($_SESSION['blogcoment_flash']);
        return $f;
    }

    private function csrfToken()
    {
        if (empty($_SESSION['blog_csrf'])) {
            $_SESSION['blog_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['blog_csrf'];
    }

    private function verificarCsrf()
    {
        $token = $_POST['csrf'] ?? '';

        if (empty($_SESSION['blog_csrf']) || !hash_equals($_SESSION['blog_csrf'], $token)) {
            http_response_code(403);
            exit('Requisição inválida. Volte e tente novamente.');
        }
    }

    private function exigirPost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'blogcomentarios');
            exit;
        }
    }
}
