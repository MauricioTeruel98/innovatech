<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once dirname(__DIR__) . '/config/database.php';

$pageTitle  = 'Dashboard';
$activePage = 'dashboard';

$db = getDB();

$totalCourses   = (int) $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$popularCourses = (int) $db->query("SELECT COUNT(*) FROM courses WHERE popular = 1")->fetchColumn();
$levelCounts    = $db->query("SELECT level, COUNT(*) as total FROM courses GROUP BY level")->fetchAll();
$recent         = $db->query("SELECT id, title, tag, level, updated_at FROM courses ORDER BY updated_at DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="stat-value"><?= $totalCourses ?></div>
            <div class="stat-label">Cursos totales</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
            <div class="stat-value"><?= $popularCourses ?></div>
            <div class="stat-label">Cursos destacados</div>
        </div>
    </div>
    <?php foreach ($levelCounts as $lc): ?>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="stat-value"><?= $lc['total'] ?></div>
            <div class="stat-label"><?= htmlspecialchars($lc['level']) ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Recent courses -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">Cursos actualizados recientemente</h2>
    <a href="<?= PANEL_URL ?>/courses/create.php" class="btn btn-accent btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Nuevo curso
    </a>
</div>

<div class="data-table">
    <table class="table table-borderless mb-0">
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Nivel</th>
                <th>Última actualización</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent as $c): ?>
            <tr>
                <td style="color:#fff; font-weight:500"><?= htmlspecialchars($c['title']) ?></td>
                <td><span class="badge-tag"><?= htmlspecialchars($c['tag']) ?></span></td>
                <td>
                    <?php $lvl = strtolower($c['level']); ?>
                    <span class="badge-level badge-<?= $lvl ?>">
                        <?= htmlspecialchars($c['level']) ?>
                    </span>
                </td>
                <td style="color:#8b8bae; font-size:0.8rem">
                    <?= date('d/m/Y H:i', strtotime($c['updated_at'])) ?>
                </td>
                <td>
                    <a href="<?= PANEL_URL ?>/courses/edit.php?id=<?= $c['id'] ?>"
                       class="btn btn-sm btn-outline-light py-1 px-3">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
