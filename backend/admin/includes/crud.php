<?php
/**
 * Motor CRUD genérico para las colecciones de contenido (equipo, testimonios,
 * valores, modalidades, menús). Cada recurso se describe con un array $res y
 * estos helpers renderizan listado/alta/edición/baja completos, reutilizando el
 * mismo estilo Bootstrap oscuro del panel.
 *
 * Estructura de $res:
 *   table    => nombre de la tabla
 *   route    => carpeta/segmento bajo el panel (ej. 'team')
 *   title    => título plural ('Equipo')
 *   singular => sustantivo singular ('miembro')
 *   icon     => clase Bootstrap Icons para el encabezado
 *   order    => ORDER BY del listado
 *   fields   => [ columna => spec ]  con keys:
 *        label, type(text|textarea|url|number|bool|image|icon|select),
 *        required(bool), help, list(bool: mostrar en la tabla),
 *        subdir(image), options(select: [valor=>etiqueta]), default
 */

require_once __DIR__ . '/../../lib/uploads.php';
require_once __DIR__ . '/../../lib/icons.php';

function crud_default($f)
{
    if (array_key_exists('default', $f)) return $f['default'];
    return $f['type'] === 'bool' ? 0 : '';
}

/** Procesa el POST de alta/edición. Devuelve ['errors'=>[], 'data'=>[]]; redirige en éxito. */
function crud_process(PDO $db, array $res, ?array $existing): array
{
    $id     = $existing['id'] ?? null;
    $errors = [];
    $data   = [];
    foreach ($res['fields'] as $col => $f) {
        $data[$col] = $existing[$col] ?? crud_default($f);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return ['errors' => $errors, 'data' => $data];
    }

    csrf_verify();

    try {
        foreach ($res['fields'] as $col => $f) {
            switch ($f['type']) {
                case 'image':
                    if (!empty($_POST['remove_' . $col])) {
                        if ($existing) delete_upload($existing[$col] ?? '');
                        $data[$col] = '';
                    } else {
                        $saved = save_uploaded_image('file_' . $col, $f['subdir'] ?? $res['route']);
                        if ($saved !== null) {
                            if ($existing) delete_upload($existing[$col] ?? '');
                            $data[$col] = $saved;
                        } else {
                            $data[$col] = $existing[$col] ?? '';
                        }
                    }
                    break;
                case 'bool':
                    $data[$col] = isset($_POST['f_' . $col]) ? 1 : 0;
                    break;
                case 'number':
                    $data[$col] = (int) ($_POST['f_' . $col] ?? crud_default($f));
                    break;
                default:
                    $data[$col] = trim((string) ($_POST['f_' . $col] ?? ''));
                    break;
            }
        }
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }

    foreach ($res['fields'] as $col => $f) {
        if (!empty($f['required']) && $f['type'] !== 'image'
            && ($data[$col] === '' || $data[$col] === null)) {
            $errors[] = 'El campo “' . $f['label'] . '” es obligatorio.';
        }
    }

    if ($errors) return ['errors' => $errors, 'data' => $data];

    $cols = array_keys($res['fields']);
    if ($id) {
        $set    = implode(', ', array_map(fn($c) => "$c = :$c", $cols));
        $params = [':id' => $id];
        foreach ($cols as $c) $params[":$c"] = $data[$c];
        $db->prepare("UPDATE {$res['table']} SET $set WHERE id = :id")->execute($params);
        $msg = ucfirst($res['singular']) . ' actualizado correctamente.';
    } else {
        $ph     = implode(', ', array_map(fn($c) => ":$c", $cols));
        $params = [];
        foreach ($cols as $c) $params[":$c"] = $data[$c];
        $db->prepare("INSERT INTO {$res['table']} (" . implode(', ', $cols) . ") VALUES ($ph)")->execute($params);
        $msg = ucfirst($res['singular']) . ' creado correctamente.';
    }

    $_SESSION['flash'] = ['type' => 'success', 'msg' => $msg];
    header('Location: ' . PANEL_URL . '/' . $res['route'] . '/index.php');
    exit;
}

