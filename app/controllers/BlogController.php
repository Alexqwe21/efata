<?php
// app/controllers/BlogController.php
// Parte PÚBLICA do blog:
//   /blog                      -> lista de posts (paginada: /blog?pagina=2)
//   /blog/ver/{slug}           -> um post
//   /blog/categoria/{slug}     -> posts de uma categoria
//   /blog/comentar             -> (POST, AJAX) recebe um comentário (sem login, com moderação)

class BlogController extends Controller
{
    private $postModel;
    private $categoriaModel;
    private $comentarioModel;
    private $imagemModel;
    private $porPagina = 9;

    // Regras dos comentários
    private $comentMinSegundos = 3;     // enviar antes disso = robô
    private $comentMaxSegundos = 7200;  // formulário aberto há mais de 2h: pede para atualizar
    private $comentLimite      = 3;     // no máximo X comentários...
    private $comentJanelaMin   = 10;    // ...a cada Y minutos por IP

    public function __construct()
    {
        $this->postModel      = new BlogPost();
        $this->categoriaModel = new BlogCategoria();
        $this->comentarioModel = new BlogComentario();
        $this->imagemModel     = new BlogImagem();
    }

    public function index()
    {
        $this->montarListagem(null, 'Blog');
    }

    public function categoria($slug = '')
    {
        $categoria = $this->categoriaModel->buscarPorSlug($slug);

        if (!$categoria) {
            $this->naoEncontrado();
            return;
        }

        $this->montarListagem($categoria, $categoria['nome_categoria_blog']);
    }

    public function ver($slug = '')
    {
        $post = $this->postModel->buscarPublicadoPorSlug($slug);

        if (!$post) {
            $this->naoEncontrado();
            return;
        }

        $this->carregarViews('blog/blog', [
            'modo'         => 'post',
            'tituloPagina' => $post['titulo_post'],
            'post'         => $post,
            'categorias'   => $this->categoriaModel->listarComPosts(),
            'galeria'      => $this->imagemModel->listarPorPost($post['id_post']),
            'comentarios'  => $this->comentarioModel->listarAprovados($post['id_post']),
            'comentToken'  => $this->gerarTokenComentario($post['id_post']),
        ]);
    }

    // =======================
    // COMENTÁRIOS (sem login)
    // =======================

