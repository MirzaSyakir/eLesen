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

// Validate required fields
$required_fields = ['full_name', 'email', 'ic_number', 'phone', 'status'];
foreach ($required_fields as $field) {
    if (empty($input[$field])) {
        echo json_encode([
            'status' => 400,
            'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required'
        ]);
        exit;
    }
}

try {
    $pdo = getConnection();
    
    // Check if user exists
    $check_sql = "SELECT id FROM users WHERE id = ?";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([$user_id]);
    
    if (!$check_stmt->fetch()) {
        echo json_encode([
            'status' => 404,
            'message' => 'User not found'
        ]);
        exit;
    }
    
    // Check if email is already taken by another user
    $email_check_sql = "SELECT id FROM users WHERE email = ? AND id != ?";
    $email_check_stmt = $pdo->prepare($email_check_sql);
    $email_check_stmt->execute([$input['email'], $user_id]);
    
    if ($email_check_stmt->fetch()) {
        echo json_encode([
            'status' => 400,
            'message' => 'Email is already taken by another user'
        ]);
        exit;
    }
    
    // Build update query
    $update_fields = [
        'full_name = ?',
        'email = ?',
        'ic_number = ?',
        'phone = ?',
        'address = ?',
        'status = ?',
        'updated_at = NOW()'
    ];
    
    $params = [
        $input['full_name'],
        $input['email'],
        $input['ic_number'],
        $input['phone'],
        $input['address'] ?? '',
        $input['status']
    ];
    
    // Add password update if provided
    if (!empty($input['password'])) {
        $update_fields[] = 'password = ?';
        $params[] = $input['password'];
    }
    
    $params[] = $user_id; // For WHERE clause
    
    $sql = "UPDATE users SET " . implode(', ', $update_fields) . " WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($params);
    
    if ($result) {
        echo json_encode([
            'status' => 200,
            'message' => 'User updated successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 500,
            'message' => 'Failed to update user'
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