<?php
// CARREGA MINHAS CONFIGURAÇÕES INICIAS 
 require_once('config/config.php');
 

//    echo "Core.php carregado com sucesso!<br>";
// NUCLEO DA APLICÃO

$nucleo = new Core();
$nucleo->executar();