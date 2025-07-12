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
    $session_token = trim($input['session_token'] ?? '');
    
    if (empty($session_token)) {
        throw new Exception('Session token diperlukan');
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Find valid session
    $query = "SELECT s.id, s.admin_id, s.session_token, s.expires_at, s.created_at,
                     a.username, a.full_name, a.email, a.phone, a.role, a.status, a.last_login
              FROM admin_sessions s
              INNER JOIN admins a ON s.admin_id = a.id
              WHERE s.session_token = :session_token 
              AND s.expires_at > NOW() 
              AND a.status = 'active'";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':session_token', $session_token);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Session tidak sah atau telah tamat tempoh');
    }
    
    $session_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Session sah',
        'data' => [
            'admin' => [
                'id' => $session_data['admin_id'],
                'username' => $session_data['username'],
                'full_name' => $session_data['full_name'],
                'email' => $session_data['email'],
                'phone' => $session_data['phone'],
                'role' => $session_data['role'],
                'status' => $session_data['status'],
                'last_login' => $session_data['last_login']
            ],
            'session' => [
                'token' => $session_data['session_token'],
                'expires_at' => $session_data['expires_at']
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