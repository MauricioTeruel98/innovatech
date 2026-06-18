<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — Innovatech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* ── Paleta extraída del frontend ─────────────────────────────────────
           Primary:   hsl(200,100%,26%) = #005282  (navy teal)
           Secondary: hsl(177,83%,29%)  = #0d8070  (teal)
           Gradient:  linear-gradient(135deg, #005282, #0d8070)
        ──────────────────────────────────────────────────────────────────── */
        :root {
            --primary:      #005282;
            --primary-dark: #003d61;
            --secondary:    #0d8070;
            --gradient:     linear-gradient(135deg, #005282 0%, #0d8070 100%);

            --bg-base:   #050e1a;
            --sidebar-bg:#071525;
            --surface:   #0c2035;
            --surface2:  #112844;
            --border:    #1a3a55;
            --text:      #d8eaf5;
            --text-muted:#5d8aaa;
            --sidebar-w: 260px;
        }

        /* ── Bootstrap overrides: forzar tema oscuro correctamente ── */
        body {
            --bs-body-bg:          var(--bg-base);
            --bs-body-color:       var(--text);
            --bs-table-bg:         transparent;
            --bs-table-color:      var(--text);
            --bs-table-striped-bg: transparent;
            --bs-table-hover-bg:   rgba(0,82,130,0.08);
            --bs-border-color:     var(--border);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-base);
            color: var(--text);
            min-height: 100vh;
            margin: 0;
        }

        /* ── Sidebar ──────────────────────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-brand .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .sidebar-brand .brand-sub {
            font-size: 0.68rem;
            color: #4db8a0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 2px;
        }
        .logo-dot {
            display: inline-block;
            width: 9px; height: 9px;
            border-radius: 50%;
            background: var(--gradient);
            margin-right: 5px;
            vertical-align: middle;
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }

        .nav-label {
            font-size: 0.63rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            padding: 10px 10px 4px;
            font-weight: 600;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: #8cb8d4;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }
        .nav-item a:hover {
            background: var(--surface);
            color: #fff;
        }
        .nav-item a.active {
            background: var(--gradient);
            color: #fff;
            box-shadow: 0 4px 14px rgba(0,82,130,0.45);
        }
        .nav-item a i { font-size: 1rem; width: 18px; }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--border);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            color: #f87171;
            text-decoration: none;
            font-size: 0.85rem;
            transition: background 0.15s;
        }
        .sidebar-footer a:hover { background: rgba(248,113,113,0.1); }

        /* ── Layout principal ─────────────────────────────────────────────── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: var(--sidebar-bg);
            border-bottom: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar .page-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }
        .topbar .admin-badge {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 0.78rem;
            color: #4db8a0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .content-area { padding: 28px; flex: 1; }

        /* ── Stat cards ───────────────────────────────────────────────────── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px 24px;
            transition: border-color 0.2s, transform 0.2s;
        }
        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        .stat-card .stat-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            background: rgba(0,82,130,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            color: #4db8a0;
            margin-bottom: 14px;
        }
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }
        .stat-card .stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Tablas ───────────────────────────────────────────────────────── */
        .data-table {
            background: var(--surface) !important;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        /* Forzar oscuro en toda la tabla, neutralizando Bootstrap light theme */
        .data-table .table {
            --bs-table-bg: transparent !important;
            --bs-table-color: var(--text) !important;
            --bs-table-hover-bg: rgba(0,82,130,0.1) !important;
            --bs-table-striped-bg: transparent !important;
            margin-bottom: 0 !important;
            color: var(--text) !important;
        }
        .data-table thead th {
            background: var(--surface2) !important;
            color: var(--text-muted) !important;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 12px 16px;
            border-color: var(--border) !important;
            font-weight: 600;
        }
        .data-table tbody td {
            background: transparent !important;
            color: var(--text) !important;
            padding: 14px 16px;
            border-color: var(--border) !important;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        .data-table tbody tr {
            background-color: transparent !important;
        }
        .data-table tbody tr:hover td {
            background: rgba(0,82,130,0.1) !important;
        }

        /* ── Badges ───────────────────────────────────────────────────────── */
        .badge-level {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .badge-principiante { background: rgba(13,128,112,0.2); color: #4db8a0; border: 1px solid rgba(13,128,112,0.3); }
        .badge-intermedio    { background: rgba(251,191,36,0.15);  color: #fbbf24; border: 1px solid rgba(251,191,36,0.2); }
        .badge-avanzado      { background: rgba(239,68,68,0.15);   color: #f87171; border: 1px solid rgba(239,68,68,0.2); }

        .badge-tag {
            background: rgba(0,82,130,0.25);
            color: #5bbee0;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid rgba(0,82,130,0.35);
        }

        /* ── Formularios ──────────────────────────────────────────────────── */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
        }
        .form-label { color: #a8c8e0; font-size: 0.85rem; font-weight: 500; margin-bottom: 6px; }
        .form-control, .form-select {
            background: var(--surface2) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 8px;
            font-size: 0.875rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(0,82,130,0.25) !important;
            color: var(--text) !important;
        }
        .form-control::placeholder { color: var(--text-muted) !important; }
        .form-select option { background: var(--surface2); color: var(--text); }

        .form-check-input {
            background-color: var(--surface2) !important;
            border-color: var(--border) !important;
        }
        .form-check-input:checked {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* ── Botones ──────────────────────────────────────────────────────── */
        .btn-accent {
            background: var(--gradient);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 0.875rem;
            transition: opacity 0.15s, transform 0.1s;
        }
        .btn-accent:hover { opacity: 0.88; color: #fff; transform: translateY(-1px); }

        .btn-outline-light {
            border-color: var(--border) !important;
            color: #8cb8d4 !important;
            background: transparent !important;
        }
        .btn-outline-light:hover {
            background: var(--surface2) !important;
            color: #fff !important;
            border-color: var(--primary) !important;
        }

        /* Botón editar en tabla */
        .btn-edit {
            background: rgba(0,82,130,0.2);
            border: 1px solid var(--border);
            color: #5bbee0;
            border-radius: 6px;
            padding: 4px 10px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            transition: background 0.15s;
        }
        .btn-edit:hover { background: rgba(0,82,130,0.4); color: #fff; }

        .btn-delete {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.2);
            color: #f87171;
            border-radius: 6px;
            padding: 4px 10px;
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            transition: background 0.15s;
        }
        .btn-delete:hover { background: rgba(239,68,68,0.25); color: #fff; }

        /* ── Alertas ──────────────────────────────────────────────────────── */
        .alert-success {
            background: rgba(13,128,112,0.15) !important;
            border-color: rgba(13,128,112,0.35) !important;
            color: #4db8a0 !important;
        }
        .alert-danger {
            background: rgba(239,68,68,0.12) !important;
            border-color: rgba(239,68,68,0.3) !important;
            color: #f87171 !important;
        }
        .btn-close { filter: invert(1) grayscale(1); }

        /* ── Syllabus ─────────────────────────────────────────────────────── */
        .syllabus-item { display: flex; gap: 8px; margin-bottom: 8px; }
        .syllabus-item .form-control { flex: 1; }
        .btn-remove-syllabus {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.2);
            color: #f87171;
            border-radius: 6px;
            padding: 0 10px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-remove-syllabus:hover { background: rgba(239,68,68,0.25); }

        /* ── Invalid feedback ─────────────────────────────────────────────── */
        .is-invalid { border-color: #f87171 !important; }
        .invalid-feedback { color: #f87171 !important; font-size: 0.78rem; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrap { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name"><span class="logo-dot"></span>Innova<strong>Tech</strong></div>
        <div class="brand-sub">Panel de administración</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Principal</div>
        <div class="nav-item">
            <a href="<?= PANEL_URL ?>/index.php"
               class="<?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </div>

        <div class="nav-label" style="margin-top:12px">Contenido</div>
        <div class="nav-item">
            <a href="<?= PANEL_URL ?>/courses/index.php"
               class="<?= ($activePage ?? '') === 'courses' ? 'active' : '' ?>">
                <i class="bi bi-mortarboard"></i> Cursos
            </a>
        </div>
        <div class="nav-item">
            <a href="<?= PANEL_URL ?>/courses/create.php"
               class="<?= ($activePage ?? '') === 'courses-create' ? 'active' : '' ?>">
                <i class="bi bi-plus-circle"></i> Nuevo curso
            </a>
        </div>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= PANEL_URL ?>/profile.php"
           style="color:#8cb8d4; margin-bottom:4px"
           class="<?= ($activePage ?? '') === 'profile' ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> Mi perfil
        </a>
        <a href="<?= PANEL_URL ?>/logout.php">
            <i class="bi bi-box-arrow-left"></i> Cerrar sesión
        </a>
    </div>
</aside>

<!-- Main -->
<div class="main-wrap">
    <header class="topbar">
        <h1 class="page-title"><?= htmlspecialchars($pageTitle ?? 'Admin') ?></h1>
        <div class="admin-badge">
            <i class="bi bi-person-circle"></i>
            <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>
        </div>
    </header>
    <main class="content-area">
