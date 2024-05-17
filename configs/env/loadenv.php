<?php

if (!file_exists(BASE_PATH . '/configs/env/env.php')) {
    echo "File environment not found!";
    exit();
}

require_once(BASE_PATH . '/configs/env/env.php');

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}
