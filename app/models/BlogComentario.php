<?php
// app/models/BlogComentario.php

class BlogComentario extends Model
{
    // ---------- parte pública ----------

    public function listarAprovados($idPost)
    {
        $sql = "SELECT nome_comentario, texto_comentario, data_cadastro_comentario
                FROM tbl_blog_comentarios
                WHERE id_post = :id AND status_comentario = 'aprovado'
                ORDER BY data_cadastro_comentario ASC, id_comentario ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int) $idPost, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar($d)
    {
        $sql = "INSERT INTO tbl_blog_comentarios
                    (id_post, nome_comentario, email_comentario, texto_comentario,
                     status_comentario, ip_hash_comentario, data_cadastro_comentario)
                VALUES
                    (:id_post, :nome, :email, :texto, :status, :ip, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_post', (int) $d['id_post'], PDO::PARAM_INT);
        $stmt->bindValue(':nome',    $d['nome']);
        $stmt->bindValue(':email',   $d['email'] !== '' ? $d['email'] : null);
        $stmt->bindValue(':texto',   $d['texto']);
        $stmt->bindValue(':status',  $d['status']);
        $stmt->bindValue(':ip',      $d['ip_hash']);
        $stmt->execute();

        return (int) $this->db->lastInsertId();
    }

    // Quantos comentários esse IP enviou nos últimos N minutos
    public function contarRecentesPorIp($ipHash, $minutos)
    {
        $sql = "SELECT COUNT(*) FROM tbl_blog_comentarios
                WHERE ip_hash_comentario = :ip
                  AND data_cadastro_comentario >= (NOW() - INTERVAL " . (int) $minutos . " MINUTE)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':ip', $ipHash);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    // Mesmo texto, no mesmo post, pelo mesmo IP (clique duplo ou repetição)
    public function existeIgual($idPost, $ipHash, $texto)
    {
        $sql = "SELECT COUNT(*) FROM tbl_blog_comentarios
                WHERE id_post = :id AND ip_hash_comentario = :ip AND texto_comentario = :texto";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int) $idPost, PDO::PARAM_INT);
        $stmt->bindValue(':ip', $ipHash);
        $stmt->bindValue(':texto', $texto);
        $stmt->execute();

        return (int) $stmt->fetchColumn() > 0;
    }

    // ---------- parte do painel ----------

    public function listarPorStatus($status, $limite, $offset)
    {
        $sql = "SELECT c.*, p.titulo_post, p.slug_post
                FROM tbl_blog_comentarios c
                INNER JOIN tbl_blog_posts p ON p.id_post = c.id_post
                WHERE c.status_comentario = :status
                ORDER BY c.data_cadastro_comentario DESC
                LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ['pendente' => 3, 'aprovado' => 10, 'spam' => 1]
    public function totaisPorStatus()
    {
        $totais = ['pendente' => 0, 'aprovado' => 0, 'spam' => 0];

        $stmt = $this->db->query("SELECT status_comentario, COUNT(*) AS total
                                  FROM tbl_blog_comentarios GROUP BY status_comentario");

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $linha) {
            $totais[$linha['status_comentario']] = (int) $linha['total'];
        }

        return $totais;
    }

    public function mudarStatus($id, $status)
    {
        if (!in_array($status, ['pendente', 'aprovado', 'spam'], true)) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE tbl_blog_comentarios SET status_comentario = :s WHERE id_comentario = :id");
        $stmt->bindValue(':s', $status);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function excluir($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tbl_blog_comentarios WHERE id_comentario = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
