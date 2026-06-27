<?php
return [
    'table'    => 'about_values',
    'route'    => 'values',
    'title'    => 'Valores (Sobre nosotros)',
    'singular' => 'valor',
    'icon'     => 'bi-award',
    'order'    => 'sort_order, id',
    'fields'   => [
        'icon'        => ['label' => 'Ícono', 'type' => 'icon', 'list' => true],
        'title'       => ['label' => 'Título', 'type' => 'text', 'required' => true, 'list' => true],
        'description' => ['label' => 'Descripción', 'type' => 'textarea', 'required' => true, 'list' => true],
        'sort_order'  => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'      => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
