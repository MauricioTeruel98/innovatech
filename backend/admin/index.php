<?php
require_once __DIR__ . '/includes/auth_guard.php';
require_once dirname(__DIR__) . '/config/database.php';

$pageTitle  = 'Dashboard';
$activePage = 'dashboard';

$db = getDB();

$totalCourses   = (int) $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
$popularCourses = (int) $db->query("SELECT COUNT(*) FROM courses WHERE popular = 1")->fetchColumn();
$teamCount      = (int) $db->query("SELECT COUNT(*) FROM team_members")->fetchColumn();
$unreadMessages = (int) $db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
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
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value"><?= $teamCount ?></div>
            <div class="stat-label">Miembros del equipo</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="<?= PANEL_URL ?>/messages/index.php" class="stat-card d-block text-decoration-none">
            <div class="stat-icon"><i class="bi bi-inbox-fill"></i></div>
            <div class="stat-value"><?= $unreadMessages ?></div>
            <div class="stat-label">Mensajes sin leer</div>
        </a>
    </div>
</div>

<!-- Accesos rápidos al contenido -->
<h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0 0 12px">Editar contenido del sitio</h2>
<div class="row g-3 mb-4">
    <?php
    require_once dirname(__DIR__) . '/lib/content.php';
    foreach (content_sections() as $code => $info): ?>
    <div class="col-6 col-md-4 col-lg-3">
        <a href="<?= PANEL_URL ?>/content/edit.php?section=<?= urlencode($code) ?>"
           class="stat-card d-block text-decoration-none" style="padding:16px 18px">
            <i class="bi <?= htmlspecialchars($info['icon']) ?>" style="color:#4db8a0; font-size:1.1rem"></i>
            <div style="color:#fff; font-size:0.9rem; font-weight:500; margin-top:8px"><?= htmlspecialchars($info['title']) ?></div>
        </a>
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
