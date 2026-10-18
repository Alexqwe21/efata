<?php
// app/models/BlogImagem.php
// Fotos da galeria de cada post.

class BlogImagem extends Model
{
    public function listarPorPost($idPost)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM tbl_blog_post_imagens
             WHERE id_post = :id
             ORDER BY ordem_imagem ASC, id_imagem ASC"
        );
        $stmt->bindValue(':id', (int) $idPost, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Para a lista do painel: uma consulta só. Retorna [id_post => [imagens...]]
    public function listarPorPosts(array $ids)
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));

        if (!$ids) {
            return [];
        }

        $marcas = implode(',', array_fill(0, count($ids), '?'));

        $stmt = $this->db->prepare(
            "SELECT * FROM tbl_blog_post_imagens
             WHERE id_post IN ($marcas)
             ORDER BY ordem_imagem ASC, id_imagem ASC"
        );
        $stmt->execute($ids);

        $agrupado = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $linha) {
            $agrupado[(int) $linha['id_post']][] = $linha;
        }

        return $agrupado;
    }

    public function contarPorPost($idPost)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tbl_blog_post_imagens WHERE id_post = :id");
        $stmt->bindValue(':id', (int) $idPost, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function proximaOrdem($idPost)
    {
        $stmt = $this->db->prepare("SELECT COALESCE(MAX(ordem_imagem), 0) + 1 FROM tbl_blog_post_imagens WHERE id_post = :id");
        $stmt->bindValue(':id', (int) $idPost, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function criar($idPost, $arquivo, $legenda, $ordem)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO tbl_blog_post_imagens (id_post, arquivo_imagem, legenda_imagem, ordem_imagem)
             VALUES (:post, :arquivo, :legenda, :ordem)"
        );
        $stmt->execute([
            ':post'    => (int) $idPost,
            ':arquivo' => $arquivo,
            ':legenda' => $legenda !== '' ? $legenda : null,
            ':ordem'   => (int) $ordem,
        ]);

        return (int) $this->db->lastInsertId();
    }

    // A condição id_post garante que só mexe em imagem do próprio post
    public function atualizarLegendaOrdem($idImagem, $idPost, $legenda, $ordem)
    {
        $stmt = $this->db->prepare(
            "UPDATE tbl_blog_post_imagens
             SET legenda_imagem = :legenda, ordem_imagem = :ordem
             WHERE id_imagem = :id AND id_post = :post"
        );
        return $stmt->execute([
            ':legenda' => $legenda !== '' ? $legenda : null,
            ':ordem'   => (int) $ordem,
            ':id'      => (int) $idImagem,
            ':post'    => (int) $idPost,
        ]);
    }

    // Retorna as imagens (do post) que serão removidas, e apaga as linhas
    public function excluirPorIds($idPost, array $ids)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        if (!$ids) {
            return [];
        }

        $marcas = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge([(int) $idPost], $ids);

        $stmt = $this->db->prepare("SELECT * FROM tbl_blog_post_imagens WHERE id_post = ? AND id_imagem IN ($marcas)");
        $stmt->execute($params);
        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("DELETE FROM tbl_blog_post_imagens WHERE id_post = ? AND id_imagem IN ($marcas)");
        $stmt->execute($params);

        return $linhas;
    }
}
