<?php
// app/models/Slug.php
// Helper para gerar slugs amigáveis (sem acentos, minúsculos, separados por hífen)

class Slug
{
    public static function gerar($texto, $max = 200)
    {
        $mapa = [
            'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];

        $s = mb_strtolower(trim($texto), 'UTF-8');
        $s = strtr($s, $mapa);
        $s = preg_replace('/[^a-z0-9]+/', '-', $s);
        $s = trim($s, '-');
        $s = substr($s, 0, $max);

        return trim($s, '-');
    }
}