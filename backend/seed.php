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

// ── Ajustes de contenido del sitio (site_settings) ──────────────────────────────
// [section, key, value, type, label, help, sort_order]
$settings = [
    // General / marca
    ['general', 'site_name', 'Instituto Innova Tech', 'text', 'Nombre del sitio', '', 0],
    ['general', 'logo', '', 'image', 'Logo principal', 'Se usa en la barra de navegación y el pie. Vacío = logo por defecto.', 1],
    ['general', 'logo_alt', 'Instituto Innova Tech', 'text', 'Texto alternativo del logo', '', 2],

    // Hero
    ['hero', 'badge_text', 'Formación en tecnología e IA', 'text', 'Texto de la insignia', '', 0],
    ['hero', 'heading_part1', 'Impulsa tu futuro con ', 'text', 'Título — primera parte', 'Color sólido. Dejá el espacio final.', 1],
    ['hero', 'heading_highlight', 'tecnología', 'text', 'Título — palabra destacada', 'Se muestra con degradado de color.', 2],
    ['hero', 'subheading', 'Cursos y capacitaciones diseñados para prepararte en las habilidades más demandadas del mercado.', 'textarea', 'Subtítulo', '', 3],
    ['hero', 'primary_cta_label', 'Ver cursos', 'text', 'Botón principal — texto', '', 4],
    ['hero', 'primary_cta_url', '/cursos', 'url', 'Botón principal — enlace', '', 5],
    ['hero', 'secondary_cta_label', 'Conocenos', 'text', 'Botón secundario — texto', '', 6],
    ['hero', 'secondary_cta_url', '#nosotros', 'url', 'Botón secundario — enlace', '', 7],
    ['hero', 'background_image', '', 'image', 'Imagen de fondo', 'Vacío = imagen por defecto.', 8],

    // Inspiración (IA)
    ['inspiration', 'title_highlight', 'La IA está transformando el mundo.', 'text', 'Título — parte destacada', 'Con degradado.', 0],
    ['inspiration', 'title_rest', '¿Estás preparado para el cambio?', 'text', 'Título — parte normal', '', 1],
    ['inspiration', 'quote', '«El futuro pertenece a quienes se preparan hoy. La inteligencia artificial no reemplaza personas, reemplaza a quienes no se adaptan.»', 'textarea', 'Cita destacada', '', 2],
    ['inspiration', 'body_paragraph', 'En Instituto Innova Tech creemos que la educación tecnológica es la herramienta más poderosa para construir un futuro profesional sólido. Nuestros cursos están diseñados para que domines las tecnologías que están redefiniendo las industrias.', 'textarea', 'Párrafo descriptivo', '', 3],
    ['inspiration', 'image', '', 'image', 'Imagen', 'Vacío = imagen por defecto.', 4],
    ['inspiration', 'image_alt', 'Estudiante aprendiendo con inteligencia artificial', 'text', 'Texto alternativo de la imagen', '', 5],

    // Modalidades (encabezado; las tarjetas se editan en "Modalidades")
    ['modalities', 'heading_highlight', 'Modalidades', 'text', 'Título — palabra destacada', '', 0],
    ['modalities', 'heading_rest', 'de estudio', 'text', 'Título — parte normal', '', 1],
    ['modalities', 'subheading', 'Elegí la forma de aprender que mejor se adapte a tu estilo de vida y objetivos profesionales.', 'textarea', 'Subtítulo', '', 2],

    // Sobre nosotros (encabezado; las tarjetas se editan en "Valores")
    ['about', 'heading', 'Sobre', 'text', 'Título — parte normal', '', 0],
    ['about', 'heading_highlight', 'nosotros', 'text', 'Título — palabra destacada', '', 1],
    ['about', 'subheading', 'Somos un instituto especializado en formación tecnológica, comprometidos con la excelencia educativa y el desarrollo profesional de cada estudiante.', 'textarea', 'Subtítulo', '', 2],

    // Testimonios (encabezado; las tarjetas se editan en "Testimonios")
    ['testimonials', 'heading', 'Lo que dicen nuestros', 'text', 'Título — parte normal', '', 0],
    ['testimonials', 'heading_highlight', 'estudiantes', 'text', 'Título — palabra destacada', '', 1],

    // Equipo (encabezado; los miembros se editan en "Equipo")
    ['team', 'heading', 'Nuestro', 'text', 'Título — parte normal', '', 0],
    ['team', 'heading_highlight', 'equipo', 'text', 'Título — palabra destacada', '', 1],
    ['team', 'subheading', 'Profesionales apasionados por la educación y la tecnología.', 'textarea', 'Subtítulo', '', 2],

    // Cursos destacados (encabezado)
    ['popular', 'badge_text', 'Los más elegidos', 'text', 'Texto de la insignia', '', 0],
    ['popular', 'heading', 'Cursos más', 'text', 'Título — parte normal', '', 1],
    ['popular', 'heading_highlight', 'demandados', 'text', 'Título — palabra destacada', '', 2],
    ['popular', 'subheading', 'Descubrí los cursos que más eligen nuestros estudiantes para impulsar su carrera en tecnología.', 'textarea', 'Subtítulo', '', 3],
    ['popular', 'cta_label', 'Ver todos los cursos', 'text', 'Botón — texto', '', 4],

    // Desarrollo de software
    ['softwaredev', 'icon', 'Code2', 'icon', 'Ícono', '', 0],
    ['softwaredev', 'heading', 'Desarrollo de Software a medida', 'text', 'Título', '', 1],
    ['softwaredev', 'description', 'Además de la formación, ofrecemos servicios profesionales de desarrollo de software. Creamos soluciones digitales personalizadas para tu negocio: aplicaciones web, móviles, sistemas de gestión y más.', 'textarea', 'Descripción', '', 2],
    ['softwaredev', 'cta_label', 'Conocer más', 'text', 'Botón — texto', '', 3],
    ['softwaredev', 'cta_url', 'https://example.com', 'url', 'Botón — enlace', 'Abre en una pestaña nueva.', 4],

    // Barra de navegación (los ítems del desplegable de cursos se editan en "Menús")
    ['navbar', 'home_label', 'Inicio', 'text', 'Inicio — texto', '', 0],
    ['navbar', 'home_url', '/', 'url', 'Inicio — enlace', '', 1],
    ['navbar', 'courses_label', 'Cursos', 'text', 'Cursos (desplegable) — texto', '', 2],
    ['navbar', 'about_label', 'Quiénes somos', 'text', 'Quiénes somos — texto', '', 3],
    ['navbar', 'about_url', '#nosotros', 'url', 'Quiénes somos — enlace', '', 4],
    ['navbar', 'software_label', 'Desarrollo de software', 'text', 'Desarrollo de software — texto', '', 5],
    ['navbar', 'software_url', 'https://example.com', 'url', 'Desarrollo de software — enlace', 'Abre en una pestaña nueva.', 6],
    ['navbar', 'contact_label', 'Contacto', 'text', 'Contacto — texto', '', 7],
    ['navbar', 'contact_url', '#contacto', 'url', 'Contacto — enlace', '', 8],

    // Contacto
    ['contact', 'heading', 'Contacto', 'text', 'Título', '', 0],
    ['contact', 'subheading', '¿Tenés alguna consulta? Escribinos y te responderemos a la brevedad.', 'textarea', 'Subtítulo', '', 1],
    ['contact', 'address', 'Tucumán, Argentina', 'text', 'Dirección', '', 2],
    ['contact', 'email', 'info@institutoinnovatech.com', 'text', 'Email de contacto (visible)', '', 3],
    ['contact', 'phone', '+54 381 465 3130', 'text', 'Teléfono', '', 4],
    ['contact', 'map_embed_url', '', 'url', 'URL del mapa (Google Maps embed)', 'Opcional. Si la completás, se muestra un mapa embebido.', 5],
    ['contact', 'notification_email', 'info@institutoinnovatech.com', 'text', 'Email para recibir mensajes', 'A esta dirección llegan los mensajes del formulario.', 6],
    ['contact', 'success_message', 'Mensaje enviado. ¡Gracias por contactarnos!', 'text', 'Mensaje de confirmación', 'Se muestra al enviar el formulario.', 7],
    ['contact', 'form_name_label', 'Nombre', 'text', 'Formulario — etiqueta Nombre', '', 8],
    ['contact', 'form_email_label', 'Email', 'text', 'Formulario — etiqueta Email', '', 9],
    ['contact', 'form_message_label', 'Mensaje', 'text', 'Formulario — etiqueta Mensaje', '', 10],
    ['contact', 'form_submit_label', 'Enviar mensaje', 'text', 'Formulario — texto del botón', '', 11],

    // Pie de página
    ['footer', 'copyright_text', 'Instituto Innova Tech. Todos los derechos reservados.', 'text', 'Texto de derechos', 'El año se agrega automáticamente al inicio.', 0],
    ['footer', 'developed_by_label', 'Desarrollado por', 'text', "Texto 'Desarrollado por'", '', 1],
    ['footer', 'developed_by_name', 'InnovaLabs', 'text', 'Nombre del desarrollador', '', 2],
];

