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
    $ic_number = trim($input['ic_number'] ?? '');
    $password = $input['password'] ?? '';
    
    if (empty($ic_number) || empty($password)) {
        throw new Exception('Nombor IC dan kata laluan diperlukan');
    }
    
    // Validate IC number format (12 digits)
    if (!preg_match('/^\d{12}$/', $ic_number)) {
        throw new Exception('Nombor kad pengenalan mestilah 12 digit nombor');
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Find user by IC number
    $query = "SELECT id, full_name, ic_number, phone, email, address, postcode, city, state, password_hash, status, created_at 
              FROM users 
              WHERE ic_number = :ic_number AND status = 'active'";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':ic_number', $ic_number);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Nombor kad pengenalan atau kata laluan tidak sah');
    }
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verify password
    if (!password_verify($password, $user['password_hash'])) {
        throw new Exception('Nombor kad pengenalan atau kata laluan tidak sah');
    }
    
    // Generate session token
    $session_token = bin2hex(random_bytes(32));
    $expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    // Store session in database
    $session_query = "INSERT INTO user_sessions (user_id, session_token, expires_at) 
                      VALUES (:user_id, :session_token, :expires_at)";
    
    $session_stmt = $db->prepare($session_query);
    $session_stmt->bindParam(':user_id', $user['id']);
    $session_stmt->bindParam(':session_token', $session_token);
    $session_stmt->bindParam(':expires_at', $expires_at);
    $session_stmt->execute();
    
    // Remove password hash from response
    unset($user['password_hash']);
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Log masuk berjaya',
        'data' => [
            'user' => $user,
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