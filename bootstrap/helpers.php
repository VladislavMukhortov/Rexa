<?php

use Illuminate\Support\Str;


if (!function_exists('phone_format_convert')) {
    function phone_format_convert($inputPhone)
    {
        $output = preg_replace('/[^0-9]/', '', $inputPhone);
        if (substr($output, 0, 1) == "8") $output = '7' . substr($output, 1);
        if (strlen($output) == 10) $output = '7' . $output;
        return $output;
    }
}

if (!function_exists('email_or_phone')) {
    function email_or_phone($input)
    {
        return Str::contains($input, '@') ? 'email' : 'phone';
    }
}


if (!function_exists('type_of_login')) {
    function type_of_login($login)
    {
        return Str::startsWith($login, ['@', '#'])
            ? 'telegram'
            : (Str::contains($login, '@') ? 'email' : 'phone');
    }
}

if (!function_exists('obfuscate_email')) {
    function obfuscate_email($email)
    {
        $em = explode("@", $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len = floor(strlen($name) / 2);

        return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
    }
}

if (!function_exists('obfuscate_txid')) {
    function obfuscate_txid($txid)
    {
        return substr($txid, 0, 6) . "..." . substr($txid, -6);
    }
}

if (!function_exists('sql_info')) {
    function sql_info($query)
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        info(preg_replace_callback('/\?/', function ($match) use ($sql, &$bindings) {
            return "'" . array_shift($bindings) . "'";
        }, $sql));
    }
}
if (!function_exists('rand_float')) {
    function rand_float($st_num = 0, $end_num = 1, $mul = 1000000)
    {
        if ($st_num > $end_num) return false;
        return mt_rand($st_num * $mul, $end_num * $mul) / $mul;
    }
}