/** Renderiza un campo del formulario. */
function crud_field_input(string $col, array $f, $value): void
{
    $name = 'f_' . $col;
    switch ($f['type']) {
        case 'textarea':
            echo '<textarea name="' . $name . '" class="form-control" rows="3">' . htmlspecialchars((string) $value) . '</textarea>';
            break;
        case 'bool':
            echo '<div class="form-check"><input class="form-check-input" type="checkbox" name="' . $name . '" id="' . $name . '" value="1" ' . ($value ? 'checked' : '') . '>'
               . '<label class="form-check-label" for="' . $name . '" style="color:#c4c4e0;font-size:0.85rem">Activo / visible</label></div>';
            break;
        case 'number':
            echo '<input type="number" name="' . $name . '" class="form-control" value="' . htmlspecialchars((string) $value) . '">';
            break;
        case 'icon':
            echo icon_select($name, (string) $value);
            break;
        case 'select':
            echo '<select name="' . $name . '" class="form-select">';
            foreach (($f['options'] ?? []) as $v => $lbl) {
                echo '<option value="' . htmlspecialchars((string) $v) . '"' . ((string) $v === (string) $value ? ' selected' : '') . '>' . htmlspecialchars($lbl) . '</option>';
            }
            echo '</select>';
            break;
        case 'image':
            $url = upload_url((string) $value);
            echo '<div class="d-flex align-items-center gap-3">';
            if ($url) {
                echo '<img src="' . htmlspecialchars($url) . '" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:8px;border:1px solid var(--border)">';
            } else {
                echo '<div style="width:64px;height:64px;border-radius:8px;border:1px dashed var(--border);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:0.65rem">sin&nbsp;foto</div>';
            }
            echo '<div class="flex-fill"><input type="file" name="file_' . $col . '" class="form-control" accept="image/*">';
            if ($url) {
                echo '<div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_' . $col . '" id="remove_' . $col . '" value="1">'
                   . '<label class="form-check-label" for="remove_' . $col . '" style="color:#c4c4e0;font-size:0.8rem">Quitar imagen</label></div>';
            }
            echo '</div></div>';
            break;
        case 'url':
        default:
            echo '<input type="text" name="' . $name . '" class="form-control" value="' . htmlspecialchars((string) $value) . '">';
            break;
    }
}

/** Renderiza el formulario completo (alta/edición) dentro de una página. */
function crud_render_form(array $res, array $data, array $errors, ?int $id): void
{
    $isEdit = $id !== null;
    ?>
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
            <?= $isEdit ? 'Editar ' : 'Nuevo ' ?><?= htmlspecialchars($res['singular']) ?>
        </h2>
    </div>

    <?php if ($errors): ?>
    <div class="alert alert-danger mb-4">
        <strong>Corregí lo siguiente:</strong>
        <ul class="mb-0 mt-1"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate>
        <?= csrf_field() ?>
        <div class="form-card" style="max-width:680px">
            <?php foreach ($res['fields'] as $col => $f): ?>
            <div class="mb-4">
                <label class="form-label">
                    <?= htmlspecialchars($f['label']) ?>
                    <?php if (!empty($f['required'])): ?><span style="color:#f87171">*</span><?php endif; ?>
                </label>
                <?php crud_field_input($col, $f, $data[$col]); ?>
                <?php if (!empty($f['help'])): ?>
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px"><?= htmlspecialchars($f['help']) ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-accent"><i class="bi bi-check-lg me-1"></i> Guardar</button>
        </div>
    </form>
    <?php
}

/** Valor de celda para el listado. */
function crud_cell(array $f, $value): string
{
    switch ($f['type']) {
        case 'image':
            $url = upload_url((string) $value);
            return $url
                ? '<img src="' . htmlspecialchars($url) . '" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;border:1px solid var(--border)">'
                : '<span style="color:var(--text-muted)">—</span>';
        case 'bool':
            return $value
                ? '<i class="bi bi-check-circle-fill" style="color:#4db8a0"></i>'
                : '<i class="bi bi-dash-circle" style="color:#4a4a6a"></i>';
        case 'icon':
            return $value ? '<span class="badge-tag">' . htmlspecialchars((string) $value) . '</span>' : '<span style="color:var(--text-muted)">—</span>';
        case 'select':
            return htmlspecialchars(($f['options'][$value] ?? (string) $value));
        case 'textarea':
            $t = (string) $value;
            return htmlspecialchars(mb_strlen($t) > 70 ? mb_substr($t, 0, 70) . '…' : $t);
        default:
            return htmlspecialchars((string) $value);
    }
}

// ── Páginas completas ──────────────────────────────────────────────────────────

