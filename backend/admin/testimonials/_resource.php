<?php
return [
    'table'    => 'testimonials',
    'route'    => 'testimonials',
    'title'    => 'Testimonios',
    'singular' => 'testimonio',
    'icon'     => 'bi-chat-quote',
    'order'    => 'sort_order, id',
    'fields'   => [
        'name'       => ['label' => 'Nombre', 'type' => 'text', 'required' => true, 'list' => true],
        'role'       => ['label' => 'Rol / ocupación', 'type' => 'text', 'list' => true],
        'quote'      => ['label' => 'Testimonio', 'type' => 'textarea', 'required' => true, 'list' => true],
        'rating'     => ['label' => 'Estrellas (1 a 5)', 'type' => 'number', 'default' => 5, 'list' => true],
        'photo_path' => ['label' => 'Foto (opcional)', 'type' => 'image', 'subdir' => 'testimonials'],
        'sort_order' => ['label' => 'Orden', 'type' => 'number', 'default' => 0, 'list' => true],
        'active'     => ['label' => 'Visible', 'type' => 'bool', 'default' => 1, 'list' => true],
    ],
];