$stmt = $db->prepare(
    "INSERT IGNORE INTO site_settings (section, setting_key, setting_value, type, label, help, sort_order)
     VALUES (:section, :setting_key, :setting_value, :type, :label, :help, :sort_order)"
);
$nSettings = 0;
foreach ($settings as $s) {
    $stmt->execute([
        ':section' => $s[0], ':setting_key' => $s[1], ':setting_value' => $s[2],
        ':type' => $s[3], ':label' => $s[4], ':help' => $s[5], ':sort_order' => $s[6],
    ]);
    $nSettings += $stmt->rowCount();
}
echo "[OK]  $nSettings ajustes de contenido insertados (" . count($settings) . " definidos).\n";

// ── Colecciones (solo si la tabla está vacía, para no duplicar) ─────────────────
function seed_collection(PDO $db, string $table, string $columns, array $rows): void
{
    $count = (int) $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    if ($count > 0) {
        echo "[SKIP] $table ya tiene datos.\n";
        return;
    }
    $cols = array_map('trim', explode(',', $columns));
    $placeholders = implode(', ', array_map(fn($c) => ":$c", $cols));
    $stmt = $db->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    foreach ($rows as $row) {
        $params = [];
        foreach ($cols as $i => $c) $params[":$c"] = $row[$i];
        $stmt->execute($params);
    }
    echo "[OK]  " . count($rows) . " registros en $table.\n";
}

