<?php
return [
    'table'       => 'lab_blocks',
    'route'       => 'services',
    'title'       => 'Servicios',
    'singular'    => 'servicio',
    'icon'        => 'bi-grid-1x2',
    'order'       => 'sort_order, id',
    'site_scoped' => true,
    'fixed'       => ['category' => 'pillar'],
    'fields'      => [
        'icon'        => ['label' => 'Ícono', 'type' => 'icon', 'list' => true],
        'title'       => ['label' => 'Título', 'type' => 'text', 'required' => true, 'list' => true],
        'description' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => true, 'list' => true],
        'sort_order'  => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'      => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
