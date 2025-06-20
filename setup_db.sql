-- Run this SQL in your MySQL environment (phpMyAdmin or CLI)

CREATE DATABASE IF NOT EXISTS railway;

USE railway;

CREATE TABLE IF NOT EXISTS tour_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  officer_name VARCHAR(100),
  designation VARCHAR(100),
  leaving_date DATETIME,
  return_date DATETIME,
  purpose TEXT,
  location VARCHAR(100),
  type ENUM('duty', 'leave'),
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
