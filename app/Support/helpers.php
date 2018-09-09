<?php

if (!function_exists('classActivePath')) {
    function classActivePath($path)
    {
        $path = explode('.', $path);
        $segment = 1;
        foreach($path as $p) {
            if((request()->segment($segment) == $p) == false) {
                return '';
            }
            $segment++;
        }
        return ' active';
    }
}

if (!function_exists('domDocumentErrorHandler')) {
    function domDocumentErrorHandler($number, $error)
    {
        if (preg_match("/^DOMDocument::load\([^:]+: (.+)$/", $error, $m) === 1) {
            throw new \Exception($m[1]);
        }
    }
}