    public function comentar()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responderJson('erro', 'Requisição inválida.', 405);
        }

        $idPost = (int) ($_POST['id_post'] ?? 0);
        $post   = $this->postModel->buscarPorId($idPost);

        // Só aceita comentário em post que está publicado
        $publicado = $post
            && $post['status_post'] === 'publicado'
            && !empty($post['data_publicacao_post'])
            && strtotime($post['data_publicacao_post']) <= time();

        if (!$publicado) {
            $this->responderJson('erro', 'Post não encontrado.', 404);
        }

        // Campo-isca: humanos não veem nem preenchem. Se veio preenchido, é robô.
        // Responde "sucesso" para o robô não saber que foi descartado.
        if (!empty($_POST['site_url'])) {
            $this->responderJson('sucesso', 'Recebemos seu comentário! Ele aparece aqui depois de aprovado.');
        }

        // Token de tempo: prova que o formulário foi carregado e ficou aberto alguns segundos
        $idade = $this->idadeTokenComentario($_POST['tk'] ?? '', $idPost);

        if ($idade === null || $idade > $this->comentMaxSegundos) {
            $this->responderJson('erro', 'A página ficou aberta por muito tempo. Atualize e envie novamente.', 400);
        }

        if ($idade < $this->comentMinSegundos) {
            $this->responderJson('erro', 'Calma! Espere alguns segundos e envie novamente.', 429);
        }

        // Validação dos campos
        $nome  = trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($_POST['nome'] ?? ''))));
        $email = trim((string) ($_POST['email'] ?? ''));
        $texto = trim(str_replace("\r\n", "\n", strip_tags((string) ($_POST['texto'] ?? ''))));
        $texto = preg_replace("/\n{3,}/", "\n\n", $texto);

        if (mb_strlen($nome) < 2 || mb_strlen($nome) > 80) {
            $this->responderJson('erro', 'Informe seu nome (de 2 a 80 letras).', 422);
        }

        if ($email !== '' && (mb_strlen($email) > 120 || !filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $this->responderJson('erro', 'O e-mail informado não é válido. Você pode deixá-lo em branco.', 422);
        }

        if (mb_strlen($texto) < 3 || mb_strlen($texto) > 1000) {
            $this->responderJson('erro', 'O comentário precisa ter de 3 a 1000 caracteres.', 422);
        }

        // Limite por IP e repetição
        $ipHash = $this->ipHash();

        if ($this->comentarioModel->contarRecentesPorIp($ipHash, $this->comentJanelaMin) >= $this->comentLimite) {
            $this->responderJson('erro', 'Você enviou comentários demais em pouco tempo. Tente de novo daqui a alguns minutos.', 429);
        }

        if ($this->comentarioModel->existeIgual($idPost, $ipHash, $texto)) {
            $this->responderJson('sucesso', 'Recebemos seu comentário! Ele aparece aqui depois de aprovado.');
        }

        // Mais de um link no texto (ou no nome) = quase sempre spam: vai direto para a aba Spam
        $links  = preg_match_all('~https?://|www\.~i', $texto . ' ' . $nome);
        $status = $links > 1 ? 'spam' : 'pendente';

        $this->comentarioModel->criar([
            'id_post' => $idPost,
            'nome'    => $nome,
            'email'   => $email,
            'texto'   => $texto,
            'status'  => $status,
            'ip_hash' => $ipHash,
        ]);

        if ($status === 'pendente') {
            $this->avisarPorEmail($post, $nome, $texto);
        }

        $this->responderJson('sucesso', 'Recebemos seu comentário! Ele aparece aqui depois de aprovado.');
    }

    private function responderJson($status, $mensagem, $codigo = 200)
    {
        http_response_code($codigo);
        echo json_encode(['status' => $status, 'mensagem' => $mensagem], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Token = "hora.assinatura". Não precisa de sessão e não pode ser inventado sem conhecer a chave.
    private function gerarTokenComentario($idPost)
    {
        $hora = time();
        return $hora . '.' . hash_hmac('sha256', (int) $idPost . '|' . $hora, DB_PASS . '|blog-comentario');
    }

    // Devolve há quantos segundos o token foi gerado (ou null se for inválido)
    private function idadeTokenComentario($token, $idPost)
    {
        $partes = explode('.', (string) $token);

        if (count($partes) !== 2 || !ctype_digit($partes[0])) {
            return null;
        }

        $esperado = hash_hmac('sha256', (int) $idPost . '|' . $partes[0], DB_PASS . '|blog-comentario');

        if (!hash_equals($esperado, $partes[1])) {
            return null;
        }

        return time() - (int) $partes[0];
    }

    // Guarda só o hash do IP (não dá para voltar ao IP, mas serve para limitar abusos)
    private function ipHash()
    {
        $ip = function_exists('getClientIP') ? getClientIP() : ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
        return hash('sha256', $ip . '|' . DB_NAME);
    }

    // Avisa a equipe por e-mail (mesmo SMTP da newsletter). Se falhar, o comentário já está salvo.
    private function avisarPorEmail($post, $nome, $texto)
    {
        try {
            require_once('vendors/phpmailer/PHPMailer.php');
            require_once('vendors/phpmailer/SMTP.php');
            require_once('vendors/phpmailer/Exception.php');

            $h = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug  = 0;
            $mail->Host       = HOTS_EMAIL;
            $mail->Port       = PORT_EMAIL;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth   = true;
            $mail->Username   = USER_EMAIL;
            $mail->Password   = PASS_EMAIL;
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPOptions = ['ssl' => [
                'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true,
            ]];

            $mail->setFrom(USER_EMAIL, 'Blog Cultura Efatá');
            $mail->addAddress(USER_EMAIL, 'ONG Cultura Efatá');
            $mail->Subject = 'Novo comentário aguardando aprovação';
            $mail->msgHTML(
                '<p><strong>' . $h($nome) . '</strong> comentou em <strong>' . $h($post['titulo_post']) . '</strong>:</p>'
                . '<blockquote>' . nl2br($h($texto)) . '</blockquote>'
                . '<p><a href="' . $h(BASE_URL . 'blogcomentarios') . '">Abrir a moderação</a></p>'
            );
            $mail->AltBody = $nome . ' comentou em "' . $post['titulo_post'] . '": ' . $texto;
            $mail->send();
        } catch (\Throwable $e) {
            // sem ação: o aviso é só uma comodidade
        }
    }

    // -----------------------

    private function montarListagem($categoria, $titulo)
    {
        $idCategoria = $categoria ? (int) $categoria['id_categoria_blog'] : null;

        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $total        = $this->postModel->contarPublicados($idCategoria);
        $totalPaginas = max(1, (int) ceil($total / $this->porPagina));

        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }

        $posts = $this->postModel->listarPublicados(
            $this->porPagina,
            ($pagina - 1) * $this->porPagina,
            $idCategoria
        );

        $this->carregarViews('blog/blog', [
            'modo'           => 'lista',
            'tituloPagina'   => $titulo,
            'categoriaAtual' => $categoria,
            'posts'          => $posts,
            'categorias'     => $this->categoriaModel->listarComPosts(),
            'pagina'         => $pagina,
            'totalPaginas'   => $totalPaginas,
        ]);
    }

    private function naoEncontrado()
    {
        header('HTTP/1.1 404 Not Found');
        $erro = new ErroController();
        $erro->index();
    }
}