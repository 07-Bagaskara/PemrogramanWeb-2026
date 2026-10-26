<?php
// Membungkus output data yang berasal dari input pengguna sebelum
// dicetak ke HTML, untuk mencegah XSS (Cross-Site Scripting).
// ENT_QUOTES: tanda kutip ' dan " ikut di-escape, jadi aman dipakai
// juga di dalam atribut HTML seperti value="...".
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
