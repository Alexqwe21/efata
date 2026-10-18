<?php
// app/controllers/BlogadminController.php
// Painel do blog (exige login). Tudo acontece em /blogadmin, usando modais:
//   /blogadmin                       -> lista de posts (modais: novo post, editar post, categorias)
//   /blogadmin/salvar                -> (POST) grava novo post
//   /blogadmin/atualizar/{id}        -> (POST) grava edição
//   /blogadmin/excluir/{id}          -> (POST) exclui
//   /blogadmin/salvarCategoria       -> (POST)
//   /blogadmin/excluirCategoria/{id} -> (POST)
//   /blogadmin/uploadImagem          -> (POST, AJAX) envia uma imagem para colocar dentro do texto do post

class BlogadminController extends Controller
{
    private $postModel;
    private $categoriaModel;
    private $imagemModel;
    private $porPagina = 15;
    private $limiteGaleria = 20;   // fotos por post

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Mesma checagem de login das outras telas do painel
        if (!isset($_SESSION['userId']) || ($_SESSION['userTipo'] ?? '') !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->postModel      = new BlogPost();
        $this->categoriaModel = new BlogCategoria();
        $this->imagemModel    = new BlogImagem();
    }

    // =======================
    // LISTA (com os modais)
    // =======================

    public function index()
    {
        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $total        = $this->postModel->contarTodos();
        $totalPaginas = max(1, (int) ceil($total / $this->porPagina));

        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }

        $posts    = $this->postModel->listarTodos($this->porPagina, ($pagina - 1) * $this->porPagina);
        $postNovo = $this->postVazio();

        // Se o último envio deu erro, devolve o que a pessoa digitou e reabre o modal
        $old   = $_SESSION['blog_old'] ?? null;
        $abrir = $_SESSION['blog_abrir'] ?? null;
        unset($_SESSION['blog_old'], $_SESSION['blog_abrir']);

        if ($old) {
            if ((int) $old['id'] === 0) {
                $postNovo = array_merge($postNovo, $old['dados']);
            } else {
                foreach ($posts as $i => $p) {
                    if ((int) $p['id_post'] === (int) $old['id']) {
                        $posts[$i] = array_merge($p, $old['dados']);
                    }
                }
            }
        }

