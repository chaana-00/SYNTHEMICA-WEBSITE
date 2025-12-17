-- Install Composer + PHPMailer (recommended)
-- ==========================================================
-- cd C:\wamp64\www\MEDIVESTA-WEBSITE
-- composer require phpmailer/phpmailer

CREATE DATABASE medivesta_db;
USE medivesta_db;

CREATE TABLE subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE career_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    position VARCHAR(150) DEFAULT 'Application',
    message TEXT,
    cv_file VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `contact_messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,   -- Selected service (dropdown)
  `message` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

