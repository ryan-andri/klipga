<?php
if (!isset($_SESSION['is_loged'])) {
    header('location:' . BASE_URL);
    exit();
}

$user_agent = md5($_SERVER['HTTP_USER_AGENT']);
$ip_addr = md5($_SERVER['REMOTE_ADDR']);
$expired = isset($_SESSION['timeout']) && (time() - $_SESSION['timeout'] > 1800);

if (($user_agent != isset($_SESSION['agent']))
    || ($ip_addr != isset($_SESSION['ip_addr'])) || $expired
) {
    session_unset();
    session_destroy();
    header('location:' . BASE_URL);
    exit();
} else {
    $_SESSION['timeout'] = time();
}
