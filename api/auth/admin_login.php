<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'message' => 'Method not allowed'
    ]);
    exit;
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Invalid JSON input');
    }
    
    // Validate required fields
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        throw new Exception('Nama pengguna dan kata laluan diperlukan');
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Find admin by username
    $query = "SELECT id, username, full_name, email, phone, role, password_hash, status, last_login, created_at 
              FROM admins 
              WHERE username = :username AND status = 'active'";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Nama pengguna atau kata laluan tidak sah');
    }
    
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verify password
    if (!password_verify($password, $admin['password_hash'])) {
        throw new Exception('Nama pengguna atau kata laluan tidak sah');
    }
    
    // Generate session token
    $session_token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    // Store session in database
    $session_query = "INSERT INTO admin_sessions (admin_id, session_token, expires_at) 
                      VALUES (:admin_id, :session_token, :expires_at)";
    
    $session_stmt = $db->prepare($session_query);
    $session_stmt->bindParam(':admin_id', $admin['id']);
    $session_stmt->bindParam(':session_token', $session_token);
    $session_stmt->bindParam(':expires_at', $expires_at);
    $session_stmt->execute();
    
    // Update last login
    $update_query = "UPDATE admins SET last_login = NOW() WHERE id = :admin_id";
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':admin_id', $admin['id']);
    $update_stmt->execute();
    
    // Remove password hash from response
    unset($admin['password_hash']);
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Log masuk berjaya',
        'data' => [
            'admin' => $admin,
            'session' => [
                'token' => $session_token,
                'expires_at' => $expires_at
            ]
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 400,
        'message' => $e->getMessage()
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 500,
        'message' => 'Database error occurred'
    ]);
}
?> 