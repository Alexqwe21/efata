<?php
// app/models/BlogMidia.php
// Ajudante das mídias do blog (não é um model de banco):
//   - videoEmbed():   entende links do YouTube/Vimeo e devolve o endereço seguro do player
//   - salvarImagem(): valida e grava uma imagem (e reduz se for muito grande)
//   - apagar():       remove um arquivo, só se estiver dentro de uploads/blog/

class BlogMidia
{
    const MAX_BYTES  = 3145728;   // 3 MB por imagem
    const MAX_LADO   = 1600;      // largura/altura máxima gravada (px)
    const MAX_THUMB  = 480;       // miniatura da galeria (px)
    const MAX_PIXELS = 36000000;  // recusa imagens gigantes (evita estourar a memória do servidor)

    // Só para testes automáticos: permite gravar arquivos que não vieram de um upload HTTP
    public static $modoTeste = false;

    // ---------------------------------------------------------------
    // VÍDEO
    // ---------------------------------------------------------------

    // Aceita links do YouTube e do Vimeo. Devolve:
    //   ['provedor' => 'youtube', 'id' => '...', 'url' => link limpo, 'embed' => endereço do player]
    // ou null se o link não for aceito.
    public static function videoEmbed($url)
    {
        $url = trim((string) $url);

        if ($url === '' || strlen($url) > 255) {
            return null;
        }

        if (!preg_match('~^https?://~i', $url)) {
            return null;
        }

        $partes = parse_url($url);

        if (empty($partes['host'])) {
            return null;
        }

        $host    = strtolower($partes['host']);
        $host    = preg_replace('/^(www\.|m\.)/', '', $host);
        $caminho = $partes['path'] ?? '';
        parse_str($partes['query'] ?? '', $query);

        // ---- YouTube ----
        if (in_array($host, ['youtube.com', 'youtube-nocookie.com'], true)) {
            $id = null;

            if (!empty($query['v']) && $caminho === '/watch') {
                $id = $query['v'];
            } elseif (preg_match('~^/(embed|shorts|live|v)/([A-Za-z0-9_-]{11})(?:[/?]|$)~', $caminho, $m)) {
                $id = $m[2];
            }

            return self::montarYoutube($id);
        }

        if ($host === 'youtu.be') {
            if (preg_match('~^/([A-Za-z0-9_-]{11})(?:[/?]|$)~', $caminho, $m)) {
                return self::montarYoutube($m[1]);
            }
            return null;
        }

        // ---- Vimeo ----
        if ($host === 'vimeo.com' || $host === 'player.vimeo.com') {
            if (preg_match('~^/(?:video/)?(\d{6,12})(?:[/?]|$)~', $caminho, $m)) {
                return [
                    'provedor' => 'vimeo',
                    'id'       => $m[1],
                    'url'      => 'https://vimeo.com/' . $m[1],
                    'embed'    => 'https://player.vimeo.com/video/' . $m[1],
                ];
            }
        }

        return null;
    }

    private static function montarYoutube($id)
    {
        if (!is_string($id) || !preg_match('/^[A-Za-z0-9_-]{11}$/', $id)) {
            return null;
        }

        return [
            'provedor' => 'youtube',
            'id'       => $id,
            'url'      => 'https://www.youtube.com/watch?v=' . $id,
            'embed'    => 'https://www.youtube-nocookie.com/embed/' . $id . '?rel=0',
        ];
    }

    // ---------------------------------------------------------------
    // IMAGENS
    // ---------------------------------------------------------------

    // Endereço da miniatura de uma imagem da galeria (t_ + nome do arquivo).
    // Se a miniatura não existir, usa a própria imagem.
    public static function miniatura($arquivo)
    {
        $thumb = dirname($arquivo) . '/t_' . basename($arquivo);

        return is_file($thumb) ? $thumb : $arquivo;
    }

    // Imagem que o editor do post pode exibir: só arquivos de uploads/blog/
    public static function caminhoPublicoValido($src)
    {
        return (bool) preg_match('~^/uploads/blog/(?:[A-Za-z0-9_-]+/)?[A-Za-z0-9_.-]+\.(?:jpe?g|png|webp|gif)$~i', (string) $src)
            && strpos($src, '..') === false;
    }

    // Grava uma imagem enviada. $arquivo é uma entrada do $_FILES (um único arquivo).
    // $pasta: 'uploads/blog/conteudo/', $prefixo: 'c_'. $miniatura: também cria t_arquivo.
    // Retorna ['erro' => texto|null, 'arquivo' => caminho|null]
    public static function salvarImagem(array $f, $pasta, $prefixo, $miniatura = false)
    {
        $erro = function ($msg) {
            return ['erro' => $msg, 'arquivo' => null];
        };

        $nomeOriginal = isset($f['name']) ? basename((string) $f['name']) : 'imagem';

        if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $limite = in_array($f['error'] ?? 0, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true);
            return $erro($nomeOriginal . ': ' . ($limite ? 'a imagem é maior que o limite do servidor.' : 'não foi possível enviar.'));
        }

        if ($f['size'] > self::MAX_BYTES) {
            return $erro($nomeOriginal . ': a imagem deve ter no máximo 3 MB.');
        }

