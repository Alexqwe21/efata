<?php
// =======================
// FUNÇÕES AUXILIARES
// =======================

// Recupera o IP real do usuário
function getClientIP() {
    $keys = [
        'HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR','HTTP_FORWARDED','REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }
    return '0.0.0.0';
}

// Registrar arquivos/pastas bloqueadas ou suspeitas
function logMalware($file, $reason) {
    $ip = getClientIP();
    $line = date('Y-m-d H:i:s') . " | IP: {$ip} | Arquivo/Pasta: {$file} | Motivo: {$reason}\n";
    file_put_contents(__DIR__ . '/malware_scan.log', $line, FILE_APPEND);
}

// Registrar acessos bloqueados por país
function logBlock($ip, $country = 'Unknown', $reason) {
    $line = date('Y-m-d H:i:s') . " | IP: {$ip} | País: {$country} | Motivo: {$reason}\n";
    file_put_contents(__DIR__ . '/access_block.log', $line, FILE_APPEND);
}

// =======================
// BLOQUEIO PARA APENAS BRASIL
// =======================

$ip = getClientIP();
$cacheFile = __DIR__ . '/geo_cache_' . md5($ip) . '.json';
$geoData = null;

// Cache de 1 hora para reduzir requisições externas
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
    $geoData = json_decode(file_get_contents($cacheFile), true);
} else {
    $ctx = stream_context_create(['http' => ['timeout' => 2]]);
    $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=countryCode,status,message", false, $ctx);
    if ($json) {
        $geoData = json_decode($json, true);
        if ($geoData && $geoData['status'] === 'success') {
            file_put_contents($cacheFile, $json);
        }
    }
}

// Bloqueia se não for do Brasil
if ($geoData && $geoData['status'] === 'success') {
    if ($geoData['countryCode'] !== 'BR') {
        logBlock($ip, $geoData['countryCode'], 'Acesso fora do Brasil');
        header('HTTP/1.1 403 Forbidden');
        exit('Acesso permitido apenas para usuários do Brasil.');
    }
} else {
    logBlock($ip, $geoData['countryCode'] ?? 'Desconhecido', 'Falha ao obter localização');
    header('HTTP/1.1 403 Forbidden');
    exit('Acesso negado.');
}

// =======================
// SCANNER DE MALWARE (IGNORANDO VENDOR E DOMPDF)
// =======================

function scanProject($dir) {
    $suspiciousPatterns = [
        '/eval\s*\(/i',
        '/base64_decode\s*\(/i',
        '/shell_exec\s*\(/i',
        '/system\s*\(/i',
        '/exec\s*\(/i',
        '/passthru\s*\(/i',
        '/preg_replace\s*\(\s*[\'"].*\/e[\'"]/i',
    ];

    $ignoredDirs = ['vendor', 'vendor/dompdf', 'app/libraries', 'node_modules'];

    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($rii as $file) {
        foreach ($ignoredDirs as $ignored) {
            if (strpos($file->getPathname(), DIRECTORY_SEPARATOR . $ignored . DIRECTORY_SEPARATOR) !== false) {
                continue 2;
            }
        }

        if ($file->isDir()) continue;
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

        $content = file_get_contents($file->getPathname());
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                logMalware($file->getPathname(), 'Código suspeito detectado');
                exit('Malware detectado. Execução bloqueada.');
            }
        }
    }
}

// Executa o scanner
scanProject(__DIR__);

// =======================
// VALIDAÇÃO DE UPLOAD DE IMAGEM
// =======================

function validateImageUpload($filePath) {
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    if ($ext === 'php') {
        logMalware($filePath, 'Tentativa de upload de arquivo PHP');
        exit('Upload bloqueado: arquivo não permitido.');
    }

    $allowedMime = ['image/jpeg','image/png','image/gif','image/svg+xml'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $filePath);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMime)) {
        logMalware($filePath, 'Upload de arquivo não permitido');
        exit('Upload bloqueado: tipo de arquivo inválido.');
    }

    if ($mime === 'image/svg+xml') {
        $content = file_get_contents($filePath);
        $content = preg_replace('/<script.*?<\/script>/is', '', $content);
        file_put_contents($filePath, $content);
    }

    return true;
}

// =======================
// CONFIGURAÇÕES DO SISTEMA
// =======================

date_default_timezone_set('America/Sao_Paulo');

define('BASE_URL', 'https://culturaefata.com.br/');
define('DB_HOST', 'culturaefata.com.br');
define('DB_NAME', 'u230564252_CulturaEfataVi');
define('DB_USER', 'u230564252_CulturaEfataVi');
define('DB_PASS', 'EfataVIbes!@#Cultura1');

define('HOTS_EMAIL','smtp.hostinger.com');
define('PORT_EMAIL', 465);
define('USER_EMAIL','culturaefata@culturaefata.com.br');
define('PASS_EMAIL','Culturaefata1@');

// =======================
// AUTOLOAD DO SISTEMA
// =======================

spl_autoload_register(function($c){
    foreach (['app/controllers/','app/models/','core/'] as $dir) {
        $path = "{$dir}{$c}.php";
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// =======================
// AUTOLOAD DO COMPOSER (DOMPDF, ETC)
// =======================

$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    exit('Erro: Autoload do Composer não encontrado. Instale as dependências via Composer.');
}
