<?php
return [
    'table'       => 'lab_blocks',
    'route'       => 'process',
    'title'       => 'Proceso',
    'singular'    => 'paso',
    'icon'        => 'bi-diagram-3',
    'order'       => 'sort_order, id',
    'site_scoped' => true,
    'fixed'       => ['category' => 'process'],
    'fields'      => [
        'extra'       => ['label' => 'Número del paso', 'type' => 'text', 'help' => 'Ej: 01, 02…', 'list' => true],
        'icon'        => ['label' => 'Ícono', 'type' => 'icon', 'list' => true],
        'title'       => ['label' => 'Título', 'type' => 'text', 'required' => true, 'list' => true],
        'description' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => true, 'list' => true],
        'sort_order'  => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'      => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
