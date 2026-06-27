<?php
return [
    'table'    => 'menu_links',
    'route'    => 'menu',
    'title'    => 'Menús y redes',
    'singular' => 'enlace',
    'icon'     => 'bi-link-45deg',
    'order'    => 'location, sort_order, id',
    'site_scoped' => true,
    'fields'   => [
        'location' => [
            'label' => 'Ubicación', 'type' => 'select', 'required' => true, 'list' => true,
            'options' => [
                'navbar_dropdown' => 'Menú · Desplegable “Cursos”',
                'social'          => 'Redes sociales (Contacto)',
            ],
            'help' => 'Dónde aparece este enlace.',
        ],
        'label'      => ['label' => 'Texto', 'type' => 'text', 'required' => true, 'list' => true],
        'url'        => ['label' => 'Enlace (URL)', 'type' => 'url', 'list' => true, 'help' => 'Interno (/cursos), ancla (#contacto) o externo (https://...). Vacío = sin enlace (ej. “próximamente”).'],
        'target'     => ['label' => 'Abrir en', 'type' => 'select', 'options' => ['_self' => 'Misma pestaña', '_blank' => 'Pestaña nueva'], 'default' => '_self'],
        'enabled'    => ['label' => 'Activo', 'type' => 'bool', 'default' => 1, 'list' => true, 'help' => 'Si está desactivado se muestra en gris (“próximamente”) en el desplegable.'],
        'sort_order' => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
    ],
];
