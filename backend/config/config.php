<?php

// Cargar variables de entorno desde .env
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'innovatech');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

define('SESSION_NAME', $_ENV['ADMIN_SESSION_NAME'] ?? 'innovatech_admin');
define('APP_URL',      rtrim($_ENV['APP_URL'] ?? 'http://localhost/innova-backend', '/'));

// ── Ruta secreta del panel (configurable en .env) ─────────────────────────────
// Debe ser algo no obvio: evitar admin, panel, dashboard, login, etc.
// Ejemplo: gestion-x7k2, controlpanel-b9, cms-privado, etc.
define('PANEL_PATH', trim($_ENV['PANEL_PATH'] ?? 'gestion', '/'));
define('PANEL_URL',  APP_URL . '/' . PANEL_PATH);

define('MIGRATIONS_DIR', dirname(__DIR__) . '/migrations');

// ── Subida de archivos (imágenes administrables) ───────────────────────────────
// Carpeta física donde se guardan las imágenes subidas desde el panel.
// Vive dentro de backend/ para que sea servible por Apache (prod) y por el
// LocalValetDriver (Herd local). NO usar dist/ ni public/ (son del build de Vite).
define('UPLOADS_DIR', dirname(__DIR__) . '/uploads');
// URL pública absoluta de esa carpeta (se sirve en /backend/uploads/<archivo>).
define('UPLOADS_URL', APP_URL . '/uploads');

// ── CORS para la API pública ───────────────────────────────────────────────────
$_corsExtra = $_ENV['CORS_ORIGIN'] ?? '';
define('CORS_ORIGINS', array_values(array_filter([
    'http://localhost:8080',
    'http://localhost:3000',
    'http://localhost:5173',
    $_corsExtra ?: null,
])));
