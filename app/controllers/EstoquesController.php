<?php

class EstoquesController extends Controller
{
    private $estoqueModel;

    public function __construct()
    {
        if (!isset($_SESSION['userId']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location: ' . BASE_URL);
            exit;
        }

        $this->estoqueModel = new Estoques();
    }

    /**
     * ESTOQUE BANK (id = 1)
     */
    public function index()
    {
        $filtros = [
            'status'    => $_GET['status']    ?? null,
            'nome'      => $_GET['nome']      ?? null,
            'categoria' => $_GET['categoria'] ?? null,
            'saldo'     => $_GET['saldo']     ?? null,
            'unidade'   => $_GET['unidade']   ?? null,
        ];

        $dados = [];
        $dados['produtos']   = $this->estoqueModel->listarProdutosEstoque(1, $filtros);
        $dados['categorias'] = $this->estoqueModel->listarCategoriasAtivas();
        $dados['conteudo']   = 'dash/estoques/listar';

        $this->carregarViews('dash/dashboard', $dados);
    }



    /**
     * SALVAR PRODUTO + ENTRADA INICIAL
     */
    public function salvar()
    {

        // Estoque (dinâmico)
        $idEstoque = $_POST['id_estoque'] ?? 1;




        var_dump($idEstoque);
        exit;

        // 👉 1. Criar categoria se existir nova
        $idCategoria = $_POST['id_categoria'] ?: null;

        if (!empty($_POST['nova_categoria'])) {
            $idCategoria = $this->estoqueModel->criarOuBuscarCategoria(
                trim($_POST['nova_categoria'])
            );
        }

        // 👉 2. Criar produto
        $produtoId = $this->estoqueModel->cadastrarProduto([
            'nome_produto' => $_POST['nome_produto'],
            'descricao'    => $_POST['descricao'] ?? null,
            'id_categoria' => $idCategoria,
            'unidade'      => $_POST['unidade']
        ]);




        // 👉 3. Entrada inicial
        $this->estoqueModel->movimentarEstoque([
            'id_produto' => $produtoId,
            'id_estoque' => $idEstoque,
            'tipo'       => 'Entrada',
            'quantidade' => $_POST['quantidade'],
            'motivo'     => 'Cadastro inicial'
        ]);

        var_dump($idEstoque);
        exit;

        $_SESSION['sucesso'] = 'Produto cadastrado com sucesso!';
        header('Location: ' . BASE_URL . '/Estoques');
        exit;
    }

    public function atualizar($idProduto)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/Estoques');
            exit;
        }

        // Categoria existente ou nova
        $idCategoria = $_POST['id_categoria'] ?: null;

        if (!empty($_POST['nova_categoria'])) {
            $idCategoria = $this->estoqueModel->criarOuBuscarCategoria(
                trim($_POST['nova_categoria'])
            );
        }

        $this->estoqueModel->atualizarProduto([
            'id_produto'   => $idProduto,
            'nome_produto' => $_POST['nome_produto'],
            'descricao'    => $_POST['descricao'] ?? null,
            'id_categoria' => $idCategoria,
            'unidade'      => $_POST['unidade'],
            'status_produto' => $_POST['status_produto']
        ]);

        $_SESSION['sucesso'] = 'Produto atualizado com sucesso!';
        header('Location: ' . BASE_URL . '/Estoques');
        exit;
    }

    public function movimentar()
    {
        $this->estoqueModel->movimentarEstoque([
            'id_produto' => $_POST['id_produto'],
            'id_estoque' => 1,
            'tipo'       => $_POST['tipo'], // Entrada ou Saida
            'quantidade' => $_POST['quantidade'],
            'motivo'     => $_POST['motivo']
        ]);

        $_SESSION['sucesso'] = 'Movimentação registrada!';
        header('Location: ' . BASE_URL . '/Estoques');
        exit;
    }





    public function republica()
    {
        $filtros = [
            'status'    => $_GET['status']    ?? null,
            'nome'      => $_GET['nome']      ?? null,
            'categoria' => $_GET['categoria'] ?? null,
            'saldo'     => $_GET['saldo']     ?? null,
        ];

        $dados = [];
        $dados['produtos']   = $this->estoqueModel->listarProdutosEstoque(2, $filtros); // 👈 ID 2
        $dados['categorias'] = $this->estoqueModel->listarCategoriasAtivas();
        $dados['conteudo']   = 'dash/estoques/listar_republica';

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function mogi()
    {
        $filtros = [
            'status'    => $_GET['status']    ?? null,
            'nome'      => $_GET['nome']      ?? null,
            'categoria' => $_GET['categoria'] ?? null,
            'saldo'     => $_GET['saldo']     ?? null,
        ];

        $dados = [];
        $dados['produtos']   = $this->estoqueModel->listarProdutosEstoque(3, $filtros);
        $dados['categorias'] = $this->estoqueModel->listarCategoriasAtivas();
        $dados['conteudo']   = 'dash/estoques/listar_mogi';

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function movimentarRepublica()
    {
        $this->estoqueModel->movimentarEstoque([
            'id_produto' => $_POST['id_produto'],
            'id_estoque' => 2,
            'tipo'       => $_POST['tipo'], // Entrada ou Saida
            'quantidade' => $_POST['quantidade'],
            'motivo'     => $_POST['motivo']
        ]);

        $_SESSION['sucesso'] = 'Movimentação registrada!';
        header('Location: ' . BASE_URL . '/Estoques/republica');
        exit;
    }



    public function movimentarMogi()
    {
        $this->estoqueModel->movimentarEstoque([
            'id_produto' => $_POST['id_produto'],
            'id_estoque' => 3,
            'tipo'       => $_POST['tipo'], // Entrada ou Saida
            'quantidade' => $_POST['quantidade'],
            'motivo'     => $_POST['motivo']
        ]);

        $_SESSION['sucesso'] = 'Movimentação registrada!';
        header('Location: ' . BASE_URL . '/Estoques/mogi');
        exit;
    }
}
