<?php

class Estoques extends Model
{
    /**
     * LISTAR PRODUTOS DE UM ESTOQUE COM SALDO
     */
    public function listarProdutosEstoque($idEstoque, $filtros = [])
    {
        $sql = "
        SELECT 
            p.id_produto,
            p.nome_produto,
            p.descricao,
            p.unidade,
            p.status_produto,
            p.id_categoria,
            c.nome_categoria,
            COALESCE(SUM(
                CASE 
                    WHEN m.tipo = 'Entrada' THEN m.quantidade
                    WHEN m.tipo = 'Saida' THEN -m.quantidade
                    ELSE 0
                END
            ), 0) AS saldo
        FROM tbl_produto p
        LEFT JOIN tbl_categoria_produto c ON c.id_categoria = p.id_categoria
        LEFT JOIN tbl_movimentacao_estoque m 
            ON m.id_produto = p.id_produto
           AND m.id_estoque = :estoque
        WHERE 1 = 1
    ";

        $params = [':estoque' => $idEstoque];

        // 🔹 FILTRO STATUS
        if (!empty($filtros['status'])) {
            $sql .= " AND p.status_produto = :status ";
            $params[':status'] = $filtros['status'];
        }

        // 🔹 FILTRO NOME
        if (!empty($filtros['nome'])) {
            $sql .= " AND p.nome_produto LIKE :nome ";
            $params[':nome'] = '%' . $filtros['nome'] . '%';
        }

        // 🔹 FILTRO CATEGORIA
        if (!empty($filtros['categoria'])) {
            $sql .= " AND p.id_categoria = :categoria ";
            $params[':categoria'] = $filtros['categoria'];
        }

        $sql .= " GROUP BY p.id_produto ";

        if (!empty($filtros['saldo'])) {
            if ($filtros['saldo'] == 'positivo') {
                $sql .= " HAVING saldo > 0 ";
            }
            if ($filtros['saldo'] == 'zerado') {
                $sql .= " HAVING saldo <= 0 ";
            }
        }

        $sql .= " ORDER BY p.nome_produto ASC ";

        // 🔹 FILTRO UNIDADE
        if (!empty($filtros['unidade'])) {
            $sql .= " AND p.unidade = :unidade ";
            $params[':unidade'] = $filtros['unidade'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    /**
     * CADASTRAR PRODUTO
     */
    public function cadastrarProduto($dados)
    {
        $sql = "
            INSERT INTO tbl_produto (
                nome_produto,
                descricao,
                id_categoria,
                unidade,
                status_produto
            ) VALUES (
                :nome,
                :descricao,
                :categoria,
                :unidade,
                'Ativo'
            )
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome'      => $dados['nome_produto'],
            ':descricao' => $dados['descricao'],
            ':categoria' => $dados['id_categoria'],
            ':unidade'   => $dados['unidade']
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * REGISTRAR MOVIMENTAÇÃO
     */
    public function movimentarEstoque($dados)
    {
        $sql = "
            INSERT INTO tbl_movimentacao_estoque (
                id_produto,
                id_estoque,
                tipo,
                quantidade,
                motivo,
                data_movimentacao
            ) VALUES (
                :produto,
                :estoque,
                :tipo,
                :quantidade,
                :motivo,
                NOW()
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':produto'    => $dados['id_produto'],
            ':estoque'    => $dados['id_estoque'],
            ':tipo'       => $dados['tipo'],
            ':quantidade' => $dados['quantidade'],
            ':motivo'     => $dados['motivo'] ?? null
        ]);
    }

    public function criarOuBuscarCategoria($nome)
    {
        $stmt = $this->db->prepare(
            "SELECT id_categoria FROM tbl_categoria_produto WHERE nome_categoria = :nome"
        );
        $stmt->execute([':nome' => $nome]);
        $cat = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cat) {
            return $cat['id_categoria'];
        }

        $stmt = $this->db->prepare(
            "INSERT INTO tbl_categoria_produto (nome_categoria, status_categoria)
         VALUES (:nome, 'Ativo')"
        );
        $stmt->execute([':nome' => $nome]);

        return $this->db->lastInsertId();
    }


    public function listarCategoriasAtivas()
    {
        $sql = "SELECT id_categoria, nome_categoria
            FROM tbl_categoria_produto
            WHERE status_categoria = 'Ativo'
            ORDER BY nome_categoria ASC";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function buscarProduto($idProduto)
    {
        $sql = "
        SELECT 
            p.id_produto,
            p.nome_produto,
            p.descricao,
            p.unidade,
            p.status_produto,
            c.nome_categoria
        FROM tbl_produto p
        LEFT JOIN tbl_categoria_produto c 
            ON c.id_categoria = p.id_categoria
        WHERE p.id_produto = :id
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $idProduto]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function listarMovimentacoesProduto($idProduto, $idEstoque)
    {
        $sql = "
        SELECT 
            tipo,
            quantidade,
            motivo,
            data_movimentacao
        FROM tbl_movimentacao_estoque
        WHERE id_produto = :produto
          AND id_estoque = :estoque
        ORDER BY data_movimentacao DESC
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':produto' => $idProduto,
            ':estoque' => $idEstoque
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarProduto($dados)
    {
        $sql = "
        UPDATE tbl_produto SET
            nome_produto  = :nome,
            descricao     = :descricao,
            id_categoria  = :categoria,
            unidade       = :unidade,
            status_produto = :status
        WHERE id_produto = :id
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nome'      => $dados['nome_produto'],
            ':descricao' => $dados['descricao'],
            ':categoria' => $dados['id_categoria'],
            ':unidade'   => $dados['unidade'],
            ':status'    => $dados['status_produto'],
            ':id'        => $dados['id_produto']
        ]);
    }
}
