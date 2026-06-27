-- Bloques de contenido tipo tarjeta para InnovaLabs:
-- category = pillar (servicios) | solution (soluciones) | process (pasos) | feature (beneficios)
CREATE TABLE IF NOT EXISTS lab_blocks (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    site        VARCHAR(20)  NOT NULL DEFAULT 'labs',
    category    VARCHAR(30)  NOT NULL,
    icon        VARCHAR(50),
    title       VARCHAR(150) NOT NULL,
    description TEXT,
    extra       VARCHAR(255),
    sort_order  INT          NOT NULL DEFAULT 0,
    active      TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_cat (site, category, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
