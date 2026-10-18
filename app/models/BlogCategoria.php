<?php
// app/models/BlogCategoria.php

class BlogCategoria extends Model
{
    public function listar()
    {
        $stmt = $this->db->query("SELECT * FROM tbl_blog_categorias ORDER BY nome_categoria_blog");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Categorias que têm ao menos um post público (para o menu lateral do blog)
    public function listarComPosts()
    {
        $sql = "SELECT c.id_categoria_blog, c.nome_categoria_blog, c.slug_categoria_blog,
                       COUNT(p.id_post) AS total_posts
                FROM tbl_blog_categorias c
                INNER JOIN tbl_blog_posts p
                        ON p.id_categoria_blog = c.id_categoria_blog
                       AND p.status_post = 'publicado'
                       AND p.data_publicacao_post <= :agora
                GROUP BY c.id_categoria_blog, c.nome_categoria_blog, c.slug_categoria_blog
                ORDER BY c.nome_categoria_blog";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':agora', date('Y-m-d H:i:s'));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_blog_categorias WHERE id_categoria_blog = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorSlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_blog_categorias WHERE slug_categoria_blog = :slug");
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criar($nome)
    {
        $base = Slug::gerar($nome, 100);
        if ($base === '') {
            $base = 'categoria';
        }

        $slug = $base;
        $i = 2;
        while ($this->buscarPorSlug($slug)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        $stmt = $this->db->prepare(
            "INSERT INTO tbl_blog_categorias (nome_categoria_blog, slug_categoria_blog)
             VALUES (:nome, :slug)"
        );
        $stmt->execute([':nome' => $nome, ':slug' => $slug]);

        return (int) $this->db->lastInsertId();
    }

    // Os posts da categoria excluída ficam sem categoria (ON DELETE SET NULL)
    public function excluir($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tbl_blog_categorias WHERE id_categoria_blog = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}