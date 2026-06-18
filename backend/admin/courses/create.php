<?php
require_once dirname(__DIR__) . '/includes/auth_guard.php';
require_once dirname(__DIR__, 2) . '/config/database.php';

$pageTitle  = 'Nuevo curso';
$activePage = 'courses-create';

$errors = [];
$data   = [
    'slug' => '', 'title' => '', 'description' => '', 'long_description' => '',
    'duration' => '', 'students' => '', 'level' => 'Principiante',
    'tag' => '', 'popular' => 0, 'instructor' => '', 'price' => 'Consultar',
    'syllabus' => [''],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    // Recoger datos
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
    $data['syllabus']         = array_filter(array_map('trim', $_POST['syllabus'] ?? []), fn($s) => $s !== '');

    // Validaciones
    if (!$data['slug'])    $errors['slug']  = 'El slug es obligatorio.';
    if (!$data['title'])   $errors['title'] = 'El título es obligatorio.';
    if (!$data['description'])      $errors['description'] = 'La descripción corta es obligatoria.';
    if (!$data['long_description']) $errors['long_description'] = 'La descripción larga es obligatoria.';
    if (!in_array($data['level'], ['Principiante','Intermedio','Avanzado'])) $errors['level'] = 'Nivel inválido.';

    // Verificar slug único
    if (!isset($errors['slug'])) {
        $check = getDB()->prepare("SELECT id FROM courses WHERE slug = ?");
        $check->execute([$data['slug']]);
        if ($check->fetch()) $errors['slug'] = 'El slug ya está en uso.';
    }

    if (empty($errors)) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO courses
            (slug, title, description, long_description, duration, students, level, tag, popular, instructor, price, syllabus)
            VALUES
            (:slug, :title, :description, :long_description, :duration, :students, :level, :tag, :popular, :instructor, :price, :syllabus)");

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
            ':syllabus'         => json_encode(array_values($data['syllabus']), JSON_UNESCAPED_UNICODE),
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'msg' => "Curso \"{$data['title']}\" creado correctamente."];
        header('Location: ' . PANEL_URL . '/courses/index.php');
        exit;
    }

    // Mantener syllabus como array para el formulario
    if (empty($data['syllabus'])) $data['syllabus'] = [''];
    else $data['syllabus'] = array_values($data['syllabus']);
}

require_once dirname(__DIR__) . '/includes/header.php';
?>

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="<?= PANEL_URL ?>/courses/index.php" class="btn btn-outline-light btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 style="font-size:1rem; font-weight:600; color:#fff; margin:0">Nuevo curso</h2>
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
        <!-- Columna izquierda -->
        <div class="col-lg-8">
            <div class="form-card mb-4">
                <h3 style="font-size:0.9rem; font-weight:600; color:#a78bfa; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                    Información general
                </h3>
                <div class="mb-3">
                    <label class="form-label">Título <span style="color:#f87171">*</span></label>
                    <input type="text" name="title" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                           value="<?= htmlspecialchars($data['title']) ?>"
                           placeholder="Ej: Fundamentos de Inteligencia Artificial"
                           oninput="autoSlug(this)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug (URL) <span style="color:#f87171">*</span></label>
                    <input type="text" name="slug" id="slugField" class="form-control <?= isset($errors['slug']) ? 'is-invalid' : '' ?>"
                           value="<?= htmlspecialchars($data['slug']) ?>"
                           placeholder="ia-fundamentos">
                    <div style="font-size:0.75rem; color:#8b8bae; margin-top:4px">
                        Solo minúsculas, números y guiones. Se auto-genera al escribir el título.
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción corta <span style="color:#f87171">*</span></label>
                    <textarea name="description" class="form-control" rows="2"
                              placeholder="Descripción breve que aparece en las tarjetas del sitio."><?= htmlspecialchars($data['description']) ?></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">Descripción completa <span style="color:#f87171">*</span></label>
                    <textarea name="long_description" class="form-control" rows="5"
                              placeholder="Descripción larga que aparece en la página de detalle del curso."><?= htmlspecialchars($data['long_description']) ?></textarea>
                </div>
            </div>

            <!-- Temario / Syllabus -->
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

        <!-- Columna derecha -->
        <div class="col-lg-4">
            <div class="form-card mb-4">
                <h3 style="font-size:0.9rem; font-weight:600; color:#a78bfa; margin-bottom:20px; text-transform:uppercase; letter-spacing:0.06em">
                    Detalles
                </h3>
                <div class="mb-3">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control"
                           value="<?= htmlspecialchars($data['instructor']) ?>"
                           placeholder="Dr. Alejandro Ruiz">
                </div>
                <div class="mb-3">
                    <label class="form-label">Duración</label>
                    <input type="text" name="duration" class="form-control"
                           value="<?= htmlspecialchars($data['duration']) ?>"
                           placeholder="8 semanas">
                </div>
                <div class="mb-3">
                    <label class="form-label">Estudiantes</label>
                    <input type="text" name="students" class="form-control"
                           value="<?= htmlspecialchars($data['students']) ?>"
                           placeholder="120+">
                </div>
                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="text" name="price" class="form-control"
                           value="<?= htmlspecialchars($data['price']) ?>"
                           placeholder="Consultar">
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
                    <input type="text" name="tag" class="form-control"
                           value="<?= htmlspecialchars($data['tag']) ?>"
                           placeholder="IA, Desarrollo, Data Science…">
                </div>
                <div class="form-check" style="margin-top:8px">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular"
                           <?= $data['popular'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="popular" style="color:#c4c4e0; font-size:0.85rem">
                        Curso destacado
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-accent w-100">
                <i class="bi bi-check-lg me-2"></i> Crear curso
            </button>
        </div>
    </div>
</form>

<script>
let syllabusCount = <?= count($data['syllabus']) ?>;

function autoSlug(input) {
    const slug = input.value
        .toLowerCase()
        .normalize('NFD').replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .slice(0, 80);
    document.getElementById('slugField').value = slug;
}

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
