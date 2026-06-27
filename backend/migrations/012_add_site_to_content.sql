-- Dimensión "site" para soportar múltiples sitios (institute | labs) con el mismo panel.

ALTER TABLE site_settings ADD COLUMN site VARCHAR(20) NOT NULL DEFAULT 'institute' AFTER id;
ALTER TABLE site_settings DROP INDEX uniq_section_key;
ALTER TABLE site_settings ADD UNIQUE KEY uniq_site_section_key (site, section, setting_key);
ALTER TABLE site_settings ADD INDEX idx_site_section (site, section);

ALTER TABLE testimonials ADD COLUMN site VARCHAR(20) NOT NULL DEFAULT 'institute' AFTER id;
ALTER TABLE testimonials ADD INDEX idx_site (site);

ALTER TABLE menu_links ADD COLUMN site VARCHAR(20) NOT NULL DEFAULT 'institute' AFTER id;
ALTER TABLE menu_links ADD INDEX idx_site_loc (site, location);

ALTER TABLE contact_messages ADD COLUMN site VARCHAR(20) NOT NULL DEFAULT 'institute' AFTER id;
ALTER TABLE contact_messages ADD INDEX idx_site_read (site, is_read);