seed_collection($db, 'team_members', 'name, role, initials, sort_order', [
    ['Alejandro Ruiz', 'Director General', 'AR', 0],
    ['Sofía Torres', 'Directora Académica', 'ST', 1],
    ['Martín López', 'Lead Instructor', 'ML', 2],
    ['Valentina Díaz', 'Coordinadora de Cursos', 'VD', 3],
]);

seed_collection($db, 'testimonials', 'name, role, quote, rating, sort_order', [
    ['María González', 'Desarrolladora Web', 'Gracias a Innova Tech pude hacer la transición a tecnología. Los cursos son prácticos y los instructores excelentes.', 5, 0],
    ['Carlos Méndez', 'Data Analyst', 'La calidad del contenido y el acompañamiento de los profesores superaron mis expectativas. 100% recomendado.', 5, 1],
    ['Laura Fernández', 'UX Designer', 'Empecé sin conocimientos técnicos y hoy trabajo en lo que me apasiona. El instituto me dio las herramientas que necesitaba.', 5, 2],
    ['Diego Ramírez', 'Cloud Engineer', 'El curso de DevOps me permitió certificarme y conseguir un ascenso en menos de 6 meses. Totalmente vale la pena.', 5, 3],
    ['Ana Torres', 'Data Scientist', 'Python para Ciencia de Datos cambió mi carrera. Los proyectos prácticos me dieron la confianza para aplicar a empresas top.', 5, 4],
]);

