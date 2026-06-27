-- Planes / precios de InnovaLabs (hosting, desarrollo, etc.)
CREATE TABLE IF NOT EXISTS lab_plans (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    site        VARCHAR(20)  NOT NULL DEFAULT 'labs',
    name        VARCHAR(120) NOT NULL,
    price       VARCHAR(60),
    period      VARCHAR(60),
    description VARCHAR(255),
    features    TEXT,
    highlighted TINYINT(1)   NOT NULL DEFAULT 0,
    cta_label   VARCHAR(80),
    cta_url     VARCHAR(255),
    sort_order  INT          NOT NULL DEFAULT 0,
    active      TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_order (site, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
