-- Create Database
CREATE DATABASE IF NOT EXISTS roadmap_saas;
USE roadmap_saas;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  subscription_type VARCHAR(50) DEFAULT 'free',
  target_country VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Applications Table
CREATE TABLE IF NOT EXISTS applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  university_name VARCHAR(255) NOT NULL,
  program_name VARCHAR(255) NOT NULL,
  country VARCHAR(100),
  deadline DATE,
  status VARCHAR(50) DEFAULT 'Planning',
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Scholarships Table
CREATE TABLE IF NOT EXISTS scholarships (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  country VARCHAR(100),
  eligibility_country VARCHAR(100),
  deadline DATE,
  link TEXT
);

-- Documents Table
CREATE TABLE IF NOT EXISTS documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  document_name VARCHAR(255) NOT NULL,
  is_completed TINYINT(1) DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
