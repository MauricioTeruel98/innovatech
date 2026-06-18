<?php
require_once dirname(__DIR__) . '/config/config.php';

ini_set('session.use_only_cookies', '1');
session_name(SESSION_NAME);
if (session_status() === PHP_SESSION_NONE) session_start();

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();

header('Location: ' . PANEL_URL . '/login.php');
exit;
