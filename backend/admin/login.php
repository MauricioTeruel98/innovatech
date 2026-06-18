<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/security/csrf.php';
require_once dirname(__DIR__) . '/security/rate_limit.php';

// ── Sesión segura ─────────────────────────────────────────────────────────────
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode',  '1');
ini_set('session.cookie_httponly',  '1');
ini_set('session.cookie_samesite',  'Strict');
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? 80) == 443);
ini_set('session.cookie_secure', $isHttps ? '1' : '0');

session_name(SESSION_NAME);
if (session_status() === PHP_SESSION_NONE) session_start();

// ── Cabeceras de seguridad ────────────────────────────────────────────────────
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Ya autenticado → redirigir al dashboard
if (!empty($_SESSION['admin_id'])) {
    header('Location: ' . PANEL_URL . '/index.php');
    exit;
}

$error      = '';
$isLocked   = false;
$waitSecs   = 0;
$db         = getDB();
$clientIp   = get_client_ip();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. CSRF
    csrf_verify();

    // 2. Honeypot anti-bot (campo oculto que los bots suelen rellenar)
    if (!empty($_POST['_hp'])) {
        // Simular error genérico sin revelar que es un honeypot
        sleep(2);
        $error = 'Usuario o contraseña incorrectos.';
    }
    // 3. Rate limiting: comprobar bloqueo por IP
    elseif (is_rate_limited($db, $clientIp)) {
        $isLocked = true;
        $waitSecs = lockout_remaining($db, $clientIp);
        $mins     = ceil($waitSecs / 60);
        $error    = "Demasiados intentos fallidos. Intentá de nuevo en {$mins} minuto(s).";
    }
    else {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username && $password) {
            $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                record_attempt($db, $clientIp, true);
                session_regenerate_id(true);
                $_SESSION['admin_id']       = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['_last_regen']    = time();
                header('Location: ' . PANEL_URL . '/index.php');
                exit;
            }
        }

        record_attempt($db, $clientIp, false);

        // Comprobar si acabamos de bloquearnos con este intento
        if (is_rate_limited($db, $clientIp)) {
            $isLocked = true;
            $waitSecs = lockout_remaining($db, $clientIp);
            $mins     = ceil($waitSecs / 60);
            $error    = "Cuenta bloqueada por demasiados intentos. Esperá {$mins} minuto(s).";
        } else {
            // Contar intentos restantes antes del bloqueo
            $stmt2 = $db->prepare(
                "SELECT COUNT(*) FROM login_attempts
                 WHERE ip_address = ? AND success = 0
                   AND attempted_at >= DATE_SUB(NOW(), INTERVAL 900 SECOND)"
            );
            $stmt2->execute([$clientIp]);
            $failCount = (int) $stmt2->fetchColumn();
            $remaining = max(0, 5 - $failCount);
            $error = $remaining > 0
                ? "Credenciales incorrectas. Te quedan {$remaining} intento(s) antes del bloqueo."
                : 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso — Innovatech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #050e1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d8eaf5;
        }
        .login-wrap { width: 100%; max-width: 420px; padding: 24px; }
        .login-card {
            background: #0c2035;
            border: 1px solid #1a3a55;
            border-radius: 16px;
            padding: 40px 36px;
        }
        .login-logo { text-align: center; margin-bottom: 32px; }
        .dot {
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            background: linear-gradient(135deg, #005282, #0d8070);
            margin-right: 4px;
            vertical-align: middle;
        }
        .login-logo h1 { font-size: 1.5rem; font-weight: 700; color: #fff; display: inline; }
        .login-logo p  { margin-top: 6px; font-size: 0.78rem; color: #5d8aaa; text-transform: uppercase; letter-spacing: 0.09em; }

        label { display: block; font-size: 0.82rem; font-weight: 500; color: #a8c8e0; margin-bottom: 6px; }
        input {
            width: 100%;
            background: #112844;
            border: 1px solid #1a3a55;
            border-radius: 8px;
            color: #d8eaf5;
            padding: 10px 14px;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus { border-color: #005282; box-shadow: 0 0 0 3px rgba(0,82,130,0.25); }
        input::placeholder { color: #3a5a75; }
        .form-group { margin-bottom: 20px; }

        button {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #005282, #0d8070);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
            margin-top: 4px;
        }
        button:hover:not(:disabled) { opacity: 0.88; transform: translateY(-1px); }
        button:disabled { opacity: 0.5; cursor: not-allowed; }

        .error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.28);
            color: #f87171;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.83rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .error-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

        .hp-field { position: absolute; left: -9999px; top: -9999px; }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <span class="dot"></span><h1>InnovaTech</h1>
            <p>Área restringida</p>
        </div>

        <?php if ($error): ?>
            <div class="error">
                <span class="error-icon">⚠</span>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <?= csrf_field() ?>
            <!-- Honeypot: los bots rellenan campos ocultos; los humanos no -->
            <input class="hp-field" type="text" name="_hp" tabindex="-1" autocomplete="off">

            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       placeholder="usuario" autocomplete="username"
                       <?= $isLocked ? 'disabled' : '' ?> required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       placeholder="••••••••" autocomplete="current-password"
                       <?= $isLocked ? 'disabled' : '' ?> required>
            </div>
            <button type="submit" <?= $isLocked ? 'disabled' : '' ?>>
                <?= $isLocked ? "Bloqueado ({$waitSecs}s)" : 'Iniciar sesión' ?>
            </button>
        </form>
    </div>
</div>

<?php if ($isLocked && $waitSecs > 0): ?>
<script>
(function() {
    let secs = <?= $waitSecs ?>;
    const btn = document.querySelector('button');
    const tick = setInterval(() => {
        secs--;
        if (secs <= 0) {
            clearInterval(tick);
            location.reload();
        } else {
            btn.textContent = 'Bloqueado (' + secs + 's)';
        }
    }, 1000);
})();
</script>
<?php endif; ?>
</body>
</html>
