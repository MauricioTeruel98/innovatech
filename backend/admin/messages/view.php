<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$db = getDB();
$id = (int) ($_GET['id'] ?? 0);

$stmt = $db->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$m = $stmt->fetch();

if (!$m) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Mensaje no encontrado.'];
    header('Location: ' . PANEL_URL . '/messages/index.php');
    exit;
}

// Marcar como leído.
if (!$m['is_read']) {
    $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")->execute([$id]);
}

$pageTitle  = 'Mensaje';
$activePage = 'messages';
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= PANEL_URL ?>/messages/index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i></a>
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">Mensaje de <?= htmlspecialchars($m['name']) ?></h2>
</div>

<div class="form-card" style="max-width:680px">
    <div class="row g-3 mb-4">
        <div class="col-sm-6">
            <div class="form-label">Nombre</div>
            <div style="color:#fff"><?= htmlspecialchars($m['name']) ?></div>
        </div>
        <div class="col-sm-6">
            <div class="form-label">Email</div>
            <div><a href="mailto:<?= htmlspecialchars($m['email']) ?>" style="color:#5bbee0"><?= htmlspecialchars($m['email']) ?></a></div>
        </div>
        <div class="col-sm-6">
            <div class="form-label">Fecha</div>
            <div style="color:#c4c4e0"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></div>
        </div>
        <div class="col-sm-6">
            <div class="form-label">IP</div>
            <div style="color:#8b8bae"><?= htmlspecialchars($m['ip'] ?? '—') ?></div>
        </div>
    </div>

    <div class="mb-4">
        <div class="form-label">Mensaje</div>
        <div style="color:#d8eaf5; white-space:pre-wrap; background:var(--surface2); border:1px solid var(--border); border-radius:8px; padding:14px"><?= htmlspecialchars($m['message']) ?></div>
    </div>

    <div class="d-flex gap-3">
        <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re:%20Tu%20consulta%20en%20Innova%20Tech" class="btn btn-accent">
            <i class="bi bi-reply me-1"></i> Responder por email
        </a>
        <a href="<?= PANEL_URL ?>/messages/delete.php?id=<?= (int) $m['id'] ?>" class="btn btn-delete">
            <i class="bi bi-trash me-1"></i> Eliminar
        </a>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
