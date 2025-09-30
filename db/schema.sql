-- Schema for Accommodation Search (MySQL 8+)
-- Ensure utf8mb4 for multilingual support (Latin, Middle Eastern, Asian)

CREATE DATABASE IF NOT EXISTS accommodations
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE accommodations;

-- Base table for all accommodations
CREATE TABLE IF NOT EXISTS accommodation (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  type ENUM('hotel','apartment') NOT NULL,
  name VARCHAR(255) NOT NULL,
  city VARCHAR(128) NOT NULL,
  province VARCHAR(128) NOT NULL,
  PRIMARY KEY (id),
  INDEX idx_accommodation_name (name)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- Hotel-specific details
CREATE TABLE IF NOT EXISTS hotel_details (
  accommodation_id BIGINT UNSIGNED NOT NULL,
  stars TINYINT UNSIGNED NOT NULL,
  standard_room_type ENUM('single','double','double_view','suite','family') NOT NULL,
  PRIMARY KEY (accommodation_id),
  CONSTRAINT fk_hotel_accommodation
    FOREIGN KEY (accommodation_id) REFERENCES accommodation(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- Apartment-specific details
CREATE TABLE IF NOT EXISTS apartment_details (
  accommodation_id BIGINT UNSIGNED NOT NULL,
  num_units INT UNSIGNED NOT NULL,
  capacity_adults INT UNSIGNED NOT NULL,
  PRIMARY KEY (accommodation_id),
  CONSTRAINT fk_apartment_accommodation
    FOREIGN KEY (accommodation_id) REFERENCES accommodation(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


