<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 405, 'message' => 'Method not allowed']);
    exit;
}

// Validate session token
$headers = getallheaders();
$auth_header = $headers['Authorization'] ?? '';

if (empty($auth_header) || !preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    http_response_code(401);
    echo json_encode(['status' => 401, 'message' => 'Authorization token required']);
    exit;
}

$token = $matches[1];

try {
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Check if session exists and is not expired
    $session_query = "SELECT us.user_id, us.expires_at, u.id, u.full_name, u.ic_number, u.phone, u.email, 
                             u.address, u.postcode, u.city, u.state, u.status, u.created_at, 
                             u.warna_kad_pengenalan, u.tarikh_lahir, u.umur, u.agama, u.passport_photo
                      FROM user_sessions us
                      JOIN users u ON us.user_id = u.id
                      WHERE us.session_token = :token 
                      AND us.expires_at > NOW()
                      AND u.status = 'active'";
    
    $session_stmt = $db->prepare($session_query);
    $session_stmt->bindParam(':token', $token);
    $session_stmt->execute();
    
    if ($session_stmt->rowCount() === 0) {
        throw new Exception('Invalid or expired session');
    }
    
    $user = $session_stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['id'];

    // Check if file was uploaded
    if (!isset($_FILES['passport_photo']) || $_FILES['passport_photo']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'No file uploaded or upload error']);
        exit;
    }

    $file = $_FILES['passport_photo'];
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($file['type'], $allowed_types)) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid file type. Only JPG, JPEG, and PNG are allowed']);
        exit;
    }
    
    // Validate file size (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'File too large. Maximum size is 5MB']);
        exit;
    }
    
    // Create uploads directory if it doesn't exist
    $upload_dir = '../../uploads/passport_photos/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'passport_' . $user_id . '_' . time() . '.' . $file_extension;
    $filepath = $upload_dir . $filename;
    
    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'Failed to save file']);
        exit;
    }
    
    // Get current passport photo to delete old one
    $stmt = $db->prepare("SELECT passport_photo FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $current_photo = $stmt->fetchColumn();
    
    // Delete old photo if exists
    if ($current_photo && file_exists('../../' . $current_photo)) {
        unlink('../../' . $current_photo);
    }
    
    // Update database with new photo path
    $relative_path = 'uploads/passport_photos/' . $filename;
    $stmt = $db->prepare("UPDATE users SET passport_photo = ? WHERE id = ?");
    $stmt->execute([$relative_path, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 200,
            'message' => 'Passport photo uploaded successfully',
            'data' => [
                'photo_path' => $relative_path,
                'photo_url' => '../' . $relative_path
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'Failed to update database']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Server error: ' . $e->getMessage()]);
}
?> 