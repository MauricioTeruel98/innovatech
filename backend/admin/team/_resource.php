<?php
return [
    'table'    => 'team_members',
    'route'    => 'team',
    'title'    => 'Equipo',
    'singular' => 'miembro',
    'icon'     => 'bi-people',
    'order'    => 'sort_order, id',
    'fields'   => [
        'name'         => ['label' => 'Nombre', 'type' => 'text', 'required' => true, 'list' => true],
        'role'         => ['label' => 'Cargo', 'type' => 'text', 'list' => true],
        'initials'     => ['label' => 'Iniciales', 'type' => 'text', 'help' => 'Se muestran en el avatar si no hay foto (ej. AR).', 'list' => true],
        'photo_path'   => ['label' => 'Foto', 'type' => 'image', 'subdir' => 'team', 'help' => 'Opcional. Si la cargás, reemplaza a las iniciales.', 'list' => true],
        'linkedin_url' => ['label' => 'LinkedIn (URL)', 'type' => 'url', 'help' => 'Opcional. Enlace del botón de LinkedIn.'],
        'sort_order'   => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'       => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
