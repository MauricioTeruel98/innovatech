<?php
/**
 * Front controller del panel de administración.
 *
 * Mapea:  /{PANEL_PATH}/{subpath}  →  admin/{subpath}.php
 *
 * El acceso directo a /backend/admin/ está bloqueado en .htaccess.
 * Cualquier URL que no coincida con PANEL_PATH recibe 404.
 */

require_once __DIR__ . '/config/config.php';

// ── Leer el URI real ───────────────────────────────────────────────────────────
$uri      = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$segment  = '/' . trim(PANEL_PATH, '/');

// Verificar que el URI contiene el segmento secreto del panel
if (!preg_match('#' . preg_quote($segment, '#') . '(?:/(.*))?$#', $uri, $m)) {
    http_response_code(404);
    exit;
}

$subpath = trim($m[1] ?? '', '/');

// ── Seguridad: prevenir path traversal ────────────────────────────────────────
if (str_contains($subpath, '..') || str_contains($subpath, "\0")) {
    http_response_code(403);
    exit;
}

// ── Resolver archivo dentro de admin/ ─────────────────────────────────────────
$adminBase = __DIR__ . '/admin/';
$candidate = $adminBase . ($subpath ?: 'index');

// Si no termina en .php, añadirlo
if (!str_ends_with($candidate, '.php')) {
    // Intentar como directorio (carpeta/index.php)
    if (is_dir($candidate)) {
        $candidate .= '/index.php';
    } else {
        $candidate .= '.php';
    }
}

// Confirmar que el archivo resuelto sigue dentro de admin/ (anti traversal)
$real = realpath($candidate);
if (!$real || !str_starts_with($real, realpath($adminBase))) {
    http_response_code(404);
    exit;
}

require $real;
