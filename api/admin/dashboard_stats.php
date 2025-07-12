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
    
    // Validate session token
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
    
    // Validate admin session
    $session_query = "SELECT admin_id FROM admin_sessions 
                      WHERE session_token = :session_token 
                      AND expires_at > NOW()";
    
    $session_stmt = $db->prepare($session_query);
    $session_stmt->bindParam(':session_token', $session_token);
    $session_stmt->execute();
    
    if ($session_stmt->rowCount() === 0) {
        throw new Exception('Session tidak sah atau telah tamat tempoh');
    }
    
    // Get dashboard statistics
    $stats = [];
    
    // Total applications
    $total_query = "SELECT COUNT(*) as total FROM license_applications";
    $total_stmt = $db->prepare($total_query);
    $total_stmt->execute();
    $stats['total_applications'] = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Pending applications
    $pending_query = "SELECT COUNT(*) as pending FROM license_applications WHERE status = 'pending'";
    $pending_stmt = $db->prepare($pending_query);
    $pending_stmt->execute();
    $stats['pending_applications'] = $pending_stmt->fetch(PDO::FETCH_ASSOC)['pending'];
    
    // Processing applications
    $processing_query = "SELECT COUNT(*) as processing FROM license_applications WHERE status = 'processing'";
    $processing_stmt = $db->prepare($processing_query);
    $processing_stmt->execute();
    $stats['processing_applications'] = $processing_stmt->fetch(PDO::FETCH_ASSOC)['processing'];
    
    // Approved applications
    $approved_query = "SELECT COUNT(*) as approved FROM license_applications WHERE status = 'approved'";
    $approved_stmt = $db->prepare($approved_query);
    $approved_stmt->execute();
    $stats['approved_applications'] = $approved_stmt->fetch(PDO::FETCH_ASSOC)['approved'];
    
    // Rejected applications
    $rejected_query = "SELECT COUNT(*) as rejected FROM license_applications WHERE status = 'rejected'";
    $rejected_stmt = $db->prepare($rejected_query);
    $rejected_stmt->execute();
    $stats['rejected_applications'] = $rejected_stmt->fetch(PDO::FETCH_ASSOC)['rejected'];
    
    // Total users
    $users_query = "SELECT COUNT(*) as total_users FROM users WHERE status = 'active'";
    $users_stmt = $db->prepare($users_query);
    $users_stmt->execute();
    $stats['total_users'] = $users_stmt->fetch(PDO::FETCH_ASSOC)['total_users'];
    
    // Recent applications (last 5)
    $recent_query = "SELECT la.id, la.application_number, la.license_type, la.business_name, 
                            la.status, la.created_at, u.full_name as applicant_name
                     FROM license_applications la
                     INNER JOIN users u ON la.user_id = u.id
                     ORDER BY la.created_at DESC
                     LIMIT 5";
    $recent_stmt = $db->prepare($recent_query);
    $recent_stmt->execute();
    $stats['recent_applications'] = $recent_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Applications by status (for chart)
    $status_query = "SELECT status, COUNT(*) as count 
                     FROM license_applications 
                     GROUP BY status";
    $status_stmt = $db->prepare($status_query);
    $status_stmt->execute();
    $stats['applications_by_status'] = $status_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Applications by month (last 6 months)
    $monthly_query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
                      FROM license_applications 
                      WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                      GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                      ORDER BY month";
    $monthly_stmt = $db->prepare($monthly_query);
    $monthly_stmt->execute();
    $stats['applications_by_month'] = $monthly_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Statistics retrieved successfully',
        'data' => $stats
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