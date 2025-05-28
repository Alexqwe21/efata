<?php
date_default_timezone_set('America/Sao_Paulo');

// Definir URL  da aplicação 
// define("BASE_URL" ,"https://kioficina.smpsistema.com.br/");
define("BASE_URL" ,"https://culturaefata.com.br/");


// Configuração do Data Base
define("DB_HOST", "culturaefata.com.br");
define("DB_NAME", "u230564252_culturaefata");
define("DB_USER", "u230564252_culturaefata");
define("DB_PASS", "21566647aA#");


define('HOTS_EMAIL', 'smtp.hostinger.com');
define('PORT_EMAIL', 465);
define('USER_EMAIL', 'culturaefata@culturaefata.com.br');
define('PASS_EMAIL', 'Culturaefata1@');




spl_autoload_register(function ($classe) {
    // Caminho para Controllers
    if (file_exists('app/controllers/' . $classe . '.php')) {
        require_once 'app/controllers/' . $classe . '.php';
    }

    // Caminho para Models
    if (file_exists('app/models/' . $classe . '.php')) {
        require_once 'app/models/' . $classe . '.php';
    }

    // Caminho para Core
    if (file_exists('core/' . $classe . '.php')) {
        require_once 'core/' . $classe . '.php';
    }
    
});