seed_collection($db, 'about_values', 'icon, title, description, sort_order', [
    ['Target', 'Misión', 'Democratizar el acceso a educación tecnológica de calidad, preparando profesionales competitivos para el mercado actual.', 0],
    ['Lightbulb', 'Innovación', 'Actualizamos constantemente nuestros programas para incluir las últimas tendencias y herramientas del sector.', 1],
    ['TrendingUp', 'Resultados', 'Nuestros egresados aplican lo aprendido desde el primer día, con proyectos reales y habilidades demandadas.', 2],
]);

seed_collection($db, 'course_modalities', 'icon, title, description, sort_order', [
    ['Monitor', 'Online', 'Aprende a tu ritmo desde cualquier lugar con acceso 24/7 a todo el material del curso.', 0],
    ['Users', 'Presenciales', 'Clases prácticas con interacción directa y seguimiento personalizado de tu progreso.', 1],
    ['Radio', 'En vivo', 'Sesiones en tiempo real con instructores expertos. Resuelve tus dudas al instante.', 2],
    ['Building2', 'Para empresas', 'Programas de capacitación a medida para equipos corporativos y organizaciones.', 3],
]);

seed_collection($db, 'menu_links', 'location, label, url, target, enabled, sort_order', [
    ['navbar_dropdown', 'A distancia', '/cursos', '_self', 1, 0],
    ['navbar_dropdown', 'En vivo (próximamente)', '', '_self', 0, 1],
    ['navbar_dropdown', 'Presencial (próximamente)', '', '_self', 0, 2],
    ['navbar_dropdown', 'Para empresas (próximamente)', '', '_self', 0, 3],
    ['social', 'Instagram', '#', '_blank', 1, 0],
    ['social', 'LinkedIn', '#', '_blank', 1, 1],
    ['social', 'YouTube', '#', '_blank', 1, 2],
]);

// ════════════════════════════════════════════════════════════════════════════
//  InnovaLabs (site = 'labs')
// ════════════════════════════════════════════════════════════════════════════

