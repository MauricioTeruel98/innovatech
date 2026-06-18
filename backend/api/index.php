<?php
/**
 * Router principal de la API pública.
 * Rutas:
 *   GET /api/courses          → lista todos los cursos
 *   GET /api/courses/{slug}   → devuelve un curso por su slug
 */

require_once dirname(__DIR__) . '/config/database.php';

// ── CORS ─────────────────────────────────────────────────────────────────────
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, CORS_ORIGINS)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: *");
}
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ── Routing ───────────────────────────────────────────────────────────────────
$path   = trim($_GET['path'] ?? '', '/');
$method = $_SERVER['REQUEST_METHOD'];

// GET /courses
if ($method === 'GET' && $path === 'courses') {
    $courses = getDB()
        ->query("SELECT * FROM courses ORDER BY popular DESC, created_at DESC")
        ->fetchAll();

    foreach ($courses as &$c) {
        $c['syllabus'] = json_decode($c['syllabus'] ?? '[]', true);
        $c['popular']  = (bool) $c['popular'];
    }
    echo json_encode(['data' => $courses], JSON_UNESCAPED_UNICODE);
    exit;
}

// GET /courses/{slug}
if ($method === 'GET' && str_starts_with($path, 'courses/')) {
    $slug = substr($path, strlen('courses/'));
    $stmt = getDB()->prepare("SELECT * FROM courses WHERE slug = ?");
    $stmt->execute([$slug]);
    $course = $stmt->fetch();

    if (!$course) {
        http_response_code(404);
        echo json_encode(['error' => 'Curso no encontrado'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $course['syllabus'] = json_decode($course['syllabus'] ?? '[]', true);
    $course['popular']  = (bool) $course['popular'];
    echo json_encode(['data' => $course], JSON_UNESCAPED_UNICODE);
    exit;
}

// 404 por defecto
http_response_code(404);
echo json_encode(['error' => 'Ruta no encontrada'], JSON_UNESCAPED_UNICODE);
