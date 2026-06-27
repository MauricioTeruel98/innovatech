<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/lib/site_context.php';

$db   = getDB();
$site = current_site();
$id   = (int) ($_GET['id'] ?? 0);

$stmt = $db->prepare("SELECT id, name FROM contact_messages WHERE id = ? AND site = ?");
$stmt->execute([$id, $site]);
$m = $stmt->fetch();

if (!$m) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Mensaje no encontrado.'];
    header('Location: ' . PANEL_URL . '/messages/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    csrf_verify();
    $db->prepare("DELETE FROM contact_messages WHERE id = ? AND site = ?")->execute([$id, $site]);
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Mensaje eliminado.'];
    header('Location: ' . PANEL_URL . '/messages/index.php');
    exit;
}

$pageTitle  = 'Eliminar mensaje';
$activePage = 'messages';
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= PANEL_URL ?>/messages/index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">Eliminar mensaje</h2>
</div>

<div class="form-card" style="max-width:500px">
    <div style="text-align:center; padding:16px 0 24px">
        <div style="width:60px;height:60px;border-radius:50%;background:rgba(239,68,68,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.75rem;color:#f87171">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <h3 style="font-size:1.1rem;font-weight:600;color:#fff;margin-bottom:8px">¿Eliminar este mensaje?</h3>
        <p style="color:#8b8bae;font-size:0.9rem;margin-bottom:0">
            De <strong style="color:#e2e2f0"><?= htmlspecialchars($m['name']) ?></strong>
        </p>
        <p style="color:#f87171;font-size:0.8rem;margin-top:12px">Esta acción no se puede deshacer.</p>
    </div>
    <div class="d-flex gap-3">
        <a href="<?= PANEL_URL ?>/messages/index.php" class="btn btn-outline-light flex-fill">Cancelar</a>
        <form method="POST" style="flex:1">
            <?= csrf_field() ?>
            <button type="submit" name="confirm" value="1" class="btn w-100" style="background:#dc2626;border:none;color:#fff;font-weight:600;border-radius:8px;padding:9px">
                <i class="bi bi-trash me-1"></i> Sí, eliminar
            </button>
        </form>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