// ── Ajustes de contenido de Labs ────────────────────────────────────────────────
// [section, key, value, type, label, help, sort_order]
$labsSettings = [
    ['general', 'site_name', 'InnovaLabs', 'text', 'Nombre del sitio', '', 0],
    ['general', 'tagline', 'Soluciones Digitales', 'text', 'Bajada de la marca (logo)', '', 1],
    ['general', 'logo', '', 'image', 'Logo personalizado', 'Vacío = se usa el logo de InnovaLabs por defecto.', 2],
    ['general', 'logo_alt', 'InnovaLabs', 'text', 'Texto alternativo del logo', '', 3],

    ['navbar', 'services_label', 'Servicios', 'text', 'Menú: Servicios', '', 0],
    ['navbar', 'solutions_label', 'Soluciones', 'text', 'Menú: Soluciones', '', 1],
    ['navbar', 'plans_label', 'Planes', 'text', 'Menú: Planes', '', 2],
    ['navbar', 'contact_label', 'Contacto', 'text', 'Menú: Contacto', '', 3],
    ['navbar', 'cta_label', 'Cotizar proyecto', 'text', 'Botón de acción (texto)', '', 4],
    ['navbar', 'cta_url', '#contacto', 'url', 'Botón de acción (enlace)', '', 5],

    ['hero', 'badge_text', 'Desarrollo web & soluciones digitales', 'text', 'Insignia', '', 0],
    ['hero', 'heading_part1', 'Construimos la web que tu ', 'text', 'Título — primera parte', 'Dejá el espacio final.', 1],
    ['hero', 'heading_highlight', 'negocio necesita', 'text', 'Título — palabra destacada', 'Con degradado.', 2],
    ['hero', 'subheading', 'Diseñamos, desarrollamos y mantenemos sitios web, tiendas online y plataformas a medida. Hosting, soporte y todo lo que necesitás, en un solo lugar.', 'textarea', 'Subtítulo', '', 3],
    ['hero', 'primary_cta_label', 'Cotizar mi proyecto', 'text', 'Botón principal — texto', '', 4],
    ['hero', 'primary_cta_url', '#contacto', 'url', 'Botón principal — enlace', '', 5],
    ['hero', 'secondary_cta_label', 'Ver servicios', 'text', 'Botón secundario — texto', '', 6],
    ['hero', 'secondary_cta_url', '#servicios', 'url', 'Botón secundario — enlace', '', 7],
    ['hero', 'stat1_value', '+120', 'text', 'Estadística 1 — número', '', 8],
    ['hero', 'stat1_label', 'Proyectos entregados', 'text', 'Estadística 1 — texto', '', 9],
    ['hero', 'stat2_value', '99.9%', 'text', 'Estadística 2 — número', '', 10],
    ['hero', 'stat2_label', 'Uptime de hosting', 'text', 'Estadística 2 — texto', '', 11],
    ['hero', 'stat3_value', '24/7', 'text', 'Estadística 3 — número', '', 12],
    ['hero', 'stat3_label', 'Soporte técnico', 'text', 'Estadística 3 — texto', '', 13],

    ['services', 'heading', 'Nuestros', 'text', 'Título — parte normal', '', 0],
    ['services', 'heading_highlight', 'servicios', 'text', 'Título — palabra destacada', '', 1],
    ['services', 'subheading', 'Todo lo que tu presencia digital necesita, de principio a fin.', 'textarea', 'Subtítulo', '', 2],

    ['solutions', 'heading', 'Soluciones a', 'text', 'Título — parte normal', '', 0],
    ['solutions', 'heading_highlight', 'tu medida', 'text', 'Título — palabra destacada', '', 1],
    ['solutions', 'subheading', 'Desarrollamos el tipo de plataforma que tu proyecto necesita.', 'textarea', 'Subtítulo', '', 2],

    ['process', 'heading', 'Cómo', 'text', 'Título — parte normal', '', 0],
    ['process', 'heading_highlight', 'trabajamos', 'text', 'Título — palabra destacada', '', 1],
    ['process', 'subheading', 'Un proceso claro y colaborativo, de la idea al lanzamiento.', 'textarea', 'Subtítulo', '', 2],

    ['features', 'heading', '¿Por qué', 'text', 'Título — parte normal', '', 0],
    ['features', 'heading_highlight', 'InnovaLabs?', 'text', 'Título — palabra destacada', '', 1],
    ['features', 'subheading', 'Tecnología moderna, diseño cuidado y soporte real.', 'textarea', 'Subtítulo', '', 2],

    ['plans', 'heading', 'Planes y', 'text', 'Título — parte normal', '', 0],
    ['plans', 'heading_highlight', 'precios', 'text', 'Título — palabra destacada', '', 1],
    ['plans', 'subheading', 'Opciones flexibles que se adaptan a cada etapa de tu negocio.', 'textarea', 'Subtítulo', '', 2],
    ['plans', 'note', '¿Necesitás algo a medida? Escribinos y armamos una propuesta para vos.', 'text', 'Nota al pie de los planes', '', 3],

    ['testimonials', 'heading', 'Lo que dicen nuestros', 'text', 'Título — parte normal', '', 0],
    ['testimonials', 'heading_highlight', 'clientes', 'text', 'Título — palabra destacada', '', 1],

    ['contact', 'heading', '¿Listo para', 'text', 'Título — parte normal', '', 0],
    ['contact', 'heading_highlight', 'empezar?', 'text', 'Título — palabra destacada', '', 1],
    ['contact', 'subheading', 'Contanos sobre tu proyecto y te enviamos una propuesta sin compromiso.', 'textarea', 'Subtítulo', '', 2],
    ['contact', 'address', 'Tucumán, Argentina', 'text', 'Dirección', '', 3],
    ['contact', 'email', 'labs@institutoinnovatech.com', 'text', 'Email de contacto (visible)', '', 4],
    ['contact', 'phone', '+54 381 465 3130', 'text', 'Teléfono', '', 5],
    ['contact', 'whatsapp', '5493814653130', 'text', 'WhatsApp (solo números, con código de país)', 'Genera el botón de WhatsApp. Vacío = sin botón.', 6],
    ['contact', 'notification_email', 'labs@institutoinnovatech.com', 'text', 'Email para recibir consultas', '', 7],
    ['contact', 'success_message', '¡Gracias! Te contactaremos a la brevedad.', 'text', 'Mensaje de confirmación', '', 8],
    ['contact', 'form_name_label', 'Nombre', 'text', 'Formulario — etiqueta Nombre', '', 9],
    ['contact', 'form_email_label', 'Email', 'text', 'Formulario — etiqueta Email', '', 10],
    ['contact', 'form_message_label', 'Contanos sobre tu proyecto', 'text', 'Formulario — etiqueta Mensaje', '', 11],
    ['contact', 'form_submit_label', 'Enviar consulta', 'text', 'Formulario — texto del botón', '', 12],

    ['footer', 'about_text', 'Estudio de desarrollo web del Instituto InnovaTech. Creamos soluciones digitales modernas para empresas y emprendedores.', 'textarea', 'Descripción del pie', '', 0],
    ['footer', 'copyright_text', 'InnovaLabs — Instituto InnovaTech. Todos los derechos reservados.', 'text', 'Texto de derechos', 'El año se agrega automáticamente.', 1],
    ['footer', 'developed_by_label', 'Parte de', 'text', "Texto 'Parte de'", '', 2],
    ['footer', 'developed_by_name', 'Instituto InnovaTech', 'text', 'Nombre del instituto', '', 3],
    ['footer', 'parent_url', 'https://institutoinnovatech.com', 'url', 'Enlace al sitio del instituto', '', 4],
];

