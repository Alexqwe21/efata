<?php

class Onboarding extends Model
{
    /**
     * LISTAR PRODUTOS COM SALDO POR ESTOQUE
     */
  public function listarProdutosBank()
{
    $where = [];
    $params = [];

    // STATUS
    if (!empty($_GET['status'])) {
        $where[] = "p.status_produto = :status";
        $params[':status'] = $_GET['status'];
    }

    // NOME PRODUTO
    if (!empty($_GET['nome'])) {
        $where[] = "p.nome_produto LIKE :nome";
        $params[':nome'] = '%' . $_GET['nome'] . '%';
    }

    // CATEGORIA
    if (!empty($_GET['categoria'])) {
        $where[] = "p.id_categoria = :categoria";
        $params[':categoria'] = $_GET['categoria'];
    }

    // UNIDADE
    if (!empty($_GET['unidade'])) {
        $where[] = "p.unidade = :unidade";
        $params[':unidade'] = $_GET['unidade'];
    }

    $filtroSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "
        SELECT 
            p.id_produto,
            p.nome_produto,
            p.descricao,
            p.unidade,
            p.status_produto,
            p.id_categoria,        -- 🔴 ESSENCIAL
            c.nome_categoria,
            COALESCE(SUM(
                CASE 
                    WHEN m.tipo = 'Entrada' THEN m.quantidade
                    WHEN m.tipo = 'Saida' THEN -m.quantidade
                END
            ), 0) AS saldo
        FROM tbl_onboarding_produto p
        LEFT JOIN tbl_onboarding_categoria c 
            ON c.id_categoria = p.id_categoria
        INNER JOIN tbl_onboarding_movimentacao m
            ON m.id_produto = p.id_produto
           AND m.id_estoque = 1
        $filtroSql
        GROUP BY p.id_produto
        ORDER BY p.nome_produto ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}






    
    public function listarProdutosRepublica($idEstoque)
{
    $where = [];
    $params = [':estoque' => $idEstoque];

    // STATUS
    if (!empty($_GET['status'])) {
        $where[] = "p.status_produto = :status";
        $params[':status'] = $_GET['status'];
    }

    // NOME PRODUTO
    if (!empty($_GET['nome'])) {
        $where[] = "p.nome_produto LIKE :nome";
        $params[':nome'] = '%' . $_GET['nome'] . '%';
    }

    // CATEGORIA
    if (!empty($_GET['categoria'])) {
        $where[] = "p.id_categoria = :categoria";
        $params[':categoria'] = $_GET['categoria'];
    }

    // UNIDADE
    if (!empty($_GET['unidade'])) {
        $where[] = "p.unidade = :unidade";
        $params[':unidade'] = $_GET['unidade'];
    }

    $filtroSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "
        SELECT 
            p.id_produto,
            p.nome_produto,
            p.descricao,
            p.unidade,
            p.id_categoria,        -- 🔴 ESSENCIAL
            p.status_produto,
            c.nome_categoria,
            COALESCE(SUM(
                CASE 
                    WHEN m.tipo = 'Entrada' THEN m.quantidade
                    WHEN m.tipo = 'Saida' THEN -m.quantidade
                END
            ), 0) AS saldo
        FROM tbl_onboarding_produto p
        LEFT JOIN tbl_onboarding_categoria c 
            ON c.id_categoria = p.id_categoria
        INNER JOIN tbl_onboarding_movimentacao m
            ON m.id_produto = p.id_produto
           AND m.id_estoque = :estoque
        $filtroSql
        GROUP BY p.id_produto
        ORDER BY p.nome_produto ASC
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function listarProdutosCamisetas()
{
    $where = [];
    $params = [];

    // STATUS
    if (!empty($_GET['status'])) {
        $where[] = "p.status_produto = :status";
        $params[':status'] = $_GET['status'];
    }

    // NOME PRODUTO
    if (!empty($_GET['nome'])) {
        $where[] = "p.nome_produto LIKE :nome";
        $params[':nome'] = '%' . $_GET['nome'] . '%';
    }

    // CATEGORIA
    if (!empty($_GET['categoria'])) {
        $where[] = "p.id_categoria = :categoria";
        $params[':categoria'] = $_GET['categoria'];
    }

    // UNIDADE
    if (!empty($_GET['unidade'])) {
        $where[] = "p.unidade = :unidade";
        $params[':unidade'] = $_GET['unidade'];
    }

    $filtroSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

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
                END
            ), 0) AS saldo
        FROM tbl_onboarding_produto p
        LEFT JOIN tbl_onboarding_categoria c 
            ON c.id_categoria = p.id_categoria
        INNER JOIN tbl_onboarding_movimentacao m
            ON m.id_produto = p.id_produto
           AND m.id_estoque = 3  -- 🟣 ESTOQUE CAMISETAS
        $filtroSql
        GROUP BY p.id_produto
        ORDER BY p.nome_produto ASC
    ";

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
            INSERT INTO tbl_onboarding_produto
            (nome_produto, descricao, unidade, id_categoria, status_produto, data_cadastro)
            VALUES
            (:nome, :descricao, :unidade, :categoria, 'Ativo', NOW())
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome'      => $dados['nome_produto'],
            ':descricao' => $dados['descricao'] ?? null,
            ':unidade'   => $dados['unidade'],
            ':categoria' => $dados['id_categoria'] ?? null
        ]);

   
        return $this->db->lastInsertId();

        
    }

    /**
     * MOVIMENTAR ESTOQUE
     */
    public function movimentar($dados)
    {
        $sql = "
            INSERT INTO tbl_onboarding_movimentacao
            (id_produto, id_estoque, tipo, quantidade, motivo, data_movimentacao)
            VALUES
            (:produto, :estoque, :tipo, :quantidade, :motivo, NOW())
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


    public function listarCategorias()
{
    return $this->db->query("
        SELECT id_categoria, nome_categoria
        FROM tbl_onboarding_categoria
        WHERE status_categoria = 'Ativo'
        ORDER BY nome_categoria
    ")->fetchAll(PDO::FETCH_ASSOC);
}


public function cadastrarCategoria($nome)
{
    $sql = "INSERT INTO tbl_onboarding_categoria (nome_categoria, status_categoria) 
            VALUES (:nome, 'Ativo')";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':nome' => $nome]);
    return $this->db->lastInsertId();
}


public function atualizarProduto($dados)
{
    $sql = "
        UPDATE tbl_onboarding_produto
        SET
            nome_produto   = :nome,
            descricao      = :descricao,
            unidade        = :unidade,
            id_categoria   = :categoria,
            status_produto = :status
        WHERE id_produto = :id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':nome'      => $dados['nome_produto'],
        ':descricao' => $dados['descricao'],
        ':unidade'   => $dados['unidade'],
        ':categoria' => $dados['id_categoria'],
        ':status'    => $dados['status_produto'],
        ':id'        => $dados['id_produto']
    ]);
}


private function montarFiltros(&$params)
{
    $where = [];

    // STATUS
    if (!empty($_GET['status'])) {
        $where[] = "p.status_produto = :status";
        $params[':status'] = $_GET['status'];
    }

    // NOME PRODUTO
    if (!empty($_GET['nome'])) {
        $where[] = "p.nome_produto LIKE :nome";
        $params[':nome'] = '%' . $_GET['nome'] . '%';
    }

    // CATEGORIA
    if (!empty($_GET['categoria'])) {
        $where[] = "p.id_categoria = :categoria";
        $params[':categoria'] = $_GET['categoria'];
    }

    // UNIDADE
    if (!empty($_GET['unidade'])) {
        $where[] = "p.unidade = :unidade";
        $params[':unidade'] = $_GET['unidade'];
    }

    return $where ? ' AND ' . implode(' AND ', $where) : '';
}





}


