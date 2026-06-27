<?php
/**
 * Contexto de "sitio" del panel: permite administrar el Instituto y InnovaLabs
 * desde el mismo panel, alternando con un switch. El sitio activo se guarda en
 * la sesión del admin.
 */

function admin_sites(): array
{
    return [
        'institute' => ['name' => 'Instituto InnovaTech', 'short' => 'Instituto', 'brand' => 'InnovaTech'],
        'labs'      => ['name' => 'InnovaLabs',            'short' => 'Labs',      'brand' => 'InnovaLabs'],
    ];
}

/** Sitio actualmente seleccionado en el panel (institute | labs). */
function current_site(): string
{
    $s = $_SESSION['admin_site'] ?? 'institute';
    return isset(admin_sites()[$s]) ? $s : 'institute';
}

function set_current_site(string $site): void
{
    if (isset(admin_sites()[$site])) {
        $_SESSION['admin_site'] = $site;
    }
}
