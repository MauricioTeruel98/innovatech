CREATE TABLE IF NOT EXISTS course_modalities (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    icon        VARCHAR(50),
    title       VARCHAR(150) NOT NULL,
    description TEXT,
    sort_order  INT          NOT NULL DEFAULT 0,
    active      TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
