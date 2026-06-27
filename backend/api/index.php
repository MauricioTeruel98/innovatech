<?php
/**
 * Router principal de la API pública.
 * Rutas:
 *   GET  /api/courses          → lista todos los cursos
 *   GET  /api/courses/{slug}   → devuelve un curso por su slug
 *   GET  /api/site[?site=labs] → todo el contenido administrable del sitio
 *   POST /api/contact          → recibe un mensaje del formulario de contacto
 */

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/lib/uploads.php';
require_once dirname(__DIR__) . '/lib/logger.php';

// ── CORS ─────────────────────────────────────────────────────────────────────
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, CORS_ORIGINS)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header("Access-Control-Allow-Origin: *");
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');
// El contenido es dinámico (editable desde el panel): evitar caché del navegador.
header('Cache-Control: no-store, no-cache, must-revalidate');

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

// GET /site  → todo el contenido administrable (institute | labs)
if ($method === 'GET' && $path === 'site') {
    $db   = getDB();
    $site = (($_GET['site'] ?? 'institute') === 'labs') ? 'labs' : 'institute';

    // Ajustes agrupados por sección. Las imágenes se devuelven como URL absoluta.
    $settings = [];
    $st = $db->prepare("SELECT section, setting_key, setting_value, type FROM site_settings WHERE site = ? ORDER BY section, sort_order");
    $st->execute([$site]);
    foreach ($st->fetchAll() as $r) {
        $val = $r['setting_value'];
        if ($r['type'] === 'image') {
            $val = ($val === null || $val === '') ? '' : upload_url($val);
        } elseif ($r['type'] === 'bool') {
            $val = (bool) $val;
        }
        $settings[$r['section']][$r['setting_key']] = $val;
    }

    // Testimonios (del sitio).
    $tStmt = $db->prepare("SELECT name, role, quote, rating, photo_path FROM testimonials WHERE active = 1 AND site = ? ORDER BY sort_order, id");
    $tStmt->execute([$site]);
    $testimonials = $tStmt->fetchAll();
    foreach ($testimonials as &$t) {
        $t['rating'] = (int) $t['rating'];
        $t['photo']  = upload_url($t['photo_path']);
        unset($t['photo_path']);
    }
    unset($t);

    // Menús / redes (del sitio).
    $mStmt = $db->prepare("SELECT location, label, url, target, enabled FROM menu_links WHERE site = ? ORDER BY location, sort_order, id");
    $mStmt->execute([$site]);
    $menu = [];
    foreach ($mStmt->fetchAll() as $m) {
        $m['enabled'] = (bool) $m['enabled'];
        $menu[$m['location']][] = $m;
    }

    if ($site === 'labs') {
        // Bloques agrupados por categoría.
        $bStmt = $db->prepare("SELECT category, icon, title, description, extra FROM lab_blocks WHERE active = 1 AND site = 'labs' ORDER BY sort_order, id");
        $bStmt->execute();
        $blocks = ['pillar' => [], 'solution' => [], 'process' => [], 'feature' => []];
        foreach ($bStmt->fetchAll() as $b) {
            $cat = $b['category'];
            if (!isset($blocks[$cat])) $blocks[$cat] = [];
            $blocks[$cat][] = ['icon' => $b['icon'], 'title' => $b['title'], 'description' => $b['description'], 'extra' => $b['extra']];
        }

        // Planes.
        $pStmt = $db->prepare("SELECT name, price, period, description, features, highlighted, cta_label, cta_url FROM lab_plans WHERE active = 1 AND site = 'labs' ORDER BY sort_order, id");
        $pStmt->execute();
        $plans = [];
        foreach ($pStmt->fetchAll() as $p) {
            $p['highlighted'] = (bool) $p['highlighted'];
            $p['features'] = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $p['features'] ?? ''))));
            $plans[] = $p;
        }

        echo json_encode(['data' => [
            'settings'     => $settings,
            'services'     => $blocks['pillar'],
            'solutions'    => $blocks['solution'],
            'process'      => $blocks['process'],
            'features'     => $blocks['feature'],
            'plans'        => $plans,
            'testimonials' => $testimonials,
            'menu'         => $menu,
        ]], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ── Sitio del Instituto ─────────────────────────────────────────────────────
    $team = $db->query("SELECT name, role, initials, photo_path, linkedin_url FROM team_members WHERE active = 1 ORDER BY sort_order, id")->fetchAll();
    foreach ($team as &$tm) { $tm['photo'] = upload_url($tm['photo_path']); unset($tm['photo_path']); }
    unset($tm);

    $values     = $db->query("SELECT icon, title, description FROM about_values WHERE active = 1 ORDER BY sort_order, id")->fetchAll();
    $modalities = $db->query("SELECT icon, title, description FROM course_modalities WHERE active = 1 ORDER BY sort_order, id")->fetchAll();

    echo json_encode(['data' => [
        'settings'     => $settings,
        'team'         => $team,
        'testimonials' => $testimonials,
        'values'       => $values,
        'modalities'   => $modalities,
        'menu'         => $menu,
    ]], JSON_UNESCAPED_UNICODE);
    exit;
}

