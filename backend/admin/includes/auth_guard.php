<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/security/csrf.php';

// ── Configuración segura de sesión ────────────────────────────────────────────
// Debe aplicarse ANTES de session_start()
ini_set('session.use_only_cookies',  '1');  // Sin session IDs en URL
ini_set('session.use_strict_mode',   '1');  // Rechaza IDs de sesión no iniciados por el servidor
ini_set('session.cookie_httponly',   '1');  // JS no puede leer la cookie
ini_set('session.cookie_samesite',   'Strict'); // Previene CSRF cross-site
ini_set('session.gc_maxlifetime',    '3600');   // Sesión expira en 1 hora
ini_set('session.cookie_lifetime',   '0');      // Cookie solo en esta sesión de browser

// Cookie segura solo si la conexión es HTTPS
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? 80) == 443);
ini_set('session.cookie_secure', $isHttps ? '1' : '0');

session_name(SESSION_NAME);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Cabeceras de seguridad HTTP ───────────────────────────────────────────────
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
if ($isHttps) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

// ── Verificar sesión activa ───────────────────────────────────────────────────
if (empty($_SESSION['admin_id'])) {
    header('Location: ' . PANEL_URL . '/login.php');
    exit;
}

// ── Regenerar ID de sesión periódicamente (previene session fixation) ─────────
if (empty($_SESSION['_last_regen']) || time() - $_SESSION['_last_regen'] > 300) {
    session_regenerate_id(true);
    $_SESSION['_last_regen'] = time();
}
