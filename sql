CREATE DATABASE IF NOT EXISTS your_database_name; -- Replace with your actual database name
USE your_database_name;

CREATE TABLE IF NOT EXISTS newsletters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
