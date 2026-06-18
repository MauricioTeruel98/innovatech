<?php
/**
 * Runner de migraciones — ejecutar desde CLI:
 *   php migrate.php
 */

require_once __DIR__ . '/config/config.php';

// Conectar sin nombre de BD para poder crearla si no existe
$dsn = sprintf('mysql:host=%s;port=%s;charset=utf8mb4', DB_HOST, DB_PORT);
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DB_NAME . "`");
    echo "[OK] Base de datos '" . DB_NAME . "' lista.\n";
} catch (PDOException $e) {
    echo "[ERROR] No se pudo conectar: " . $e->getMessage() . "\n";
    exit(1);
}

// Crear tabla de migraciones si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL UNIQUE,
    ran_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

// Obtener migraciones ya ejecutadas
$ran = $pdo->query("SELECT filename FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

// Leer archivos SQL en orden
$files = glob(MIGRATIONS_DIR . '/*.sql');
sort($files);

$executed = 0;
foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $ran)) {
        echo "[SKIP] $name\n";
        continue;
    }

    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);
        $stmt = $pdo->prepare("INSERT INTO migrations (filename) VALUES (?)");
        $stmt->execute([$name]);
        echo "[RUN]  $name\n";
        $executed++;
    } catch (PDOException $e) {
        echo "[ERROR] $name: " . $e->getMessage() . "\n";
        exit(1);
    }
}

if ($executed === 0) {
    echo "No hay migraciones pendientes.\n";
} else {
    echo "\n$executed migración(es) ejecutada(s) correctamente.\n";
}
