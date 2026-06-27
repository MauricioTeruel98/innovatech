CREATE TABLE IF NOT EXISTS site_settings (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    section       VARCHAR(40)  NOT NULL,
    setting_key   VARCHAR(80)  NOT NULL,
    setting_value LONGTEXT,
    type          VARCHAR(20)  NOT NULL DEFAULT 'text',
    label         VARCHAR(190),
    help          VARCHAR(255),
    sort_order    INT          NOT NULL DEFAULT 0,
    updated_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_section_key (section, setting_key),
    INDEX idx_section (section)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
