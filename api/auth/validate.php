<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Authorization');

require_once '../config/database.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'message' => 'Method not allowed'
    ]);
    exit;
}

try {
    // Get authorization header
    $headers = getallheaders();
    $auth_header = $headers['Authorization'] ?? '';
    
    if (empty($auth_header) || !preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
        throw new Exception('Authorization token required');
    }
    
    $token = $matches[1];
    
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
    
    echo json_encode([
        'status' => 200,
        'message' => 'Session valid',
        'data' => [
            'user' => $user
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'status' => 401,
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