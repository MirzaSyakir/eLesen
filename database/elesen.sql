-- eLesen Database Schema
-- Created for eLesen License Management System

-- -- Create database if not exists
CREATE DATABASE IF NOT EXISTS elesen_db;
USE elesen_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    ic_number VARCHAR(12) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255),
    address TEXT NOT NULL,
    postcode VARCHAR(5) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(50) NOT NULL,
    warna_kad_pengenalan ENUM('Biru', 'Merah', 'Hijau', 'Kuning', 'Lain-lain') DEFAULT 'Biru',
    tarikh_lahir DATE,
    umur INT,
    agama VARCHAR(50),
    passport_photo VARCHAR(255),
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active'
);

-- Sessions table for managing user sessions
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- License applications table (updated for full permohonan)
CREATE TABLE IF NOT EXISTS license_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    application_number VARCHAR(30) UNIQUE NOT NULL,
    license_number VARCHAR(30),
    license_type VARCHAR(100) NOT NULL,
    processing_type VARCHAR(50),
    business_name VARCHAR(255),
    business_address TEXT,
    building_type VARCHAR(50),
    operation_year INT,
    premise_size DECIMAL(10,2),
    position VARCHAR(100),
    ssm_registration ENUM('Ada','Tiada'),
    no_ssm VARCHAR(50),
    male_workers INT DEFAULT 0,
    female_workers INT DEFAULT 0,
    has_signboard ENUM('Ya','Tidak'),
    signboard_type VARCHAR(50),
    signboard_size VARCHAR(50),
    applicant_name VARCHAR(255),
    applicant_ic VARCHAR(20),
    ssm_file VARCHAR(255),
    plan_file VARCHAR(255),
    ic_file VARCHAR(255),
    receipt_file VARCHAR(255),
    tax_file VARCHAR(255),
    signboard_file VARCHAR(255),
    health_file VARCHAR(255),
    land_file VARCHAR(255),
    owner_file VARCHAR(255),
    halal_file VARCHAR(255),
    status_borang ENUM('draft', 'submit') DEFAULT 'draft',
    status ENUM('pending', 'processing', 'approved', 'rejected') DEFAULT 'pending',
    approved_at TIMESTAMP NULL,
    expiry_date DATE NULL,
    license_fee DECIMAL(10,2) DEFAULT 0.00,
    payment_status ENUM('pending', 'paid', 'overdue') DEFAULT 'pending',
    payment_date TIMESTAMP NULL,
    approved_by INT NULL,
    approval_remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES admins(id) ON DELETE SET NULL
);

-- Admin table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(15),
    role ENUM('super_admin', 'admin', 'officer') DEFAULT 'officer',
    password_hash VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admin sessions table
CREATE TABLE IF NOT EXISTS admin_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
);

-- Application status history table for tracking changes
CREATE TABLE IF NOT EXISTS application_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    admin_id INT,
    old_status ENUM('pending', 'processing', 'approved', 'rejected'),
    new_status ENUM('pending', 'processing', 'approved', 'rejected'),
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES license_applications(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL
);

-- Insert sample data for testing
INSERT INTO users (full_name, ic_number, phone, email, address, postcode, city, state, warna_kad_pengenalan, tarikh_lahir, umur, agama, password_hash) VALUES
('Ahmad bin Abdullah', '900101015432', '0123456789', 'ahmad@example.com', 'No. 123, Jalan Besar, Kampung Baru', '17000', 'Pasir Mas', 'Kelantan', 'Biru', '1990-01-01', 34, 'Islam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('Siti binti Mohamed', '850202025678', '0198765432', 'siti@example.com', 'No. 456, Taman Damai, Jalan Sultan', '15000', 'Kota Bharu', 'Kelantan', 'Merah', '1985-02-02', 39, 'Islam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

-- Insert sample license applications
INSERT INTO license_applications (user_id, application_number, license_number, license_type, business_name, business_address, status, approved_at, expiry_date, license_fee, payment_status, payment_date) VALUES
(1, 'LPT-2024-001', 'LPT-2024-001', 'Lesen Perniagaan Premis Tetap', 'Kedai Runcit Ahmad', 'No. 123, Jalan Besar, Kampung Baru, 17000 Pasir Mas, Kelantan', 'processing', NULL, NULL, 0.00, 'pending', NULL),
(1, 'LPJ-2024-002', 'LPJ-2024-002', 'Lesen Penjaja', 'Gerai Makan Ahmad', 'Pasar Besar Pasir Mas, 17000 Pasir Mas, Kelantan', 'approved', '2024-01-10 14:20:00', '2025-01-10', 100.00, 'paid', '2024-01-10 14:20:00'),
(2, 'PS-2024-003', 'PS-2024-003', 'Permit Sementara', 'Gerai Siti', 'Taman Damai, 15000 Kota Bharu, Kelantan', 'approved', '2024-01-05 09:15:00', '2024-07-05', 75.00, 'paid', '2024-01-05 09:15:00');

-- Insert sample admin data
INSERT INTO admins (username, full_name, email, phone, role, password_hash) VALUES
('admin', 'Administrator Sistem', 'admin@elesen.gov.my', '0123456789', 'super_admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('officer1', 'Pegawai 1', 'officer1@elesen.gov.my', '0123456790', 'officer', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('officer2', 'Pegawai 2', 'officer2@elesen.gov.my', '0123456791', 'officer', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

--
-- If you are migrating an existing database, run the following SQL to add the passport_photo column:
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS passport_photo VARCHAR(255) AFTER agama;
