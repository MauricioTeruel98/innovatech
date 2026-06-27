<?php
/**
 * Set curado de íconos (nombres de lucide-react) disponibles para elegir en el panel.
 * IMPORTANTE: esta lista debe mantenerse sincronizada con src/lib/icons.ts del frontend,
 * que es quien mapea cada nombre al componente real de lucide-react.
 */

function icon_options(): array
{
    return [
        // Generales / educación
        'Sparkles', 'Rocket', 'GraduationCap', 'BookOpen', 'Award', 'Trophy',
        'Lightbulb', 'Target', 'TrendingUp', 'Compass', 'Star', 'Heart',
        // Tecnología
        'Code2', 'Cpu', 'Database', 'Cloud', 'Shield', 'ShieldCheck',
        'Globe', 'Zap', 'Layers', 'Settings', 'Terminal', 'Braces',
        // Personas / modalidades
        'Users', 'User', 'UserCheck', 'Monitor', 'Radio', 'Building2',
        'Briefcase', 'Smartphone', 'Wifi', 'Video', 'Presentation', 'MessagesSquare',
        // Datos / diseño
        'BarChart3', 'PieChart', 'LineChart', 'PenTool', 'Palette', 'Figma',
        // Acción / contacto
        'ArrowRight', 'ArrowUpRight', 'CheckCircle2', 'Clock', 'Calendar',
        'MapPin', 'Mail', 'Phone', 'Send', 'Megaphone',
    ];
}

/**
 * Renderiza un <select> de íconos para los formularios del panel.
 */
function icon_select(string $name, string $current = '', string $extraClass = ''): string
{
    $html = '<select name="' . htmlspecialchars($name) . '" class="form-select ' . htmlspecialchars($extraClass) . '">';
    $html .= '<option value="">— Sin ícono —</option>';
    foreach (icon_options() as $icon) {
        $sel = ($icon === $current) ? ' selected' : '';
        $html .= '<option value="' . htmlspecialchars($icon) . '"' . $sel . '>' . htmlspecialchars($icon) . '</option>';
    }
    $html .= '</select>';
    return $html;
}