function crud_index(PDO $db, array $res): void
{
    $pageTitle  = $res['title'];
    $activePage = $res['route'];
    $rows = $db->query("SELECT * FROM {$res['table']} ORDER BY {$res['order']}")->fetchAll();
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    $listFields = array_filter($res['fields'], fn($f) => !empty($f['list']));

    require __DIR__ . '/header.php';
    ?>
    <?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show mb-4" role="alert">
        <?= htmlspecialchars($flash['msg']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
            <i class="bi <?= htmlspecialchars($res['icon']) ?> me-1"></i>
            <?= htmlspecialchars($res['title']) ?>
            <span style="color:#8b8bae; font-weight:400; font-size:0.85rem; margin-left:6px">(<?= count($rows) ?>)</span>
        </h2>
        <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/create.php" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Nuevo
        </a>
    </div>

    <div class="data-table">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <?php foreach ($listFields as $col => $f): ?><th><?= htmlspecialchars($f['label']) ?></th><?php endforeach; ?>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                <tr><td colspan="<?= count($listFields) + 1 ?>" class="text-center" style="color:#8b8bae; padding:40px">
                    Aún no hay registros. <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/create.php" style="color:#5bbee0">Crear el primero.</a>
                </td></tr>
                <?php else: foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($listFields as $col => $f): ?>
                    <td><?= crud_cell($f, $row[$col] ?? '') ?></td>
                    <?php endforeach; ?>
                    <td>
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/edit.php?id=<?= (int) $row['id'] ?>" class="btn-edit"><i class="bi bi-pencil"></i></a>
                            <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/delete.php?id=<?= (int) $row['id'] ?>" class="btn-delete"><i class="bi bi-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
    <?php
    require __DIR__ . '/footer.php';
}

function crud_create(PDO $db, array $res): void
{
    ['errors' => $errors, 'data' => $data] = crud_process($db, $res, null);
    $pageTitle  = 'Nuevo ' . $res['singular'];
    $activePage = $res['route'];
    require __DIR__ . '/header.php';
    crud_render_form($res, $data, $errors, null);
    require __DIR__ . '/footer.php';
}

function crud_edit(PDO $db, array $res): void
{
    $id   = (int) ($_GET['id'] ?? 0);
    $stmt = $db->prepare("SELECT * FROM {$res['table']} WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();

    if (!$existing) {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Registro no encontrado.'];
        header('Location: ' . PANEL_URL . '/' . $res['route'] . '/index.php');
        exit;
    }

    ['errors' => $errors, 'data' => $data] = crud_process($db, $res, $existing);
    $pageTitle  = 'Editar ' . $res['singular'];
    $activePage = $res['route'];
    require __DIR__ . '/header.php';
    crud_render_form($res, $data, $errors, $id);
    require __DIR__ . '/footer.php';
}

function crud_delete(PDO $db, array $res): void
{
    $id   = (int) ($_GET['id'] ?? 0);
    $stmt = $db->prepare("SELECT * FROM {$res['table']} WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if (!$row) {
        $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Registro no encontrado.'];
        header('Location: ' . PANEL_URL . '/' . $res['route'] . '/index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
        csrf_verify();
        // Borrar imágenes asociadas del disco.
        foreach ($res['fields'] as $col => $f) {
            if ($f['type'] === 'image' && !empty($row[$col])) delete_upload($row[$col]);
        }
        $db->prepare("DELETE FROM {$res['table']} WHERE id = ?")->execute([$id]);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => ucfirst($res['singular']) . ' eliminado.'];
        header('Location: ' . PANEL_URL . '/' . $res['route'] . '/index.php');
        exit;
    }

    // Etiqueta legible del registro (primer campo de texto).
    $labelCol = array_key_first(array_filter($res['fields'], fn($f) => in_array($f['type'], ['text', 'textarea'])));
    $rowLabel = $labelCol ? (string) ($row[$labelCol] ?? '') : ('#' . $id);

    $pageTitle  = 'Eliminar ' . $res['singular'];
    $activePage = $res['route'];
    require __DIR__ . '/header.php';
    ?>
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/index.php" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i></a>
        <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">Eliminar <?= htmlspecialchars($res['singular']) ?></h2>
    </div>
    <div class="form-card" style="max-width:500px">
        <div style="text-align:center; padding:16px 0 24px">
            <div style="width:60px;height:60px;border-radius:50%;background:rgba(239,68,68,0.12);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.75rem;color:#f87171">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h3 style="font-size:1.1rem;font-weight:600;color:#fff;margin-bottom:8px">¿Eliminar este registro?</h3>
            <p style="color:#8b8bae;font-size:0.9rem;margin-bottom:0">
                Vas a eliminar permanentemente:<br>
                <strong style="color:#e2e2f0"><?= htmlspecialchars($rowLabel) ?></strong>
            </p>
            <p style="color:#f87171;font-size:0.8rem;margin-top:12px">Esta acción no se puede deshacer.</p>
        </div>
        <div class="d-flex gap-3">
            <a href="<?= PANEL_URL ?>/<?= $res['route'] ?>/index.php" class="btn btn-outline-light flex-fill">Cancelar</a>
            <form method="POST" style="flex:1">
                <?= csrf_field() ?>
                <button type="submit" name="confirm" value="1" class="btn w-100" style="background:#dc2626;border:none;color:#fff;font-weight:600;border-radius:8px;padding:9px">
                    <i class="bi bi-trash me-1"></i> Sí, eliminar
                </button>
            </form>
        </div>
    </div>
    <?php
    require __DIR__ . '/footer.php';
}