// POST /contact  → mensaje del formulario de contacto
if ($method === 'POST' && $path === 'contact') {
    $db = getDB();

    $body = json_decode(file_get_contents('php://input'), true);
    if (!is_array($body)) $body = $_POST;

    // Honeypot anti-spam.
    if (!empty($body['website'])) {
        echo json_encode(['data' => ['ok' => true]], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $name    = trim((string) ($body['name'] ?? ''));
    $email   = trim((string) ($body['email'] ?? ''));
    $message = trim((string) ($body['message'] ?? ''));
    $site    = (($body['site'] ?? 'institute') === 'labs') ? 'labs' : 'institute';

    $errors = [];
    if ($name === '' || mb_strlen($name) > 150)        $errors[] = 'Nombre inválido.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))    $errors[] = 'Email inválido.';
    if ($message === '' || mb_strlen($message) > 5000) $errors[] = 'Mensaje inválido.';

    if ($errors) {
        http_response_code(422);
        echo json_encode(['error' => implode(' ', $errors)], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
    $ip = trim(explode(',', $ip)[0]);

    // Anti-spam: máximo 3 mensajes por IP cada 10 minutos.
    $check = $db->prepare("SELECT COUNT(*) FROM contact_messages WHERE ip = ? AND created_at > (NOW() - INTERVAL 10 MINUTE)");
    $check->execute([$ip]);
    if ((int) $check->fetchColumn() >= 3) {
        http_response_code(429);
        echo json_encode(['error' => 'Demasiados mensajes. Probá de nuevo en unos minutos.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 1) Guardar el mensaje (prioridad).
    try {
        $stmt = $db->prepare("INSERT INTO contact_messages (site, name, email, message, ip) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$site, $name, $email, $message, $ip]);
    } catch (\Throwable $e) {
        log_error('contact_db', 'No se pudo guardar el mensaje de ' . $email . ': ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo guardar el mensaje. Intentá de nuevo.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 2) Notificación por email (best-effort): si falla, se registra y se continúa.
    $notifyStmt = $db->prepare("SELECT setting_value FROM site_settings WHERE site = ? AND section = 'contact' AND setting_key = 'notification_email'");
    $notifyStmt->execute([$site]);
    $notify = trim((string) $notifyStmt->fetchColumn());

    if (!$notify || !filter_var($notify, FILTER_VALIDATE_EMAIL)) {
        log_error('contact_mail', "[$site] Email de notificación no configurado o inválido ('$notify'); el mensaje de $email se guardó igualmente.");
    } else {
        $subject = '=?UTF-8?B?' . base64_encode("[$site] Nuevo mensaje de contacto") . '?=';
        $bodyTxt = "Sitio: $site\nNombre: $name\nEmail: $email\nIP: $ip\n\nMensaje:\n$message\n";
        $host    = preg_replace('/[^a-zA-Z0-9.\-]/', '', $_SERVER['HTTP_HOST'] ?? 'institutoinnovatech.com');
        $headers = "From: no-reply@$host\r\n"
                 . 'Reply-To: ' . str_replace(["\r", "\n"], '', $email) . "\r\n"
                 . "Content-Type: text/plain; charset=utf-8\r\n";
        $mailOk = false;
        try {
            $mailOk = @mail($notify, $subject, $bodyTxt, $headers);
        } catch (\Throwable $e) {
            log_error('contact_mail', "Excepción al enviar email a $notify: " . $e->getMessage());
        }
        if (!$mailOk) {
            log_error('contact_mail', "No se pudo enviar la notificación a $notify (el mensaje de $email quedó guardado en la base de datos).");
        }
    }

    // 3) Respuesta de éxito.
    $msgStmt = $db->prepare("SELECT setting_value FROM site_settings WHERE site = ? AND section = 'contact' AND setting_key = 'success_message'");
    $msgStmt->execute([$site]);
    $okMsg = trim((string) $msgStmt->fetchColumn()) ?: '¡Gracias por contactarnos!';

    echo json_encode(['data' => ['ok' => true, 'message' => $okMsg]], JSON_UNESCAPED_UNICODE);
    exit;
}

// 404 por defecto
http_response_code(404);
echo json_encode(['error' => 'Ruta no encontrada'], JSON_UNESCAPED_UNICODE);
