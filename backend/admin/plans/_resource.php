<?php
return [
    'table'       => 'lab_plans',
    'route'       => 'plans',
    'title'       => 'Planes',
    'singular'    => 'plan',
    'icon'        => 'bi-tags',
    'order'       => 'sort_order, id',
    'site_scoped' => true,
    'fields'      => [
        'name'        => ['label' => 'Nombre del plan', 'type' => 'text', 'required' => true, 'list' => true],
        'price'       => ['label' => 'Precio', 'type' => 'text', 'help' => 'Ej: $25.000 o "Consultar".', 'list' => true],
        'period'      => ['label' => 'Período', 'type' => 'text', 'help' => 'Ej: por mes, pago único.', 'list' => true],
        'description' => ['label' => 'Descripción corta', 'type' => 'text'],
        'features'    => ['label' => 'Características', 'type' => 'textarea', 'help' => 'Una por línea. Cada línea se muestra con un tilde.'],
        'highlighted' => ['label' => 'Destacado', 'type' => 'bool', 'help' => 'Resalta el plan como recomendado.', 'list' => true],
        'cta_label'   => ['label' => 'Botón — texto', 'type' => 'text'],
        'cta_url'     => ['label' => 'Botón — enlace', 'type' => 'url'],
        'sort_order'  => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'      => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
