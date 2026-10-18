<?php
// app/models/BlogPost.php

class BlogPost extends Model
{
    // Um post só é público se estiver "publicado" e a data de publicação já chegou
    private function condicaoPublicado()
    {
        return "p.status_post = 'publicado' AND p.data_publicacao_post <= :agora";
    }

    // =======================
    // PARTE PÚBLICA
    // =======================

    public function listarPublicados($limite, $offset, $idCategoria = null)
    {
        $sql = "SELECT p.id_post, p.titulo_post, p.slug_post, p.resumo_post,
                       p.foto_post, p.alt_foto_post, p.data_publicacao_post,
                       c.nome_categoria_blog, c.slug_categoria_blog,
                       f.nome_funcionario
                FROM tbl_blog_posts p
                LEFT JOIN tbl_blog_categorias c ON c.id_categoria_blog = p.id_categoria_blog
                INNER JOIN tbl_funcionario f ON f.id_funcionario = p.id_funcionario
                WHERE " . $this->condicaoPublicado();

        if ($idCategoria) {
            $sql .= " AND p.id_categoria_blog = :categoria";
        }

        $sql .= " ORDER BY p.data_publicacao_post DESC LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':agora', date('Y-m-d H:i:s'));
        if ($idCategoria) {
            $stmt->bindValue(':categoria', (int) $idCategoria, PDO::PARAM_INT);
        }
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarPublicados($idCategoria = null)
    {
        $sql = "SELECT COUNT(*) FROM tbl_blog_posts p WHERE " . $this->condicaoPublicado();

        if ($idCategoria) {
            $sql .= " AND p.id_categoria_blog = :categoria";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':agora', date('Y-m-d H:i:s'));
        if ($idCategoria) {
            $stmt->bindValue(':categoria', (int) $idCategoria, PDO::PARAM_INT);
        }
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function buscarPublicadoPorSlug($slug)
    {
        $sql = "SELECT p.*, c.nome_categoria_blog, c.slug_categoria_blog, f.nome_funcionario
                FROM tbl_blog_posts p
                LEFT JOIN tbl_blog_categorias c ON c.id_categoria_blog = p.id_categoria_blog
                INNER JOIN tbl_funcionario f ON f.id_funcionario = p.id_funcionario
                WHERE p.slug_post = :slug AND " . $this->condicaoPublicado() . "
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':slug', $slug);
        $stmt->bindValue(':agora', date('Y-m-d H:i:s'));
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =======================
    // PARTE ADMIN
    // =======================

    // Traz todos os campos do post, porque a edição é feita em modal na própria lista
    public function listarTodos($limite, $offset)
    {
        $sql = "SELECT p.*, c.nome_categoria_blog, f.nome_funcionario
                FROM tbl_blog_posts p
                LEFT JOIN tbl_blog_categorias c ON c.id_categoria_blog = p.id_categoria_blog
                INNER JOIN tbl_funcionario f ON f.id_funcionario = p.id_funcionario
                ORDER BY p.data_cadastro_post DESC
                LIMIT :limite OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTodos()
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM tbl_blog_posts");
        return (int) $stmt->fetchColumn();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_blog_posts WHERE id_post = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($d)
    {
        $sql = "INSERT INTO tbl_blog_posts
                    (id_funcionario, id_categoria_blog, titulo_post, slug_post, resumo_post,
                     conteudo_post, foto_post, alt_foto_post, video_post, status_post, data_publicacao_post)
                VALUES
                    (:funcionario, :categoria, :titulo, :slug, :resumo,
                     :conteudo, :foto, :alt, :video, :status, :data_pub)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':funcionario' => $d['id_funcionario'],
            ':categoria'   => $d['id_categoria_blog'],
            ':titulo'      => $d['titulo_post'],
            ':slug'        => $d['slug_post'],
            ':resumo'      => $d['resumo_post'],
            ':conteudo'    => $d['conteudo_post'],
            ':foto'        => $d['foto_post'],
            ':alt'         => $d['alt_foto_post'],
            ':video'       => $d['video_post'] ?? null,
            ':status'      => $d['status_post'],
            ':data_pub'    => $d['data_publicacao_post'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    // O slug não muda ao editar, para não quebrar links já compartilhados
    public function atualizar($id, $d)
    {
        $sql = "UPDATE tbl_blog_posts SET
                    id_categoria_blog    = :categoria,
                    titulo_post          = :titulo,
                    resumo_post          = :resumo,
                    conteudo_post        = :conteudo,
                    foto_post            = :foto,
                    alt_foto_post        = :alt,
                    video_post           = :video,
                    status_post          = :status,
                    data_publicacao_post = :data_pub
                WHERE id_post = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':categoria' => $d['id_categoria_blog'],
            ':titulo'    => $d['titulo_post'],
            ':resumo'    => $d['resumo_post'],
            ':conteudo'  => $d['conteudo_post'],
            ':foto'      => $d['foto_post'],
            ':alt'       => $d['alt_foto_post'],
            ':video'     => $d['video_post'] ?? null,
            ':status'    => $d['status_post'],
            ':data_pub'  => $d['data_publicacao_post'],
            ':id'        => (int) $id,
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tbl_blog_posts WHERE id_post = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // =======================
    // SLUG ÚNICO
    // =======================

    public function gerarSlug($titulo)
    {
        $base = Slug::gerar($titulo, 200);
        if ($base === '') {
            $base = 'post';
        }

        $slug = $base;
        $i = 2;
        while ($this->slugExiste($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private function slugExiste($slug)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tbl_blog_posts WHERE slug_post = :slug");
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        return (int) $stmt->fetchColumn() > 0;
    }
}
