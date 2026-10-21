<?php
// app/controllers/ChatadminController.php
// Painel do chat do leão (exige login). Tudo acontece em /chatadmin, usando modais:
//   /chatadmin                -> lista de perguntas (modais: nova pergunta, editar pergunta)
//   /chatadmin/salvar         -> (POST) grava nova pergunta
//   /chatadmin/atualizar/{id} -> (POST) grava edição
//   /chatadmin/excluir/{id}   -> (POST) exclui

class ChatadminController extends Controller
{
    private $model;

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

        $this->model = new ChatPergunta();
    }

    public function index()
    {
        // Se o último envio deu erro, devolve o que a pessoa digitou e reabre o modal
        $old   = $_SESSION['chat_old'] ?? null;
        $abrir = $_SESSION['chat_abrir'] ?? null;
        unset($_SESSION['chat_old'], $_SESSION['chat_abrir']);

        $perguntas = $this->model->listarTodas();
        $nova      = $this->perguntaVazia();

        if ($old) {
            if ((int) $old['id'] === 0) {
                $nova = array_merge($nova, $old['dados']);
            } else {
                foreach ($perguntas as $i => $p) {
                    if ((int) $p['id_pergunta'] === (int) $old['id']) {
                        $perguntas[$i] = array_merge($p, $old['dados']);
                    }
                }
            }
        }

        $this->carregarViews('dash/dashboard', [
            'conteudo'     => 'dash/chat/index',
            'tituloPagina' => 'Chat do leão',
            'perguntas'    => $perguntas,
            'nova'         => $nova,
            'abrir'        => $abrir,
            'flash'        => $this->pegarFlash(),
            'csrf'         => $this->csrfToken(),
        ]);
    }

    public function salvar()
    {
        $this->exigirPost();
        $this->verificarCsrf();

        [$dados, $erro] = $this->validar($_POST);

        if ($erro) {
            $this->devolverComErro(0, $dados, $erro, 'modalNovaPergunta');
        }

        $this->model->criar($dados);
        $this->flash('Pergunta adicionada ao chat.');
        $this->irParaLista();
    }

    public function atualizar($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $id = (int) $id;
        [$dados, $erro] = $this->validar($_POST);

        if ($erro) {
            $this->devolverComErro($id, $dados, $erro, 'modalEditarPergunta' . $id);
        }

        $this->model->atualizar($id, $dados);
        $this->flash('Pergunta atualizada.');
        $this->irParaLista();
    }

    public function excluir($id = 0)
    {
        $this->exigirPost();
        $this->verificarCsrf();

        $this->model->excluir((int) $id);
        $this->flash('Pergunta excluída.');
        $this->irParaLista();
    }

    // =======================
    // AUXILIARES (privados)
    // =======================

    private function perguntaVazia()
    {
        return [
            'id_pergunta'     => 0,
            'pergunta_chat'   => '',
            'resposta_chat'   => '',
            'texto_link_chat' => '',
            'url_link_chat'   => '',
            'ordem_chat'      => 0,
            'ativo_chat'      => 1,
        ];
    }

    // Devolve [dados limpos, mensagem de erro ou null]
    private function validar($in)
    {
        $dados = [
            'pergunta_chat'   => trim($in['pergunta_chat'] ?? ''),
            'resposta_chat'   => trim($in['resposta_chat'] ?? ''),
            'texto_link_chat' => trim($in['texto_link_chat'] ?? ''),
            'url_link_chat'   => trim($in['url_link_chat'] ?? ''),
            'ordem_chat'      => (int) ($in['ordem_chat'] ?? 0),
            'ativo_chat'      => !empty($in['ativo_chat']) ? 1 : 0,
        ];

        if ($dados['pergunta_chat'] === '' || mb_strlen($dados['pergunta_chat']) > 150) {
            return [$dados, 'Informe a pergunta (até 150 caracteres).'];
        }

        if ($dados['resposta_chat'] === '' || mb_strlen($dados['resposta_chat']) > 2000) {
            return [$dados, 'Informe a resposta (até 2000 caracteres).'];
        }

        if (mb_strlen($dados['texto_link_chat']) > 60) {
            return [$dados, 'O texto do botão pode ter até 60 caracteres.'];
        }

        // O botão só aparece com os dois campos preenchidos
        if (($dados['texto_link_chat'] === '') !== ($dados['url_link_chat'] === '')) {
            return [$dados, 'Para o botão aparecer, preencha o texto e o link (ou deixe os dois vazios).'];
        }

        // Aceita só caminhos do site (/matricula) ou endereços http(s)
        $url = $dados['url_link_chat'];
        if ($url !== '') {
            $interno = preg_match('#^/(?!/)#', $url);
            $externo = filter_var($url, FILTER_VALIDATE_URL) && preg_match('#^https?://#i', $url);

            if (mb_strlen($url) > 255 || (!$interno && !$externo)) {
                return [$dados, 'O link deve começar com / (página do site) ou com https://'];
            }
        }

        return [$dados, null];
    }

    private function devolverComErro($id, $dados, $erro, $modal)
    {
        $_SESSION['chat_old']   = ['id' => $id, 'dados' => $dados];
        $_SESSION['chat_abrir'] = $modal;
        $this->flash($erro, 'erro');
        $this->irParaLista();
    }

    // ---- sessão: mensagens e CSRF ----

    private function flash($msg, $tipo = 'sucesso')
    {
        $_SESSION['chat_flash'] = ['tipo' => $tipo, 'msg' => $msg];
    }

    private function pegarFlash()
    {
        $f = $_SESSION['chat_flash'] ?? null;
        unset($_SESSION['chat_flash']);
        return $f;
    }

    private function csrfToken()
    {
        if (empty($_SESSION['chat_csrf'])) {
            $_SESSION['chat_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['chat_csrf'];
    }

    private function verificarCsrf()
    {
        $token = $_POST['csrf'] ?? '';

        if (empty($_SESSION['chat_csrf']) || !hash_equals($_SESSION['chat_csrf'], $token)) {
            http_response_code(403);
            exit('Requisição inválida. Volte e tente novamente.');
        }
    }

    private function exigirPost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->irParaLista();
        }
    }

    private function irParaLista()
    {
        header('Location: ' . BASE_URL . 'chatadmin');
        exit;
    }
}
