<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/lib/content.php';
require_once dirname(__DIR__, 2) . '/lib/uploads.php';
require_once dirname(__DIR__, 2) . '/lib/icons.php';

$db       = getDB();
$sections = content_sections();
$section  = $_GET['section'] ?? '';

if (!isset($sections[$section])) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Sección de contenido inválida.'];
    header('Location: ' . PANEL_URL . '/content/index.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    // Cargar las filas de la sección para procesarlas.
    $stmt = $db->prepare("SELECT * FROM site_settings WHERE section = ? ORDER BY sort_order, id");
    $stmt->execute([$section]);
    $rows = $stmt->fetchAll();

    $update = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE id = ?");

    try {
        foreach ($rows as $row) {
            $id  = (int) $row['id'];
            $new = $row['setting_value'];

            if ($row['type'] === 'image') {
                if (!empty($_POST['remove_' . $id])) {
                    delete_upload($row['setting_value']);
                    $new = '';
                } else {
                    $saved = save_uploaded_image('image_' . $id, $section);
                    if ($saved !== null) {
                        delete_upload($row['setting_value']); // borrar la anterior
                        $new = $saved;
                    }
                }
            } elseif ($row['type'] === 'bool') {
                $new = isset($_POST['field_' . $id]) ? '1' : '0';
            } else {
                $new = trim((string) ($_POST['field_' . $id] ?? ''));
            }

            $update->execute([$new, $id]);
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Contenido de “' . content_section_title($section) . '” actualizado.'];
        header('Location: ' . PANEL_URL . '/content/edit.php?section=' . urlencode($section));
        exit;

    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }
}

// Cargar filas para mostrar el formulario.
$stmt = $db->prepare("SELECT * FROM site_settings WHERE section = ? ORDER BY sort_order, id");
$stmt->execute([$section]);
$rows = $stmt->fetchAll();

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$pageTitle  = content_section_title($section);
$activePage = 'content';
require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= PANEL_URL ?>/content/index.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
        <i class="bi <?= htmlspecialchars($sections[$section]['icon']) ?> me-1"></i>
        <?= htmlspecialchars($pageTitle) ?>
    </h2>
</div>

<?php if ($flash): ?>
<div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show mb-4" role="alert">
    <?= htmlspecialchars($flash['msg']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($errors): ?>
<div class="alert alert-danger mb-4">
    <strong>Revisá lo siguiente:</strong>
    <ul class="mb-0 mt-1">
        <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <div class="form-card" style="max-width:760px">
        <?php foreach ($rows as $row): $id = (int) $row['id']; $val = (string) $row['setting_value']; ?>
        <div class="mb-4">
            <label class="form-label"><?= htmlspecialchars($row['label'] ?: $row['setting_key']) ?></label>

            <?php if ($row['type'] === 'textarea'): ?>
                <textarea name="field_<?= $id ?>" class="form-control" rows="3"><?= htmlspecialchars($val) ?></textarea>

            <?php elseif ($row['type'] === 'image'): ?>
                <?php $url = upload_url($val); ?>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <?php if ($url): ?>
                        <img src="<?= htmlspecialchars($url) ?>" alt=""
                             style="width:90px;height:60px;object-fit:cover;border-radius:8px;border:1px solid var(--border);background:var(--surface2)">
                    <?php else: ?>
                        <div style="width:90px;height:60px;border-radius:8px;border:1px dashed var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:0.7rem">
                            por defecto
                        </div>
                    <?php endif; ?>
                    <div class="flex-fill">
                        <input type="file" name="image_<?= $id ?>" class="form-control" accept="image/*">
                        <?php if ($url): ?>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remove_<?= $id ?>" id="remove_<?= $id ?>" value="1">
                            <label class="form-check-label" for="remove_<?= $id ?>" style="color:#c4c4e0;font-size:0.8rem">
                                Quitar imagen (volver a la de por defecto)
                            </label>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ($row['type'] === 'icon'): ?>
                <?= icon_select('field_' . $id, $val) ?>
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px">Ícono que se muestra en el sitio.</div>

            <?php elseif ($row['type'] === 'bool'): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="field_<?= $id ?>" id="field_<?= $id ?>" value="1" <?= $val ? 'checked' : '' ?>>
                    <label class="form-check-label" for="field_<?= $id ?>" style="color:#c4c4e0;font-size:0.85rem">Activado</label>
                </div>

            <?php elseif ($row['type'] === 'color'): ?>
                <input type="text" name="field_<?= $id ?>" class="form-control" value="<?= htmlspecialchars($val) ?>" placeholder="hsl(200,100%,60%) o #005282">

            <?php elseif ($row['type'] === 'number'): ?>
                <input type="number" name="field_<?= $id ?>" class="form-control" value="<?= htmlspecialchars($val) ?>">

            <?php else: ?>
                <input type="text" name="field_<?= $id ?>" class="form-control" value="<?= htmlspecialchars($val) ?>">
            <?php endif; ?>

            <?php if (!empty($row['help'])): ?>
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px"><?= htmlspecialchars($row['help']) ?></div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-accent">
            <i class="bi bi-check-lg me-1"></i> Guardar cambios
        </button>
    </div>
</form>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
