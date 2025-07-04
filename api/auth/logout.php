<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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
    
    // Delete session from database
    $delete_query = "DELETE FROM user_sessions WHERE session_token = :token";
    $delete_stmt = $db->prepare($delete_query);
    $delete_stmt->bindParam(':token', $token);
    $delete_stmt->execute();
    
    echo json_encode([
        'status' => 200,
        'message' => 'Log keluar berjaya'
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