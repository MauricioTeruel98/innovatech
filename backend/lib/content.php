<?php
/**
 * Metadatos de las secciones de contenido editable (site_settings).
 * Define el orden, título legible e ícono (Bootstrap Icons) de cada sección
 * que aparece en el editor de "Contenido del sitio" del panel.
 */

function content_sections(): array
{
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

function content_section_title(string $code): string
{
    return content_sections()[$code]['title'] ?? ucfirst($code);
}
