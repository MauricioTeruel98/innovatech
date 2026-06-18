<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$pageTitle  = 'Cursos';
$activePage = 'courses';

$db      = getDB();
$courses = $db->query("SELECT * FROM courses ORDER BY popular DESC, created_at DESC")->fetchAll();

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
    <div>
        <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
            Todos los cursos
            <span style="color:#8b8bae; font-weight:400; font-size:0.85rem; margin-left:8px">
                (<?= count($courses) ?>)
            </span>
        </h2>
    </div>
    <a href="<?= PANEL_URL ?>/courses/create.php" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Nuevo curso
    </a>
</div>

<div class="data-table">
    <table class="table table-borderless mb-0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Instructor</th>
                <th>Categoría</th>
                <th>Nivel</th>
                <th>Duración</th>
                <th>Precio</th>
                <th>Destacado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($courses)): ?>
            <tr>
                <td colspan="8" class="text-center" style="color:#8b8bae; padding:40px">
                    No hay cursos aún. <a href="<?= PANEL_URL ?>/courses/create.php" style="color:#a78bfa">Crea el primero.</a>
                </td>
            </tr>
            <?php else: ?>
            <?php foreach ($courses as $c): ?>
            <tr>
                <td>
                    <div style="font-weight:600; color:#fff"><?= htmlspecialchars($c['title']) ?></div>
                    <div style="font-size:0.75rem; color:#8b8bae"><?= htmlspecialchars($c['slug']) ?></div>
                </td>
                <td><?= htmlspecialchars($c['instructor']) ?></td>
                <td><span class="badge-tag"><?= htmlspecialchars($c['tag']) ?></span></td>
                <td>
                    <?php $lvl = strtolower($c['level']); ?>
                    <span class="badge-level badge-<?= $lvl ?>"><?= htmlspecialchars($c['level']) ?></span>
                </td>
                <td><?= htmlspecialchars($c['duration']) ?></td>
                <td><?= htmlspecialchars($c['price']) ?></td>
                <td>
                    <?php if ($c['popular']): ?>
                        <i class="bi bi-star-fill" style="color:#fbbf24"></i>
                    <?php else: ?>
                        <i class="bi bi-star" style="color:#4a4a6a"></i>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="<?= PANEL_URL ?>/courses/edit.php?id=<?= $c['id'] ?>"
                           class="btn btn-sm btn-outline-light py-1 px-3"
                           title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= PANEL_URL ?>/courses/delete.php?id=<?= $c['id'] ?>"
                           class="btn btn-sm py-1 px-3"
                           style="background:rgba(239,68,68,0.15);border:none;color:#f87171;"
                           title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
