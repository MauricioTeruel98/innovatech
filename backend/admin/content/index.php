<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__, 2) . '/lib/content.php';

$pageTitle  = 'Contenido del sitio';
$activePage = 'content';

$db = getDB();

// Contar ajustes por sección para mostrar en cada tarjeta.
$counts = [];
foreach ($db->query("SELECT section, COUNT(*) AS n FROM site_settings GROUP BY section")->fetchAll() as $r) {
    $counts[$r['section']] = (int) $r['n'];
}

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

<p style="color:#8b8bae; font-size:0.9rem; margin-bottom:24px">
    Elegí una sección para editar sus textos e imágenes. Los listados (equipo, testimonios,
    modalidades y valores) se administran desde sus propias secciones del menú.
</p>

<div class="row g-3">
    <?php foreach (content_sections() as $code => $info): ?>
    <div class="col-sm-6 col-lg-4">
        <a href="<?= PANEL_URL ?>/content/edit.php?section=<?= urlencode($code) ?>"
           class="stat-card d-block text-decoration-none h-100">
            <div class="stat-icon"><i class="bi <?= htmlspecialchars($info['icon']) ?>"></i></div>
            <div class="stat-value" style="font-size:1.05rem"><?= htmlspecialchars($info['title']) ?></div>
            <div class="stat-label"><?= htmlspecialchars($info['desc']) ?></div>
            <div style="color:#4db8a0; font-size:0.75rem; margin-top:10px">
                <?= $counts[$code] ?? 0 ?> campos · Editar <i class="bi bi-arrow-right"></i>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
