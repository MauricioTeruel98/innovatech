<?php
/**
 * Registro de errores simple a archivo.
 * Escribe en backend/logs/app.log (bloqueado al acceso web por backend/.htaccess
 * mediante el FilesMatch de .log). No lanza excepciones: el logueo nunca debe
 * romper el flujo principal.
 */

require_once __DIR__ . '/../config/config.php';

if (!defined('LOGS_DIR')) {
    define('LOGS_DIR', dirname(__DIR__) . '/logs');
}

function log_error(string $context, string $message): void
{
    try {
        if (!is_dir(LOGS_DIR)) {
            @mkdir(LOGS_DIR, 0775, true);
        }
        $line = '[' . date('Y-m-d H:i:s') . '] [' . $context . '] '
              . str_replace(["\r", "\n"], ' ', $message) . PHP_EOL;
        @file_put_contents(LOGS_DIR . '/app.log', $line, FILE_APPEND | LOCK_EX);
    } catch (\Throwable $e) {
        // Último recurso: el log de errores de PHP. Nunca propagar.
        @error_log("[$context] $message");
    }
}
