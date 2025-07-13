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
$new_status = $input['new_status'] ?? '';

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

if (!in_array($new_status, ['active', 'inactive'])) {
    echo json_encode([
        'status' => 400,
        'message' => 'Invalid status. Must be "active" or "inactive"'
    ]);
    exit;
}

try {
    $pdo = getConnection();
    
    // Check if user exists
    $check_sql = "SELECT id, status FROM users WHERE id = ?";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([$user_id]);
    $user = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode([
            'status' => 404,
            'message' => 'User not found'
        ]);
        exit;
    }
    
    // Update user status
    $sql = "UPDATE users SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$new_status, $user_id]);
    
    if ($result) {
        $status_text = $new_status === 'active' ? 'activated' : 'deactivated';
        echo json_encode([
            'status' => 200,
            'message' => "User successfully $status_text"
        ]);
    } else {
        echo json_encode([
            'status' => 500,
            'message' => 'Failed to update user status'
        ]);
    }
    
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
?> 