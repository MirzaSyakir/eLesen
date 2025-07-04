<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config/database.php';

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 405, 'message' => 'Method not allowed']);
    exit();
}

try {
    // Get the authorization header
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    if (empty($authHeader) || !preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Authorization token required']);
        exit();
    }
    
    $token = $matches[1];
    
    // Validate the token and get user data
    $database = new Database();
    $db = $database->getConnection();
    
    // Check if token exists and is valid
    $stmt = $db->prepare("SELECT user_id, expires_at FROM user_sessions WHERE session_token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$session) {
        http_response_code(401);
        echo json_encode(['status' => 401, 'message' => 'Invalid or expired session']);
        exit();
    }
    
    $userId = $session['user_id'];
    
    // Get the request body
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid request data']);
        exit();
    }
    
    // Validate required fields
    $requiredFields = ['fullName', 'phone', 'address', 'postcode', 'city', 'state', 'warna_kad_pengenalan', 'tarikh_lahir', 'umur', 'agama'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            http_response_code(400);
            echo json_encode(['status' => 400, 'message' => "Field '$field' is required"]);
            exit();
        }
    }
    
    // Validate phone number format (Malaysian format)
    $phone = preg_replace('/[^0-9]/', '', $input['phone']);
    if (strlen($phone) < 9 || strlen($phone) > 11) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid phone number format']);
        exit();
    }
    
    // Validate postcode
    if (!preg_match('/^\d{5}$/', $input['postcode'])) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid postcode format']);
        exit();
    }
    
    // Validate email if provided
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid email format']);
        exit();
    }
    
    // Validate umur
    if (!is_numeric($input['umur']) || $input['umur'] < 0) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid umur value']);
        exit();
    }
    
    // Update user profile
    $stmt = $db->prepare("
        UPDATE users 
        SET full_name = ?, phone = ?, email = ?, address = ?, postcode = ?, city = ?, state = ?, warna_kad_pengenalan = ?, tarikh_lahir = ?, umur = ?, agama = ?, updated_at = NOW()
        WHERE id = ?
    ");
    
    $result = $stmt->execute([
        $input['fullName'],
        $input['phone'],
        $input['email'] ?? null,
        $input['address'],
        $input['postcode'],
        $input['city'],
        $input['state'],
        $input['warna_kad_pengenalan'],
        $input['tarikh_lahir'],
        $input['umur'],
        $input['agama'],
        $userId
    ]);
    
    if ($result) {
        // Get updated user data
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Remove sensitive data
        unset($user['password_hash']);
        
        http_response_code(200);
        echo json_encode([
            'status' => 200,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => $user
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'Failed to update profile']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 500, 'message' => 'Internal server error: ' . $e->getMessage()]);
}
?> 