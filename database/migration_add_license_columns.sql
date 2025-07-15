-- Migration script to add missing columns for license management
-- Run this script to update existing database

USE elesen_db;

-- Add missing columns to license_applications table
ALTER TABLE license_applications 
ADD COLUMN IF NOT EXISTS license_number VARCHAR(30) AFTER application_number,
ADD COLUMN IF NOT EXISTS approved_at TIMESTAMP NULL AFTER status,
ADD COLUMN IF NOT EXISTS expiry_date DATE NULL AFTER approved_at,
ADD COLUMN IF NOT EXISTS license_fee DECIMAL(10,2) DEFAULT 0.00 AFTER expiry_date,
ADD COLUMN IF NOT EXISTS payment_status ENUM('pending', 'paid', 'overdue') DEFAULT 'pending' AFTER license_fee,
ADD COLUMN IF NOT EXISTS payment_date TIMESTAMP NULL AFTER payment_status,
ADD COLUMN IF NOT EXISTS approved_by INT NULL AFTER payment_date,
ADD COLUMN IF NOT EXISTS approval_remarks TEXT AFTER approved_by;

-- Add foreign key for approved_by column
ALTER TABLE license_applications 
ADD CONSTRAINT fk_license_approved_by 
FOREIGN KEY (approved_by) REFERENCES admins(id) ON DELETE SET NULL;

-- Update existing approved applications to have approval date
UPDATE license_applications 
SET approved_at = updated_at 
WHERE status = 'approved' AND approved_at IS NULL;

-- Insert sample approved license data
INSERT INTO license_applications (
    user_id, 
    application_number, 
    license_number,
    license_type, 
    business_name, 
    business_address, 
    status,
    approved_at,
    expiry_date,
    license_fee,
    payment_status,
    payment_date
) VALUES 
(1, 'LESEN-2024-001', 'LPT-2024-001', 'Lesen Perniagaan Premis Tetap', 'Kedai Runcit Ahmad', 'No. 123, Jalan Besar, Kampung Baru, 17000 Pasir Mas, Kelantan', 'approved', '2024-01-15 10:30:00', '2025-01-15', 150.00, 'paid', '2024-01-15 10:30:00'),
(1, 'LESEN-2024-002', 'LPJ-2024-002', 'Lesen Penjaja', 'Gerai Makan Ahmad', 'Pasar Besar Pasir Mas, 17000 Pasir Mas, Kelantan', 'approved', '2024-01-10 14:20:00', '2025-01-10', 100.00, 'paid', '2024-01-10 14:20:00'),
(2, 'LESEN-2024-003', 'PS-2024-003', 'Permit Sementara', 'Gerai Siti', 'Taman Damai, 15000 Kota Bharu, Kelantan', 'approved', '2024-01-05 09:15:00', '2024-07-05', 75.00, 'paid', '2024-01-05 09:15:00')
ON DUPLICATE KEY UPDATE 
    license_number = VALUES(license_number),
    approved_at = VALUES(approved_at),
    expiry_date = VALUES(expiry_date),
    license_fee = VALUES(license_fee),
    payment_status = VALUES(payment_status),
    payment_date = VALUES(payment_date);

-- Create index for better performance
CREATE INDEX IF NOT EXISTS idx_license_user_status ON license_applications(user_id, status);
CREATE INDEX IF NOT EXISTS idx_license_approved_at ON license_applications(approved_at);
CREATE INDEX IF NOT EXISTS idx_license_expiry_date ON license_applications(expiry_date); 