$stmt = $db->prepare(
    "INSERT IGNORE INTO site_settings (site, section, setting_key, setting_value, type, label, help, sort_order)
     VALUES ('labs', :section, :setting_key, :setting_value, :type, :label, :help, :sort_order)"
);
$nLabs = 0;
foreach ($labsSettings as $s) {
    $stmt->execute([
        ':section' => $s[0], ':setting_key' => $s[1], ':setting_value' => $s[2],
        ':type' => $s[3], ':label' => $s[4], ':help' => $s[5], ':sort_order' => $s[6],
    ]);
    $nLabs += $stmt->rowCount();
}
echo "[OK]  $nLabs ajustes de Labs insertados (" . count($labsSettings) . " definidos).\n";

// ── Bloques de Labs (servicios, soluciones, proceso, características) ──────────────
seed_collection($db, 'lab_blocks', 'category, icon, title, description, extra, sort_order', [
    // Servicios (pillars)
    ['pillar', 'Code2', 'Desarrollo Web', 'Sitios y aplicaciones web rápidos, seguros y a medida, con las últimas tecnologías.', '', 0],
    ['pillar', 'Server', 'Hosting Web', 'Alojamiento confiable con certificado SSL, copias de seguridad y 99.9% de uptime.', '', 1],
    ['pillar', 'Wrench', 'Mantenimiento', 'Actualizaciones, soporte, monitoreo y mejoras continuas para que tu web nunca pare.', '', 2],
    // Soluciones (solutions)
    ['solution', 'Rocket', 'Landing Pages', 'Páginas de alto impacto orientadas a conversión para campañas y lanzamientos.', '', 0],
    ['solution', 'ShoppingCart', 'Tiendas Online', 'Ecommerce completo con pasarelas de pago, gestión de productos y envíos.', '', 1],
    ['solution', 'Building2', 'Webs Institucionales', 'Sitios corporativos profesionales que transmiten confianza y posicionan tu marca.', '', 2],
    ['solution', 'GraduationCap', 'Aulas Virtuales', 'Plataformas de e-learning con Moodle para capacitaciones y cursos online.', '', 3],
    // Proceso (process)
    ['process', 'Search', 'Análisis', 'Entendemos tu negocio, objetivos y público para definir la mejor solución.', '01', 0],
    ['process', 'PenTool', 'Diseño', 'Creamos una propuesta visual moderna, alineada a la identidad de tu marca.', '02', 1],
    ['process', 'Code2', 'Desarrollo', 'Programamos tu plataforma con código limpio, rápido y escalable.', '03', 2],
    ['process', 'Rocket', 'Lanzamiento', 'Publicamos, optimizamos y te acompañamos con soporte continuo.', '04', 3],
    // Características (feature)
    ['feature', 'Smartphone', 'Diseño responsive', 'Se ve perfecto en celulares, tablets y computadoras.', '', 0],
    ['feature', 'Gauge', 'Velocidad y SEO', 'Optimizado para cargar rápido y posicionar en Google.', '', 1],
    ['feature', 'ShieldCheck', 'Seguridad', 'SSL, copias de seguridad y buenas prácticas para proteger tu sitio.', '', 2],
    ['feature', 'Headphones', 'Soporte real', 'Te respondemos rápido, con personas, no con bots.', '', 3],
]);

