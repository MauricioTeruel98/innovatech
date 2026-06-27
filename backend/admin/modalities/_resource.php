<?php
return [
    'table'    => 'course_modalities',
    'route'    => 'modalities',
    'title'    => 'Modalidades de estudio',
    'singular' => 'modalidad',
    'icon'     => 'bi-grid-3x3-gap',
    'order'    => 'sort_order, id',
    'fields'   => [
        'icon'        => ['label' => 'Ícono', 'type' => 'icon', 'list' => true],
        'title'       => ['label' => 'Título', 'type' => 'text', 'required' => true, 'list' => true],
        'description' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => true, 'list' => true],
        'sort_order'  => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'      => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
