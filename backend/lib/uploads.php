<?php
/**
 * Helpers para subida y borrado de imágenes administrables.
 *
 * Convención de almacenamiento:
 *   - En la BD se guarda SIEMPRE una ruta relativa a la carpeta de uploads,
 *     p. ej. "team/abc123.jpg" o "hero/portada.webp".
 *   - upload_url() convierte esa ruta relativa en una URL pública absoluta
 *     (UPLOADS_URL/<ruta>) que funciona en producción (Apache), Herd (nginx)
 *     y el dev server de Vite.
 */

require_once __DIR__ . '/../config/config.php';

const UPLOAD_ALLOWED = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/gif'  => 'gif',
    'image/svg+xml' => 'svg',
];

const UPLOAD_MAX_BYTES = 5 * 1024 * 1024; // 5 MB

/**
 * Devuelve la URL pública absoluta de una imagen subida.
 * Acepta rutas relativas ("team/x.jpg") y devuelve "" para valores vacíos.
 * Si ya viene una URL absoluta (http...) o una ruta absoluta (/...), se respeta.
 */
function upload_url(?string $relative): string
{
    $relative = trim((string) $relative);
    if ($relative === '') return '';
    if (preg_match('#^(https?:)?//#', $relative) || str_starts_with($relative, '/')) {
        return $relative;
    }
    return UPLOADS_URL . '/' . ltrim($relative, '/');
}

/**
 * Procesa un archivo subido (clave de $_FILES) y lo guarda en UPLOADS_DIR/<subdir>.
 * Devuelve la ruta relativa guardada (ej. "team/abc.jpg") o null si no se subió nada.
 * Lanza RuntimeException si el archivo es inválido.
 */
function save_uploaded_image(string $field, string $subdir = ''): ?string
{
    if (empty($_FILES[$field]) || ($_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null; // no se envió archivo
    }

    $file = $_FILES[$field];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Error al subir el archivo (código ' . $file['error'] . ').');
    }
    if ($file['size'] > UPLOAD_MAX_BYTES) {
        throw new RuntimeException('La imagen supera el tamaño máximo permitido (5 MB).');
    }

    // Detectar el tipo MIME real (no confiar en la extensión del cliente).
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!isset(UPLOAD_ALLOWED[$mime])) {
        throw new RuntimeException('Formato no permitido. Usá JPG, PNG, WEBP, GIF o SVG.');
    }
    $ext = UPLOAD_ALLOWED[$mime];

    // Carpeta destino
    $subdir = trim($subdir, '/');
    $destDir = UPLOADS_DIR . ($subdir ? '/' . $subdir : '');
    if (!is_dir($destDir) && !mkdir($destDir, 0775, true) && !is_dir($destDir)) {
        throw new RuntimeException('No se pudo crear la carpeta de destino.');
    }

    // Nombre único y seguro
    $base     = bin2hex(random_bytes(8));
    $filename = $base . '.' . $ext;
    $destPath = $destDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new RuntimeException('No se pudo guardar el archivo subido.');
    }

    return ($subdir ? $subdir . '/' : '') . $filename;
}

/**
 * Borra del disco una imagen subida (ruta relativa). Silencioso si no existe.
 */
function delete_upload(?string $relative): void
{
    $relative = trim((string) $relative);
    if ($relative === '') return;
    // Solo borrar dentro de UPLOADS_DIR (anti path traversal).
    $path = realpath(UPLOADS_DIR . '/' . $relative);
    $base = realpath(UPLOADS_DIR);
    if ($path && $base && str_starts_with($path, $base) && is_file($path)) {
        @unlink($path);
    }
}