// ── Planes de Labs ───────────────────────────────────────────────────────────────
seed_collection($db, 'lab_plans', 'name, price, period, description, features, highlighted, cta_label, cta_url, sort_order', [
    ['Landing Page', 'Consultar', 'pago único', 'Ideal para campañas y presencia inicial.',
        "1 página optimizada\nDiseño responsive\nFormulario de contacto\nSEO básico\nPublicación incluida", 0, 'Cotizar', '#contacto', 0],
    ['Sitio Profesional', 'Consultar', 'pago único', 'Para empresas que quieren destacar.',
        "Hasta 6 secciones\nDiseño a medida\nBlog / novedades\nSEO + Analytics\n3 meses de soporte", 1, 'Cotizar', '#contacto', 1],
    ['Hosting + Mantenimiento', 'Consultar', 'por mes', 'Mantené tu web online y al día.',
        "Hosting SSD + SSL\nCopias de seguridad\nActualizaciones\nMonitoreo 24/7\nSoporte prioritario", 0, 'Contratar', '#contacto', 2],
]);

// ── Testimonios de Labs (guardado por sitio, no duplicar) ─────────────────────────
if ((int) $db->query("SELECT COUNT(*) FROM testimonials WHERE site='labs'")->fetchColumn() === 0) {
    $t = $db->prepare("INSERT INTO testimonials (site, name, role, quote, rating, sort_order) VALUES ('labs', ?, ?, ?, ?, ?)");
    foreach ([
        ['Marcos Giordano', 'Dueño de tienda online', 'Mi ecommerce vende todos los días. El equipo entendió justo lo que necesitaba y lo entregó en tiempo.', 5, 0],
        ['Lucía Fernández', 'Directora de Marketing', 'La landing que armaron triplicó nuestras conversiones en la campaña. Diseño impecable.', 5, 1],
        ['Esteban Ríos', 'Coordinador académico', 'El aula virtual en Moodle nos permitió escalar los cursos online sin complicaciones.', 5, 2],
    ] as $row) { $t->execute($row); }
    echo "[OK]  3 testimonios de Labs.\n";
} else {
    echo "[SKIP] testimonials de Labs ya existen.\n";
}

// ── Redes de Labs ─────────────────────────────────────────────────────────────────
if ((int) $db->query("SELECT COUNT(*) FROM menu_links WHERE site='labs'")->fetchColumn() === 0) {
    $m = $db->prepare("INSERT INTO menu_links (site, location, label, url, target, enabled, sort_order) VALUES ('labs', 'social', ?, ?, '_blank', 1, ?)");
    foreach ([
        ['Instagram', '#', 0],
        ['LinkedIn', '#', 1],
        ['WhatsApp', 'https://wa.me/5493814653130', 2],
    ] as $row) { $m->execute($row); }
    echo "[OK]  3 redes de Labs.\n";
} else {
    echo "[SKIP] redes de Labs ya existen.\n";
}

echo "\nSeed completado.\n";
