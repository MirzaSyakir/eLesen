<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';
require_once '../auth/admin_validate.php';

// Validate admin session
$input = json_decode(file_get_contents('php://input'), true);
$session_token = $input['session_token'] ?? '';
$user_id = $input['user_id'] ?? '';

$admin_validation = validateAdminSession($session_token);
if ($admin_validation['status'] !== 200) {
    echo json_encode($admin_validation);
    exit;
}

if (empty($user_id)) {
    echo json_encode([
        'status' => 400,
        'message' => 'User ID is required'
    ]);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();
    $sql = "SELECT password_hash FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        echo json_encode([
            'status' => 404,
            'message' => 'User not found'
        ]);
        exit;
    }
    
    echo json_encode([
        'status' => 200,
        'message' => 'Password retrieved successfully',
        'data' => [
            'password' => $result['password_hash']
        ]
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'status' => 500,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 500,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
} 