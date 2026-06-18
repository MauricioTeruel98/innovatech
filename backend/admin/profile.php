<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once dirname(__DIR__) . '/config/database.php';

$pageTitle  = 'Mi perfil';
$activePage = 'profile';

$db      = getDB();
$adminId = (int) $_SESSION['admin_id'];

// Cargar datos actuales
$user = $db->prepare("SELECT * FROM admin_users WHERE id = ?");
$user->execute([$adminId]);
$user = $user->fetch();

$successUser = $successPass = '';
$errorUser   = $errorPass   = '';

// ── Cambiar nombre de usuario ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'username') {
    csrf_verify();

    $newUsername = trim($_POST['new_username'] ?? '');

    if (strlen($newUsername) < 3) {
        $errorUser = 'El usuario debe tener al menos 3 caracteres.';
    } elseif (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $newUsername)) {
        $errorUser = 'Solo se permiten letras, números, guiones y puntos.';
    } else {
        // Verificar que no exista otro usuario con ese nombre
        $check = $db->prepare("SELECT id FROM admin_users WHERE username = ? AND id != ?");
        $check->execute([$newUsername, $adminId]);
        if ($check->fetch()) {
            $errorUser = 'Ese nombre de usuario ya está en uso.';
        } else {
            $db->prepare("UPDATE admin_users SET username = ? WHERE id = ?")
               ->execute([$newUsername, $adminId]);
            $_SESSION['admin_username'] = $newUsername;
            $user['username']           = $newUsername;
            $successUser = 'Nombre de usuario actualizado correctamente.';
        }
    }
}

