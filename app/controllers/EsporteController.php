<?php

class EsporteController extends Controller
{

    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo';
        $dados['nome'] = 'Alex';



        //var_dump($dados);

        $this ->carregarViews('esporte', $dados);
    }
}
