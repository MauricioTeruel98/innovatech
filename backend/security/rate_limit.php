<?php

/**
 * Devuelve la IP real del cliente (considera proxies de Hostinger).
 */
function get_client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        if (filter_var($forwarded, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            $ip = $forwarded;
        }
    }
    return $ip;
}

/**
 * Comprueba si la IP superó el límite de intentos.
 * @param  int $maxAttempts  Máximo de fallos permitidos (default 5)
 * @param  int $windowSecs   Ventana de tiempo en segundos (default 900 = 15 min)
 */
function is_rate_limited(PDO $db, string $ip, int $maxAttempts = 5, int $windowSecs = 900): bool
{
    // Limpiar intentos antiguos fuera de la ventana
    $db->prepare("DELETE FROM login_attempts WHERE attempted_at < DATE_SUB(NOW(), INTERVAL :w SECOND) AND success = 0")
       ->execute([':w' => $windowSecs]);

    $stmt = $db->prepare(
        "SELECT COUNT(*) FROM login_attempts
         WHERE ip_address = :ip AND success = 0
           AND attempted_at >= DATE_SUB(NOW(), INTERVAL :w SECOND)"
    );
    $stmt->execute([':ip' => $ip, ':w' => $windowSecs]);

    return (int) $stmt->fetchColumn() >= $maxAttempts;
}

/**
 * Registra un intento de login (exitoso o fallido).
 * En login exitoso, limpia los fallos previos de esa IP.
 */
function record_attempt(PDO $db, string $ip, bool $success): void
{
    $db->prepare("INSERT INTO login_attempts (ip_address, success) VALUES (:ip, :s)")
       ->execute([':ip' => $ip, ':s' => (int) $success]);

    if ($success) {
        $db->prepare("DELETE FROM login_attempts WHERE ip_address = :ip AND success = 0")
           ->execute([':ip' => $ip]);
    }
}

/**
 * Devuelve cuántos segundos restan de bloqueo para la IP.
 * Útil para mostrar al usuario cuánto debe esperar.
 */
function lockout_remaining(PDO $db, string $ip, int $windowSecs = 900): int
{
    $stmt = $db->prepare(
        "SELECT TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(MIN(attempted_at), INTERVAL :w SECOND))
         FROM login_attempts
         WHERE ip_address = :ip AND success = 0
           AND attempted_at >= DATE_SUB(NOW(), INTERVAL :w2 SECOND)"
    );
    $stmt->execute([':ip' => $ip, ':w' => $windowSecs, ':w2' => $windowSecs]);
    return max(0, (int) $stmt->fetchColumn());
}
