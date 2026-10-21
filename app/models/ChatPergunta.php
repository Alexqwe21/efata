<?php
// app/models/ChatPergunta.php
// Perguntas e respostas prontas do chat do leão (balão flutuante do site)

class ChatPergunta extends Model
{
    // Só as ativas, na ordem em que aparecem no balão
    public function listarAtivas()
    {
        $sql = "SELECT id_pergunta, pergunta_chat, resposta_chat, texto_link_chat, url_link_chat
                FROM tbl_chat_perguntas
                WHERE ativo_chat = 1
                ORDER BY ordem_chat, id_pergunta";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodas()
    {
        $stmt = $this->db->query("SELECT * FROM tbl_chat_perguntas ORDER BY ordem_chat, id_pergunta");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($d)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO tbl_chat_perguntas
                (pergunta_chat, resposta_chat, texto_link_chat, url_link_chat, ordem_chat, ativo_chat)
             VALUES (:pergunta, :resposta, :texto_link, :url_link, :ordem, :ativo)"
        );
        $stmt->execute($this->parametros($d));

        return (int) $this->db->lastInsertId();
    }

    public function atualizar($id, $d)
    {
        $stmt = $this->db->prepare(
            "UPDATE tbl_chat_perguntas SET
                pergunta_chat   = :pergunta,
                resposta_chat   = :resposta,
                texto_link_chat = :texto_link,
                url_link_chat   = :url_link,
                ordem_chat      = :ordem,
                ativo_chat      = :ativo
             WHERE id_pergunta = :id"
        );

        $params = $this->parametros($d);
        $params[':id'] = (int) $id;

        return $stmt->execute($params);
    }

    public function excluir($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tbl_chat_perguntas WHERE id_pergunta = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function parametros($d)
    {
        return [
            ':pergunta'   => $d['pergunta_chat'],
            ':resposta'   => $d['resposta_chat'],
            ':texto_link' => $d['texto_link_chat'] !== '' ? $d['texto_link_chat'] : null,
            ':url_link'   => $d['url_link_chat'] !== '' ? $d['url_link_chat'] : null,
            ':ordem'      => (int) $d['ordem_chat'],
            ':ativo'      => $d['ativo_chat'] ? 1 : 0,
        ];
    }
}
