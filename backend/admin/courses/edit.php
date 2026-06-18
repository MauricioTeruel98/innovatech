<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$db = getDB();
$id = (int) ($_GET['id'] ?? 0);

$course = $db->prepare("SELECT * FROM courses WHERE id = ?");
$course->execute([$id]);
$course = $course->fetch();

if (!$course) {
    $_SESSION['flash'] = ['type' => 'danger', 'msg' => 'Curso no encontrado.'];
    header('Location: ' . PANEL_URL . '/courses/index.php');
    exit;
}

$pageTitle  = 'Editar: ' . $course['title'];
$activePage = 'courses';

$errors = [];
$data   = [
    'slug'             => $course['slug'],
    'title'            => $course['title'],
    'description'      => $course['description'],
    'long_description' => $course['long_description'],
    'duration'         => $course['duration'],
    'students'         => $course['students'],
    'level'            => $course['level'],
    'tag'              => $course['tag'],
    'popular'          => $course['popular'],
    'instructor'       => $course['instructor'],
    'price'            => $course['price'],
    'syllabus'         => json_decode($course['syllabus'] ?? '[]', true) ?: [''],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $data['slug']             = trim($_POST['slug'] ?? '');
    $data['title']            = trim($_POST['title'] ?? '');
    $data['description']      = trim($_POST['description'] ?? '');
    $data['long_description'] = trim($_POST['long_description'] ?? '');
    $data['duration']         = trim($_POST['duration'] ?? '');
    $data['students']         = trim($_POST['students'] ?? '');
    $data['level']            = $_POST['level'] ?? 'Principiante';
    $data['tag']              = trim($_POST['tag'] ?? '');
    $data['popular']          = isset($_POST['popular']) ? 1 : 0;
    $data['instructor']       = trim($_POST['instructor'] ?? '');
    $data['price']            = trim($_POST['price'] ?? 'Consultar');
    $data['syllabus']         = array_values(array_filter(array_map('trim', $_POST['syllabus'] ?? []), fn($s) => $s !== ''));

    if (!$data['slug'])             $errors['slug']             = 'El slug es obligatorio.';
    if (!$data['title'])            $errors['title']            = 'El título es obligatorio.';
    if (!$data['description'])      $errors['description']      = 'La descripción corta es obligatoria.';
    if (!$data['long_description']) $errors['long_description'] = 'La descripción larga es obligatoria.';

    // Verificar slug único (excluyendo el actual)
    if (!isset($errors['slug'])) {
        $check = $db->prepare("SELECT id FROM courses WHERE slug = ? AND id != ?");
        $check->execute([$data['slug'], $id]);
        if ($check->fetch()) $errors['slug'] = 'El slug ya está en uso por otro curso.';
    }

    if (empty($errors)) {
        $stmt = $db->prepare("UPDATE courses SET
            slug=:slug, title=:title, description=:description,
            long_description=:long_description, duration=:duration, students=:students,
            level=:level, tag=:tag, popular=:popular, instructor=:instructor,
            price=:price, syllabus=:syllabus
            WHERE id=:id");

        $stmt->execute([
            ':slug'             => $data['slug'],
            ':title'            => $data['title'],
            ':description'      => $data['description'],
            ':long_description' => $data['long_description'],
            ':duration'         => $data['duration'],
            ':students'         => $data['students'],
            ':level'            => $data['level'],
            ':tag'              => $data['tag'],
            ':popular'          => $data['popular'],
            ':instructor'       => $data['instructor'],
            ':price'            => $data['price'],
            ':syllabus'         => json_encode($data['syllabus'], JSON_UNESCAPED_UNICODE),
            ':id'               => $id,
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'msg' => "Curso \"{$data['title']}\" actualizado."];
        header('Location: ' . PANEL_URL . '/courses/index.php');
        exit;
    }

    if (empty($data['syllabus'])) $data['syllabus'] = [''];
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= PANEL_URL ?>/courses/index.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">
        Editar curso
    </h2>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger mb-4">
    <strong>Corrige los siguientes errores:</strong>
    <ul class="mb-0 mt-1">
        <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" novalidate>
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <h3 style="font-size:0.9rem; font-weight:600; color:#a78bfa; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                    Información general
                </h3>
                <div class="mb-3">
                    <label class="form-label">Título <span style="color:#f87171">*</span></label>
                    <input type="text" name="title" class="form-control"
                           value="<?= htmlspecialchars($data['title']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug (URL) <span style="color:#f87171">*</span></label>
                    <input type="text" name="slug" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>"
                           value="<?= htmlspecialchars($data['slug']) ?>">
                    <?php if (isset($errors['slug'])): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errors['slug']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción corta <span style="color:#f87171">*</span></label>
                    <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($data['description']) ?></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">Descripción completa <span style="color:#f87171">*</span></label>
                    <textarea name="long_description" class="form-control" rows="5"><?= htmlspecialchars($data['long_description']) ?></textarea>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:0.9rem; font-weight:600; color:#a78bfa; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                    Temario (Syllabus)
                </h3>
                <div id="syllabusList">
                    <?php foreach ($data['syllabus'] as $i => $item): ?>
                    <div class="syllabus-item">
                        <input type="text" name="syllabus[]" class="form-control"
                               value="<?= htmlspecialchars($item) ?>"
                               placeholder="Tema <?= $i + 1 ?>">
                        <?php if ($i > 0): ?>
                        <button type="button" class="btn-remove-syllabus" onclick="removeSyllabus(this)">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="btn btn-sm btn-outline-light mt-2" onclick="addSyllabus()">
                    <i class="bi bi-plus-lg me-1"></i> Añadir tema
                </button>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card mb-4">
                <h3 style="font-size:0.9rem; font-weight:600; color:#a78bfa; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                    Detalles
                </h3>
                <div class="mb-3">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control" value="<?= htmlspecialchars($data['instructor']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Duración</label>
                    <input type="text" name="duration" class="form-control" value="<?= htmlspecialchars($data['duration']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Estudiantes</label>
                    <input type="text" name="students" class="form-control" value="<?= htmlspecialchars($data['students']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($data['price']) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nivel <span style="color:#f87171">*</span></label>
                    <select name="level" class="form-select">
                        <?php foreach (['Principiante','Intermedio','Avanzado'] as $lvl): ?>
                        <option value="<?= $lvl ?>" <?= $data['level'] === $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" name="tag" class="form-control" value="<?= htmlspecialchars($data['tag']) ?>">
                </div>
                <div class="form-check" style="margin-top:8px">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular"
                           <?= $data['popular'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="popular" style="color:#c4c4e0; font-size:0.85rem">
                        Curso destacado
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-accent w-100 mb-3">
                <i class="bi bi-check-lg me-2"></i> Guardar cambios
            </button>
            <a href="<?= PANEL_URL ?>/courses/delete.php?id=<?= $id ?>"
               class="btn w-100"
               style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                <i class="bi bi-trash me-2"></i> Eliminar curso
            </a>
        </div>
    </div>
</form>

<script>
let syllabusCount = <?= count($data['syllabus']) ?>;

function addSyllabus() {
    syllabusCount++;
    const list = document.getElementById('syllabusList');
    const div  = document.createElement('div');
    div.className = 'syllabus-item';
    div.innerHTML = `
        <input type="text" name="syllabus[]" class="form-control" placeholder="Tema ${syllabusCount}">
        <button type="button" class="btn-remove-syllabus" onclick="removeSyllabus(this)">
            <i class="bi bi-x-lg"></i>
        </button>`;
    list.appendChild(div);
    div.querySelector('input').focus();
}

function removeSyllabus(btn) {
    btn.closest('.syllabus-item').remove();
}
</script>

<?php require_once dirname(__DIR__) . '/includes/footer.php'; ?>
