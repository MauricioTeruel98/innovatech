<?php
/**
 * Metadatos de las secciones de contenido editable (site_settings), por sitio.
 * Define orden, título legible e ícono (Bootstrap Icons) de cada sección que
 * aparece en el editor de "Contenido del sitio" del panel.
 */

function content_sections(string $site = 'institute'): array
{
    if ($site === 'labs') {
        return [
            'general'      => ['title' => 'General / Marca',          'icon' => 'bi-globe',            'desc' => 'Nombre, logo y bajada de InnovaLabs.'],
            'navbar'       => ['title' => 'Barra de navegación',      'icon' => 'bi-menu-button-wide', 'desc' => 'Textos del menú y botón de acción.'],
            'hero'         => ['title' => 'Portada (Hero)',           'icon' => 'bi-stars',            'desc' => 'Título, subtítulo, botones y estadísticas.'],
            'services'     => ['title' => 'Servicios (encabezado)',   'icon' => 'bi-grid-1x2',         'desc' => 'Encabezado de la sección de servicios.'],
            'solutions'    => ['title' => 'Soluciones (encabezado)',  'icon' => 'bi-boxes',            'desc' => 'Encabezado de la sección de soluciones.'],
            'process'      => ['title' => 'Proceso (encabezado)',     'icon' => 'bi-diagram-3',        'desc' => 'Encabezado de la sección de proceso.'],
            'features'     => ['title' => 'Características (encab.)',   'icon' => 'bi-patch-check',      'desc' => 'Encabezado de la sección de beneficios.'],
            'plans'        => ['title' => 'Planes (encabezado)',      'icon' => 'bi-tags',             'desc' => 'Encabezado de la sección de planes.'],
            'testimonials' => ['title' => 'Testimonios (encabezado)', 'icon' => 'bi-chat-quote',       'desc' => 'Encabezado de la sección de testimonios.'],
            'contact'      => ['title' => 'Contacto',                 'icon' => 'bi-envelope',         'desc' => 'Datos de contacto y formulario.'],
            'footer'       => ['title' => 'Pie de página',            'icon' => 'bi-layout-text-window-reverse', 'desc' => 'Descripción, derechos y enlaces.'],
        ];
    }

    return [
        'general'      => ['title' => 'General / Marca',                'icon' => 'bi-globe',         'desc' => 'Nombre del sitio y logo.'],
        'navbar'       => ['title' => 'Barra de navegación',           'icon' => 'bi-menu-button-wide', 'desc' => 'Textos y enlaces del menú superior.'],
        'hero'         => ['title' => 'Inicio · Portada (Hero)',       'icon' => 'bi-stars',         'desc' => 'Título, subtítulo, botones e imagen de fondo.'],
        'inspiration'  => ['title' => 'Inicio · Sección IA',           'icon' => 'bi-lightbulb',     'desc' => 'Bloque “La IA está transformando el mundo”.'],
        'modalities'   => ['title' => 'Inicio · Modalidades',          'icon' => 'bi-grid-3x3-gap',  'desc' => 'Encabezado de la sección de modalidades.'],
        'about'        => ['title' => 'Inicio · Sobre nosotros',       'icon' => 'bi-people',        'desc' => 'Encabezado de la sección “Sobre nosotros”.'],
        'popular'      => ['title' => 'Inicio · Cursos destacados',    'icon' => 'bi-star',          'desc' => 'Encabezado de la sección de cursos destacados.'],
        'testimonials' => ['title' => 'Inicio · Testimonios',          'icon' => 'bi-chat-quote',    'desc' => 'Encabezado de la sección de testimonios.'],
        'team'         => ['title' => 'Inicio · Equipo (encabezado)',   'icon' => 'bi-people',        'desc' => 'Encabezado de la sección de equipo.'],
        'softwaredev'  => ['title' => 'Inicio · Desarrollo de software','icon' => 'bi-code-slash',   'desc' => 'Bloque de servicios de desarrollo.'],
        'contact'      => ['title' => 'Contacto',                       'icon' => 'bi-envelope',      'desc' => 'Datos de contacto y formulario.'],
        'footer'       => ['title' => 'Pie de página',                  'icon' => 'bi-layout-text-window-reverse', 'desc' => 'Derechos y créditos del pie.'],
    ];
}

function content_section_title(string $code, string $site = 'institute'): string
{
    return content_sections($site)[$code]['title'] ?? ucfirst($code);
}
