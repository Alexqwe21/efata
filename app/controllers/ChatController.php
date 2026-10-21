<?php
// app/controllers/ChatController.php
// Parte pública do chat do leão:
//   /chat/perguntas -> (GET, AJAX) devolve em JSON as perguntas ativas do balão

class ChatController extends Controller
{
    public function index()
    {
        header('Location: ' . BASE_URL);
        exit;
    }

    public function perguntas()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: public, max-age=300');

        try {
            $model     = new ChatPergunta();
            $perguntas = $model->listarAtivas();
        } catch (PDOException $e) {
            // Tabela ainda não criada: o balão continua funcionando, só com o botão do WhatsApp
            $perguntas = [];
        }

        echo json_encode(['perguntas' => $perguntas], JSON_UNESCAPED_UNICODE);
    }
}
