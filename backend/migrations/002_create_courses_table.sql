CREATE TABLE IF NOT EXISTS courses (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    slug             VARCHAR(100)  NOT NULL UNIQUE,
    title            VARCHAR(255)  NOT NULL,
    description      TEXT,
    long_description TEXT,
    duration         VARCHAR(50),
    students         VARCHAR(50),
    level            ENUM('Principiante','Intermedio','Avanzado') NOT NULL DEFAULT 'Principiante',
    tag              VARCHAR(50),
    popular          TINYINT(1)    NOT NULL DEFAULT 0,
    instructor       VARCHAR(255),
    price            VARCHAR(100)  NOT NULL DEFAULT 'Consultar',
    syllabus         JSON,
    created_at       TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_popular (popular),
    INDEX idx_tag     (tag)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
