<?php

if (!function_exists('singkatJudul')) {
    function singkatJudul($judul) {
        $words = explode(' ', $judul);
        $singkatan = '';
        foreach ($words as $word) {
            $singkatan .= strtoupper($word[0]);
        }
        return $singkatan;
    }
}
