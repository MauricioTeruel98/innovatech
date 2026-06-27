<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$pageTitle  = 'Mensajes';
$activePage = 'messages';

$db       = getDB();
$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require_once dirname(__DIR__) . '/includes/header.php';
?>

<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show mb-4" role="alert">
    <?= htmlspecialchars($flash['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
        <i class="bi bi-inbox me-1"></i> Mensajes de contacto
        <span style="color:#8b8bae; font-weight:400; font-size:0.85rem; margin-left:6px">(<?= count($messages) ?>)</span>
    </h2>
</div>

<div class="data-table">
    <table class="table table-borderless mb-0">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($messages)): ?>
            <tr><td colspan="6" class="text-center" style="color:#8b8bae; padding:40px">Todavía no hay mensajes.</td></tr>
            <?php else: foreach ($messages as $m): ?>
            <tr style="<?= $m['is_read'] ? '' : 'background:rgba(0,82,130,0.08)' ?>">
                <td>
                    <?php if ($m['is_read']): ?>
                        <span class="badge-level" style="background:rgba(93,138,170,0.15);color:#8cb8d4">Leído</span>
                    <?php else: ?>
                        <span class="badge-level badge-principiante">Nuevo</span>
                    <?php endif; ?>
                </td>
                <td style="color:#fff; font-weight:500"><?= htmlspecialchars($m['name']) ?></td>
                <td><a href="mailto:<?= htmlspecialchars($m['email']) ?>" style="color:#5bbee0"><?= htmlspecialchars($m['email']) ?></a></td>
                <td style="color:#8b8bae; font-size:0.83rem"><?= htmlspecialchars(mb_strlen($m['message']) > 60 ? mb_substr($m['message'], 0, 60) . '…' : $m['message']) ?></td>
                <td style="color:#8b8bae; font-size:0.8rem"><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                <td>
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= PANEL_URL ?>/messages/view.php?id=<?= (int) $m['id'] ?>" class="btn-edit"><i class="bi bi-eye"></i></a>
                        <a href="<?= PANEL_URL ?>/messages/delete.php?id=<?= (int) $m['id'] ?>" class="btn-delete"><i class="bi bi-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