// ── Cambiar contraseña ─────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'password') {
    csrf_verify();

    $currentPass = $_POST['current_password'] ?? '';
    $newPass     = $_POST['new_password']     ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';

    if (!$currentPass || !$newPass || !$confirmPass) {
        $errorPass = 'Completá todos los campos.';
    } elseif (!password_verify($currentPass, $user['password'])) {
        $errorPass = 'La contraseña actual es incorrecta.';
    } elseif (strlen($newPass) < 8) {
        $errorPass = 'La nueva contraseña debe tener al menos 8 caracteres.';
    } elseif (!preg_match('/[A-Z]/', $newPass)) {
        $errorPass = 'La contraseña debe incluir al menos una letra mayúscula.';
    } elseif (!preg_match('/[0-9]/', $newPass)) {
        $errorPass = 'La contraseña debe incluir al menos un número.';
    } elseif ($newPass !== $confirmPass) {
        $errorPass = 'Las contraseñas nuevas no coinciden.';
    } else {
        $hash = password_hash($newPass, PASSWORD_BCRYPT);
        $db->prepare("UPDATE admin_users SET password = ? WHERE id = ?")
           ->execute([$hash, $adminId]);
        $successPass = 'Contraseña actualizada correctamente.';
        // Actualizar el hash local para que el formulario quede limpio
        $user['password'] = $hash;
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="row g-4" style="max-width: 760px">

    <!-- ── Datos del usuario ─────────────────────────────────────────────── -->
    <div class="col-12">
        <div class="form-card">
            <h3 style="font-size:0.9rem; font-weight:600; color:#4db8a0; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                <i class="bi bi-person me-2"></i>Datos del usuario
            </h3>

            <?php if ($successUser): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($successUser) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($errorUser): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($errorUser) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="username">

                <div class="mb-3">
                    <label class="form-label">Usuario actual</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                </div>
                <div class="mb-4">
                    <label class="form-label">Nuevo nombre de usuario</label>
                    <input type="text" name="new_username" class="form-control"
                           placeholder="nuevo_usuario"
                           autocomplete="username"
                           value="<?= htmlspecialchars($_POST['new_username'] ?? '') ?>">
                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:5px">
                        Mínimo 3 caracteres. Solo letras, números, guiones y puntos.
                    </div>
                </div>
                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-check-lg me-2"></i>Guardar usuario
                </button>
            </form>
        </div>
    </div>

    <!-- ── Cambiar contraseña ────────────────────────────────────────────── -->
    <div class="col-12">
        <div class="form-card">
            <h3 style="font-size:0.9rem; font-weight:600; color:#4db8a0; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                <i class="bi bi-shield-lock me-2"></i>Cambiar contraseña
            </h3>

            <?php if ($successPass): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= htmlspecialchars($successPass) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($errorPass): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= htmlspecialchars($errorPass) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate id="passForm">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="password">

                <div class="mb-3">
                    <label class="form-label">Contraseña actual</label>
                    <div class="input-group">
                        <input type="password" name="current_password" id="currentPass"
                               class="form-control" placeholder="••••••••"
                               autocomplete="current-password">
                        <button type="button" class="btn btn-outline-light"
                                onclick="togglePass('currentPass', this)"
                                title="Mostrar/ocultar">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="newPass"
                               class="form-control" placeholder="••••••••"
                               autocomplete="new-password"
                               oninput="checkStrength(this.value)">
                        <button type="button" class="btn btn-outline-light"
                                onclick="togglePass('newPass', this)"
                                title="Mostrar/ocultar">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <!-- Indicador de fuerza -->
                    <div style="margin-top:8px">
                        <div style="display:flex; gap:4px; margin-bottom:5px">
                            <div class="strength-bar" id="bar1"></div>
                            <div class="strength-bar" id="bar2"></div>
                            <div class="strength-bar" id="bar3"></div>
                            <div class="strength-bar" id="bar4"></div>
                        </div>
                        <div id="strengthLabel" style="font-size:0.75rem; color:var(--text-muted)"></div>
                    </div>
                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:6px; line-height:1.6">
                        Mínimo 8 caracteres · Al menos una mayúscula · Al menos un número
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirmar nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirmPass"
                               class="form-control" placeholder="••••••••"
                               autocomplete="new-password"
                               oninput="checkMatch()">
                        <button type="button" class="btn btn-outline-light"
                                onclick="togglePass('confirmPass', this)"
                                title="Mostrar/ocultar">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div id="matchLabel" style="font-size:0.75rem; margin-top:5px"></div>
                </div>

                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-lock me-2"></i>Actualizar contraseña
                </button>
            </form>
        </div>
    </div>

</div>

<style>
.input-group .btn { border-color: var(--border) !important; }
.strength-bar {
    height: 4px;
    flex: 1;
    border-radius: 4px;
    background: var(--surface2);
    transition: background 0.3s;
}
</style>

<script>
function togglePass(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const icon  = btn.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}

function checkStrength(val) {
    let score = 0;
    if (val.length >= 8)              score++;
    if (/[A-Z]/.test(val))            score++;
    if (/[0-9]/.test(val))            score++;
    if (/[^A-Za-z0-9]/.test(val))     score++;

    const colors  = ['', '#f87171', '#fbbf24', '#60a5fa', '#4db8a0'];
    const labels  = ['', 'Muy débil', 'Débil', 'Buena', 'Fuerte'];
    const bars    = [bar1, bar2, bar3, bar4];

    bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score] : 'var(--surface2)';
    });
    document.getElementById('strengthLabel').textContent = val ? labels[score] : '';
    document.getElementById('strengthLabel').style.color = colors[score] || 'var(--text-muted)';
}

function checkMatch() {
    const np  = document.getElementById('newPass').value;
    const cp  = document.getElementById('confirmPass').value;
    const lbl = document.getElementById('matchLabel');
    if (!cp) { lbl.textContent = ''; return; }
    if (np === cp) {
        lbl.textContent = '✓ Las contraseñas coinciden';
        lbl.style.color = '#4db8a0';
    } else {
        lbl.textContent = '✗ No coinciden';
        lbl.style.color = '#f87171';
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
