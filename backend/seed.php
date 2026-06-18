<?php
/**
 * Seed inicial — inserta los 6 cursos de Innovatech y el usuario admin por defecto.
 * Ejecutar desde CLI: php seed.php
 */

require_once __DIR__ . '/config/database.php';

$db = getDB();

// ── Admin por defecto ──────────────────────────────────────────────────────────
$adminUser = 'admin';
$adminPass = password_hash('admin123', PASSWORD_BCRYPT);

$stmt = $db->prepare("INSERT IGNORE INTO admin_users (username, password) VALUES (?, ?)");
$stmt->execute([$adminUser, $adminPass]);

if ($stmt->rowCount()) {
    echo "[OK] Usuario admin creado → usuario: admin / contraseña: admin123\n";
} else {
    echo "[SKIP] Usuario admin ya existe.\n";
}

// ── Cursos ────────────────────────────────────────────────────────────────────
$courses = [
    [
        'slug'             => 'ia-fundamentos',
        'title'            => 'Fundamentos de Inteligencia Artificial',
        'description'      => 'Aprende los conceptos esenciales de IA, machine learning y redes neuronales desde cero.',
        'long_description' => 'Este curso te introduce al fascinante mundo de la Inteligencia Artificial. Aprenderás desde los conceptos básicos hasta la implementación de modelos de machine learning, pasando por redes neuronales, procesamiento de lenguaje natural y visión por computadora. Ideal para quienes quieren entender cómo funciona la IA y comenzar a aplicarla en proyectos reales.',
        'duration'         => '8 semanas',
        'students'         => '120+',
        'level'            => 'Principiante',
        'tag'              => 'IA',
        'popular'          => 1,
        'instructor'       => 'Dr. Alejandro Ruiz',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'Introducción a la Inteligencia Artificial',
            'Fundamentos de Machine Learning',
            'Redes Neuronales y Deep Learning',
            'Procesamiento de Lenguaje Natural (NLP)',
            'Visión por Computadora',
            'Ética en IA',
            'Herramientas y frameworks: TensorFlow y PyTorch',
            'Proyecto final integrador',
        ]),
    ],
    [
        'slug'             => 'desarrollo-web',
        'title'            => 'Desarrollo Web Full Stack',
        'description'      => 'Domina HTML, CSS, JavaScript, React y Node.js para crear aplicaciones web completas.',
        'long_description' => 'Conviértete en un desarrollador web completo dominando tanto el frontend como el backend. Este curso cubre desde los fundamentos de HTML, CSS y JavaScript hasta frameworks modernos como React y Node.js. Aprenderás a construir aplicaciones web profesionales, gestionar bases de datos y desplegar tus proyectos en la nube.',
        'duration'         => '12 semanas',
        'students'         => '200+',
        'level'            => 'Intermedio',
        'tag'              => 'Desarrollo',
        'popular'          => 1,
        'instructor'       => 'Ing. Sofía Martínez',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'HTML5 y CSS3 avanzado',
            'JavaScript moderno (ES6+)',
            'React: componentes, hooks y estado',
            'Node.js y Express',
            'Bases de datos SQL y NoSQL',
            'APIs RESTful y GraphQL',
            'Autenticación y seguridad web',
            'Testing y despliegue',
            'Proyecto final: aplicación full stack',
        ]),
    ],
    [
        'slug'             => 'python-data',
        'title'            => 'Python para Ciencia de Datos',
        'description'      => 'Análisis de datos, visualización y machine learning con Python, Pandas y Scikit-learn.',
        'long_description' => 'Domina Python como herramienta principal para la ciencia de datos. Desde el análisis exploratorio hasta modelos predictivos, este curso te enseña a trabajar con grandes volúmenes de datos, crear visualizaciones impactantes y construir modelos de machine learning que generen valor para las organizaciones.',
        'duration'         => '10 semanas',
        'students'         => '85+',
        'level'            => 'Intermedio',
        'tag'              => 'Data Science',
        'popular'          => 1,
        'instructor'       => 'Lic. Martín Córdoba',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'Python fundamentals para datos',
            'NumPy y operaciones matriciales',
            'Pandas: manipulación de datos',
            'Visualización con Matplotlib y Seaborn',
            'Estadística aplicada',
            'Machine Learning con Scikit-learn',
            'Modelos de regresión y clasificación',
            'Proyecto final con datos reales',
        ]),
    ],
    [
        'slug'             => 'ciberseguridad',
        'title'            => 'Ciberseguridad Empresarial',
        'description'      => 'Protege sistemas y datos con técnicas de seguridad informática y ethical hacking.',
        'long_description' => 'Aprende a proteger infraestructuras tecnológicas y datos sensibles. Este curso abarca desde los fundamentos de la seguridad informática hasta técnicas avanzadas de ethical hacking, análisis de vulnerabilidades y respuesta ante incidentes. Prepárate para uno de los campos más demandados en tecnología.',
        'duration'         => '6 semanas',
        'students'         => '60+',
        'level'            => 'Avanzado',
        'tag'              => 'Seguridad',
        'popular'          => 0,
        'instructor'       => 'Ing. Roberto Díaz',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'Fundamentos de ciberseguridad',
            'Análisis de vulnerabilidades',
            'Ethical hacking y pentesting',
            'Seguridad en redes',
            'Criptografía aplicada',
            'Respuesta ante incidentes',
        ]),
    ],
    [
        'slug'             => 'ux-ui',
        'title'            => 'Diseño UX/UI',
        'description'      => 'Crea experiencias digitales centradas en el usuario con Figma, research y prototyping.',
        'long_description' => 'Aprende a diseñar productos digitales que enamoren a los usuarios. Este curso te enseña todo el proceso de diseño UX/UI: desde la investigación de usuarios y arquitectura de información hasta el prototipado interactivo en Figma. Ideal para quienes quieren crear interfaces atractivas y funcionales.',
        'duration'         => '8 semanas',
        'students'         => '95+',
        'level'            => 'Principiante',
        'tag'              => 'Diseño',
        'popular'          => 0,
        'instructor'       => 'Dis. Carolina López',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'Principios de diseño UX',
            'Investigación de usuarios',
            'Arquitectura de información',
            'Wireframing y prototyping',
            'Diseño visual y sistemas de diseño',
            'Figma avanzado',
            'Usability testing',
            'Portfolio y proyecto final',
        ]),
    ],
    [
        'slug'             => 'cloud-devops',
        'title'            => 'Cloud Computing & DevOps',
        'description'      => 'Domina AWS, Docker, Kubernetes y prácticas de integración y despliegue continuo.',
        'long_description' => 'Conviértete en un profesional de la nube y las prácticas DevOps. Aprenderás a diseñar arquitecturas en la nube con AWS, containerizar aplicaciones con Docker, orquestar con Kubernetes e implementar pipelines de CI/CD. Un curso esencial para quienes quieren dominar la infraestructura moderna.',
        'duration'         => '10 semanas',
        'students'         => '70+',
        'level'            => 'Avanzado',
        'tag'              => 'Cloud',
        'popular'          => 0,
        'instructor'       => 'Ing. Federico Paz',
        'price'            => 'Consultar',
        'syllabus'         => json_encode([
            'Introducción a Cloud Computing',
            'AWS: EC2, S3, Lambda, RDS',
            'Docker y containerización',
            'Kubernetes: orquestación de contenedores',
            'CI/CD con GitHub Actions',
            'Infraestructura como código (Terraform)',
            'Monitoreo y observabilidad',
            'Proyecto: deploy de aplicación completa',
        ]),
    ],
];

$sql = "INSERT IGNORE INTO courses
        (slug, title, description, long_description, duration, students, level, tag, popular, instructor, price, syllabus)
        VALUES
        (:slug, :title, :description, :long_description, :duration, :students, :level, :tag, :popular, :instructor, :price, :syllabus)";

$stmt = $db->prepare($sql);

foreach ($courses as $course) {
    $stmt->execute($course);
    $label = $stmt->rowCount() ? '[OK]  ' : '[SKIP]';
    echo "$label {$course['title']}\n";
}

echo "\nSeed completado.\n";
