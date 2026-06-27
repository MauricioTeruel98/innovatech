<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once dirname(__DIR__) . '/lib/site_context.php';

$to = $_GET['to'] ?? '';
if (isset(admin_sites()[$to])) {
    set_current_site($to);
}

header('Location: ' . PANEL_URL . '/index.php');
exit;
