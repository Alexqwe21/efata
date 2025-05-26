<?php

class FichaDeCadastroController extends Controller
{

    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';



        //var_dump($dados);

        $this ->carregarViews('ficha_de_cadastro', $dados);
    }
}
