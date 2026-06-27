CREATE TABLE IF NOT EXISTS menu_links (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    location    VARCHAR(30)  NOT NULL,
    label       VARCHAR(120) NOT NULL,
    url         VARCHAR(255),
    target      VARCHAR(10)  NOT NULL DEFAULT '_self',
    enabled     TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order  INT          NOT NULL DEFAULT 0,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_location (location, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