        $this->renderizar('dash/blog/index', [
            'tituloPagina' => 'Posts do blog',
            'posts'        => $posts,
            'postNovo'     => $postNovo,
            'categorias'   => $this->categoriaModel->listar(),
            'imagens'      => $this->imagemModel->listarPorPosts(array_column($posts, 'id_post')),
            'limiteGaleria' => $this->limiteGaleria,
            'pagina'       => $pagina,
            'totalPaginas' => $totalPaginas,
            'abrir'        => $abrir,
            'flash'        => $this->pegarFlash(),
            'csrf'         => $this->csrfToken(),
        ]);
    }

    // =======================
    // POSTS (ações dos modais)
    // =======================

    public function salvar()
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $pagina = $_POST['pagina'] ?? 1;

        list($dados, $erros) = $this->validar($_POST);

        $foto = null;
        if (!$erros) {
            $up = $this->processarUpload();
            if ($up['erro']) {
                $erros[] = $up['erro'];
            } else {
                $foto = $up['arquivo'];
            }
        }

        if ($erros) {
            $this->devolverComErros(0, $dados, $erros, $pagina);
        }

        $dados['id_funcionario'] = (int) $_SESSION['userId'];
        $dados['slug_post']      = $this->postModel->gerarSlug($dados['titulo_post']);
        $dados['foto_post']      = $foto;

        $idNovo = $this->postModel->criar($dados);

        $avisos = $this->tratarGaleria($idNovo);

        if ($avisos) {
            $this->flash('Post criado, mas: ' . implode(' ', $avisos), 'erro');
        } else {
            $this->flash('Post criado com sucesso.');
        }

        $this->irParaLista($pagina);
    }

    public function atualizar($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $pagina    = $_POST['pagina'] ?? 1;
        $existente = $this->postModel->buscarPorId((int) $id);

        if (!$existente) {
            $this->flash('Post não encontrado.', 'erro');
            $this->irParaLista($pagina);
        }

        list($dados, $erros) = $this->validar($_POST);

        $foto = $existente['foto_post'];

        if (!$erros) {
            $up = $this->processarUpload();

            if ($up['erro']) {
                $erros[] = $up['erro'];
            } elseif ($up['arquivo']) {
                $this->apagarFoto($existente['foto_post']);
                $foto = $up['arquivo'];
            } elseif (!empty($_POST['remover_foto'])) {
                $this->apagarFoto($existente['foto_post']);
                $foto = null;
            }
        }

        if ($erros) {
            $this->devolverComErros((int) $existente['id_post'], $dados, $erros, $pagina);
        }

        $dados['foto_post'] = $foto;
        $this->postModel->atualizar($existente['id_post'], $dados);

        $avisos = $this->tratarGaleria((int) $existente['id_post']);

        if ($avisos) {
            $this->flash('Post atualizado, mas: ' . implode(' ', $avisos), 'erro');
        } else {
            $this->flash('Post atualizado com sucesso.');
        }

        $this->irParaLista($pagina);
    }

    public function excluir($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $post = $this->postModel->buscarPorId((int) $id);

        if ($post) {
            // guarda a lista de arquivos antes de apagar o post (as linhas da galeria somem junto, em cascata)
            $galeria = $this->imagemModel->listarPorPost($post['id_post']);

            $this->postModel->excluir($post['id_post']);
            $this->apagarFoto($post['foto_post']);

            foreach ($galeria as $img) {
                BlogMidia::apagar($img['arquivo_imagem']);
            }

            BlogMidia::apagarImagensDoConteudo($post['conteudo_post']);

            $this->flash('Post excluído.');
        } else {
            $this->flash('Post não encontrado.', 'erro');
        }

        $this->irParaLista($_POST['pagina'] ?? 1);
    }

    // =======================
    // IMAGEM DENTRO DO TEXTO (chamada pelo botão de foto do editor)
    // =======================

    public function uploadImagem()
    {
        header('Content-Type: application/json; charset=utf-8');

        $resposta = function ($ok, $dados, $codigo = 200) {
            http_response_code($codigo);
            echo json_encode(array_merge(['ok' => $ok], $dados), JSON_UNESCAPED_UNICODE);
            exit;
        };

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $resposta(false, ['erro' => 'Requisição inválida.'], 405);
        }

        $token = $_POST['csrf'] ?? '';
        if (empty($_SESSION['blog_csrf']) || !hash_equals($_SESSION['blog_csrf'], $token)) {
            $resposta(false, ['erro' => 'Sessão expirada. Atualize a página e tente de novo.'], 403);
        }

        if (empty($_FILES['imagem'])) {
            $resposta(false, ['erro' => 'Nenhuma imagem enviada.'], 400);
        }

        $r = BlogMidia::salvarImagem($_FILES['imagem'], 'uploads/blog/conteudo/', 'c_', false);

        if ($r['erro']) {
            $resposta(false, ['erro' => $r['erro']], 422);
        }

        $resposta(true, ['url' => '/' . $r['arquivo']]);
    }

    // =======================
    // CATEGORIAS (ações do modal)
    // =======================

    public function salvarCategoria()
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $nome = trim($_POST['nome_categoria_blog'] ?? '');

        if ($nome === '' || mb_strlen($nome) > 100) {
            $this->flash('Informe o nome da categoria (até 100 caracteres).', 'erro');
        } else {
            $this->categoriaModel->criar($nome);
            $this->flash('Categoria criada.');
        }

        $_SESSION['blog_abrir'] = 'modalCategorias';
        $this->irParaLista($_POST['pagina'] ?? 1);
    }

    public function excluirCategoria($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $this->categoriaModel->excluir((int) $id);
        $this->flash('Categoria excluída. Os posts dela ficaram sem categoria.');

        $_SESSION['blog_abrir'] = 'modalCategorias';
        $this->irParaLista($_POST['pagina'] ?? 1);
    }

    // =======================
    // AUXILIARES (privados)
    // =======================

    // Carrega o layout do painel (dash/dashboard) com a view do blog dentro dele,
    // do mesmo jeito que o CampeonatoEamistosoController faz
    private function renderizar($conteudo, $dados)
    {
        $dados['conteudo'] = $conteudo;
        $this->carregarViews('dash/dashboard', $dados);
    }

    private function postVazio()
    {
        return [
            'id_post'              => 0,
            'id_categoria_blog'    => null,
            'titulo_post'          => '',
            'slug_post'            => '',
            'resumo_post'          => '',
            'conteudo_post'        => '',
            'foto_post'            => null,
            'alt_foto_post'        => '',
            'video_post'           => '',
            'status_post'          => 'rascunho',
            'data_publicacao_post' => null,
        ];
    }

    // Em caso de erro, guarda o que foi digitado, avisa e volta para a lista
    // (a tela reabre o mesmo modal com os textos preenchidos)
    private function devolverComErros($idPost, $dados, $erros, $pagina)
    {
        $_SESSION['blog_old']   = ['id' => (int) $idPost, 'dados' => $dados];
        $_SESSION['blog_abrir'] = $idPost ? 'modalEditarPost' . (int) $idPost : 'modalNovoPost';

        $this->flash(implode(' ', $erros), 'erro');
        $this->irParaLista($pagina);
    }

    // Valida os campos do formulário. Retorna [dados, erros]
    private function validar($in)
    {
        $erros = [];

        $titulo   = trim($in['titulo_post'] ?? '');
        $resumo   = trim($in['resumo_post'] ?? '');
        $conteudo = trim($in['conteudo_post'] ?? '');
        $alt      = trim($in['alt_foto_post'] ?? '');
        $video    = trim($in['video_post'] ?? '');
        $status   = $in['status_post'] ?? 'rascunho';

        if ($titulo === '') {
            $erros[] = 'Informe o título.';
        } elseif (mb_strlen($titulo) > 200) {
            $erros[] = 'O título pode ter no máximo 200 caracteres.';
        }

        if (mb_strlen($resumo) > 300) {
            $erros[] = 'O resumo pode ter no máximo 300 caracteres.';
        }

        if ($conteudo === '') {
            $erros[] = 'Escreva o conteúdo do post.';
        }

        if (mb_strlen($alt) > 255) {
            $erros[] = 'O texto alternativo da imagem pode ter no máximo 255 caracteres.';
        }

        // Vídeo (opcional): só links do YouTube ou do Vimeo. Grava o link já limpo.
        $videoLimpo = null;
        if ($video !== '') {
            $info = BlogMidia::videoEmbed($video);

            if ($info) {
                $videoLimpo = $info['url'];
            } else {
                $erros[] = 'O link do vídeo não é válido. Use um link do YouTube ou do Vimeo.';
            }
        }

        if (!in_array($status, ['rascunho', 'publicado'], true)) {
            $status = 'rascunho';
        }

        // Categoria (opcional): precisa existir
        $idCategoria = (int) ($in['id_categoria_blog'] ?? 0);
        if ($idCategoria > 0 && !$this->categoriaModel->buscarPorId($idCategoria)) {
            $idCategoria = 0;
        }

        // Data de publicação: só vale para posts publicados
        $dataPub = null;
        if ($status === 'publicado') {
            $bruto = trim($in['data_publicacao_post'] ?? '');

            if ($bruto === '') {
                $dataPub = date('Y-m-d H:i:s');
            } else {
                $dt = DateTime::createFromFormat('Y-m-d\TH:i', $bruto);
                if (!$dt) {
                    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $bruto);
                }
                if ($dt) {
                    $dataPub = $dt->format('Y-m-d H:i:s');
                } else {
                    $erros[] = 'Data de publicação inválida.';
                }
            }
        }

        $dados = [
            'id_categoria_blog'    => $idCategoria > 0 ? $idCategoria : null,
            'titulo_post'          => $titulo,
            'resumo_post'          => $resumo !== '' ? $resumo : null,
            'conteudo_post'        => $conteudo,
            'alt_foto_post'        => $alt !== '' ? $alt : null,
            'video_post'           => $videoLimpo,
            'status_post'          => $status,
            'data_publicacao_post' => $dataPub,
        ];

        return [$dados, $erros];
    }

    // Recebe a capa (campo "foto_post"). Retorna ['erro' => ..., 'arquivo' => ...]
    private function processarUpload()
    {
        if (empty($_FILES['foto_post']) || $_FILES['foto_post']['error'] === UPLOAD_ERR_NO_FILE) {
            return ['erro' => null, 'arquivo' => null];
        }

        $f = $_FILES['foto_post'];

        if ($f['error'] !== UPLOAD_ERR_OK) {
            return ['erro' => 'Não foi possível enviar a imagem. Tente novamente.', 'arquivo' => null];
        }

        if ($f['size'] > 3 * 1024 * 1024) {
            return ['erro' => 'A imagem deve ter no máximo 3 MB.', 'arquivo' => null];
        }

        $permitidos = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);

        if (!isset($permitidos[$mime]) || !@getimagesize($f['tmp_name'])) {
            return ['erro' => 'Envie uma imagem JPG, PNG, WEBP ou GIF.', 'arquivo' => null];
        }

        $dir = 'uploads/blog/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $nome = 'post_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $permitidos[$mime];

        if (!move_uploaded_file($f['tmp_name'], $dir . $nome)) {
            return ['erro' => 'Não foi possível salvar a imagem no servidor.', 'arquivo' => null];
        }

        return ['erro' => null, 'arquivo' => $dir . $nome];
    }

    // Só apaga arquivos dentro de uploads/blog/
    private function apagarFoto($caminho)
    {
        if (!$caminho || strpos($caminho, 'uploads/blog/') !== 0 || strpos($caminho, '..') !== false) {
            return;
        }

        if (is_file($caminho)) {
            @unlink($caminho);
        }
    }

    // Galeria do post: remove as marcadas, grava legenda/ordem das existentes e envia as novas.
    // Retorna uma lista de avisos (vazia se deu tudo certo).
    private function tratarGaleria($idPost)
    {
        $avisos = [];

        // 1) remover
        $remover = array_map('intval', (array) ($_POST['remover_img'] ?? []));

        foreach ($this->imagemModel->excluirPorIds($idPost, $remover) as $linha) {
            BlogMidia::apagar($linha['arquivo_imagem']);
        }

        // 2) legenda e ordem das que já existem
        $ordens = (array) ($_POST['ordem_img'] ?? []);

        foreach ((array) ($_POST['legenda_img'] ?? []) as $idImg => $legenda) {
            $idImg = (int) $idImg;

            if ($idImg <= 0 || in_array($idImg, $remover, true)) {
                continue;
            }

            $legenda = mb_substr(trim(strip_tags((string) $legenda)), 0, 160);
            $ordem   = (int) ($ordens[$idImg] ?? 0);

            $this->imagemModel->atualizarLegendaOrdem($idImg, $idPost, $legenda, $ordem);
        }

        // 3) novas fotos (campo galeria[])
        $arquivos = $this->arquivosDoCampo('galeria');
        $vagas    = $this->limiteGaleria - $this->imagemModel->contarPorPost($idPost);
        $ordem    = $this->imagemModel->proximaOrdem($idPost);

        foreach ($arquivos as $arq) {
            if ($vagas <= 0) {
                $avisos[] = 'a galeria aceita no máximo ' . $this->limiteGaleria . ' fotos; as demais não foram enviadas.';
                break;
            }

            $r = BlogMidia::salvarImagem($arq, 'uploads/blog/galeria/', 'g_', true);

            if ($r['erro']) {
                $avisos[] = $r['erro'];
                continue;
            }

            $this->imagemModel->criar($idPost, $r['arquivo'], '', $ordem++);
            $vagas--;
        }

        return $avisos;
    }

    // Transforma $_FILES['campo'] (vários arquivos) em uma lista de arquivos simples
    private function arquivosDoCampo($campo)
    {
        if (empty($_FILES[$campo]) || !is_array($_FILES[$campo]['name'])) {
            return [];
        }

        $f = $_FILES[$campo];
        $lista = [];

        foreach ($f['name'] as $i => $nome) {
            if ($f['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $lista[] = [
                'name'     => $nome,
                'type'     => $f['type'][$i],
                'tmp_name' => $f['tmp_name'][$i],
                'error'    => $f['error'][$i],
                'size'     => $f['size'][$i],
            ];
        }

        return $lista;
    }

    // ---- sessão: mensagens e CSRF ----

    private function flash($msg, $tipo = 'sucesso')
    {
        $_SESSION['blog_flash'] = ['tipo' => $tipo, 'msg' => $msg];
    }

    private function pegarFlash()
    {
        $f = $_SESSION['blog_flash'] ?? null;
        unset($_SESSION['blog_flash']);
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
            $this->irParaLista(1);
        }
    }

    // Volta para a lista, na mesma página em que a pessoa estava
    private function irParaLista($pagina = 1)
    {
        $pagina = max(1, (int) $pagina);

        header('Location: ' . BASE_URL . 'blogadmin' . ($pagina > 1 ? '?pagina=' . $pagina : ''));
        exit;
    }
}