        $tipos = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            'image/gif'  => 'gif',
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);

        $info = @getimagesize($f['tmp_name']);

        if (!isset($tipos[$mime]) || !$info) {
            return $erro($nomeOriginal . ': envie uma imagem JPG, PNG, WEBP ou GIF.');
        }

        if ($info[0] * $info[1] > self::MAX_PIXELS) {
            return $erro($nomeOriginal . ': a imagem tem dimensões grandes demais. Reduza e envie de novo.');
        }

        $pasta = rtrim($pasta, '/') . '/';

        if (!is_dir($pasta) && !@mkdir($pasta, 0755, true)) {
            return $erro('Não foi possível criar a pasta de imagens no servidor.');
        }

        $nome    = $prefixo . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $tipos[$mime];
        $destino = $pasta . $nome;

        $precisaReduzir = max($info[0], $info[1]) > self::MAX_LADO;

        // Reduz só quando passa do limite (assim a orientação da foto do celular é preservada nas demais)
        if ($precisaReduzir && $mime !== 'image/gif' && self::gdDisponivel()) {
            if (!self::redimensionar($f['tmp_name'], $destino, $mime, self::MAX_LADO)) {
                return $erro($nomeOriginal . ': não foi possível processar a imagem.');
            }
        } else {
            if (!self::mover($f['tmp_name'], $destino)) {
                return $erro('Não foi possível salvar a imagem no servidor.');
            }
        }

        if ($miniatura && $mime !== 'image/gif' && self::gdDisponivel()) {
            self::redimensionar($destino, $pasta . 't_' . $nome, $mime, self::MAX_THUMB);
        }

        return ['erro' => null, 'arquivo' => $destino];
    }

    // Só apaga arquivos dentro de uploads/blog/ (e a miniatura t_ junto, se existir)
    public static function apagar($caminho)
    {
        if (!$caminho || strpos($caminho, 'uploads/blog/') !== 0 || strpos($caminho, '..') !== false) {
            return;
        }

        if (is_file($caminho)) {
            @unlink($caminho);
        }

        $thumb = dirname($caminho) . '/t_' . basename($caminho);
        if (is_file($thumb)) {
            @unlink($thumb);
        }
    }

    // Apaga as imagens que foram inseridas no texto de um post (uploads/blog/conteudo/...)
    public static function apagarImagensDoConteudo($html)
    {
        if (preg_match_all('~/(uploads/blog/conteudo/[A-Za-z0-9_.-]+\.(?:jpe?g|png|webp|gif))~i', (string) $html, $m)) {
            foreach (array_unique($m[1]) as $caminho) {
                self::apagar($caminho);
            }
        }
    }

    // ---------------------------------------------------------------
    // internos
    // ---------------------------------------------------------------

    private static function gdDisponivel()
    {
        return extension_loaded('gd') && function_exists('imagecreatetruecolor');
    }

    private static function mover($origem, $destino)
    {
        if (self::$modoTeste) {
            return copy($origem, $destino);
        }

        return move_uploaded_file($origem, $destino);
    }

    // Lê $origem, reduz para no máximo $max px no maior lado e grava em $destino
    private static function redimensionar($origem, $destino, $mime, $max)
    {
        switch ($mime) {
            case 'image/jpeg':
                $img = @imagecreatefromjpeg($origem);
                break;
            case 'image/png':
                $img = @imagecreatefrompng($origem);
                break;
            case 'image/webp':
                $img = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($origem) : false;
                break;
            default:
                $img = false;
        }

        if (!$img) {
            // sem suporte no servidor: se for a imagem original, mantém como está
            return $origem !== $destino && copy($origem, $destino);
        }

        // JPEG de celular: aplica a rotação indicada nos metadados antes de reduzir
        if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
            $exif = @exif_read_data($origem);
            $giro = [3 => 180, 6 => -90, 8 => 90][$exif['Orientation'] ?? 0] ?? 0;
            if ($giro !== 0) {
                $girada = imagerotate($img, $giro, 0);
                if ($girada) {
                    imagedestroy($img);
                    $img = $girada;
                }
            }
        }

        $larg = imagesx($img);
        $alt  = imagesy($img);

        if (max($larg, $alt) > $max) {
            $escala = $max / max($larg, $alt);
            $nl = max(1, (int) round($larg * $escala));
            $na = max(1, (int) round($alt * $escala));

            $novo = imagecreatetruecolor($nl, $na);

            if ($mime !== 'image/jpeg') {
                imagealphablending($novo, false);
                imagesavealpha($novo, true);
            }

            imagecopyresampled($novo, $img, 0, 0, 0, 0, $nl, $na, $larg, $alt);
            imagedestroy($img);
            $img = $novo;
        }

        switch ($mime) {
            case 'image/jpeg':
                $ok = imagejpeg($img, $destino, 85);
                break;
            case 'image/png':
                imagesavealpha($img, true);
                $ok = imagepng($img, $destino, 6);
                break;
            default:
                $ok = function_exists('imagewebp') ? imagewebp($img, $destino, 85) : false;
        }

        imagedestroy($img);

        return (bool) $ok;
    }
}
