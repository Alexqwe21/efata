<?php

class LoginController extends Controller
{

    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';
        $dados['cultura_efata'] = 'ola cultura efata';





        $this->carregarViews('login', $dados);

        var_dump($dados);
        exit;
    }
}
