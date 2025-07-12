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
    $application_id = intval($input['application_id'] ?? 0);
    $new_status = trim($input['new_status'] ?? '');
    $remarks = trim($input['remarks'] ?? '');
    
    if (empty($session_token)) {
        throw new Exception('Session token diperlukan');
    }
    
    if ($application_id <= 0) {
        throw new Exception('ID permohonan tidak sah');
    }
    
    if (empty($new_status)) {
        throw new Exception('Status baru diperlukan');
    }
    
    // Validate status
    $valid_statuses = ['pending', 'processing', 'approved', 'rejected'];
    if (!in_array($new_status, $valid_statuses)) {
        throw new Exception('Status tidak sah');
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
    
    $admin_id = $session_stmt->fetch(PDO::FETCH_ASSOC)['admin_id'];
    
    // Check if application exists and get current status
    $app_query = "SELECT id, status FROM license_applications WHERE id = :application_id";
    $app_stmt = $db->prepare($app_query);
    $app_stmt->bindParam(':application_id', $application_id);
    $app_stmt->execute();
    
    if ($app_stmt->rowCount() === 0) {
        throw new Exception('Permohonan tidak dijumpai');
    }
    
    $application = $app_stmt->fetch(PDO::FETCH_ASSOC);
    $old_status = $application['status'];
    
    // Start transaction
    $db->beginTransaction();
    
    try {
        // Update application status
        $update_query = "UPDATE license_applications 
                        SET status = :new_status, updated_at = NOW() 
                        WHERE id = :application_id";
        
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bindParam(':new_status', $new_status);
        $update_stmt->bindParam(':application_id', $application_id);
        $update_stmt->execute();
        
        // Record status change in history
        $history_query = "INSERT INTO application_status_history 
                         (application_id, admin_id, old_status, new_status, remarks) 
                         VALUES (:application_id, :admin_id, :old_status, :new_status, :remarks)";
        
        $history_stmt = $db->prepare($history_query);
        $history_stmt->bindParam(':application_id', $application_id);
        $history_stmt->bindParam(':admin_id', $admin_id);
        $history_stmt->bindParam(':old_status', $old_status);
        $history_stmt->bindParam(':new_status', $new_status);
        $history_stmt->bindParam(':remarks', $remarks);
        $history_stmt->execute();
        
        // Commit transaction
        $db->commit();
        
        // Return success response
        echo json_encode([
            'status' => 200,
            'message' => 'Status permohonan berjaya dikemas kini',
            'data' => [
                'application_id' => $application_id,
                'old_status' => $old_status,
                'new_status' => $new_status,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction
        $db->rollBack();
        throw $e;
    }
    
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