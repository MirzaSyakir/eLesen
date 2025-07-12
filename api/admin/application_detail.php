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
    
    if (empty($session_token)) {
        throw new Exception('Session token diperlukan');
    }
    
    if ($application_id <= 0) {
        throw new Exception('ID permohonan tidak sah');
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
    
    // Get detailed application information
    $query = "SELECT la.*, u.full_name, u.ic_number, u.phone, u.email, u.address, u.postcode, u.city, u.state
              FROM license_applications la
              INNER JOIN users u ON la.user_id = u.id
              WHERE la.id = :application_id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':application_id', $application_id);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Permohonan tidak dijumpai');
    }
    
    $application = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get status history
    $history_query = "SELECT ash.*, a.full_name as admin_name
                      FROM application_status_history ash
                      LEFT JOIN admins a ON ash.admin_id = a.id
                      WHERE ash.application_id = :application_id
                      ORDER BY ash.created_at DESC";
    
    $history_stmt = $db->prepare($history_query);
    $history_stmt->bindParam(':application_id', $application_id);
    $history_stmt->execute();
    
    $status_history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the response
    $response_data = [
        'application' => [
            'id' => $application['id'],
            'application_number' => $application['application_number'],
            'license_type' => $application['license_type'],
            'processing_type' => $application['processing_type'],
            'business_name' => $application['business_name'],
            'business_address' => $application['business_address'],
            'building_type' => $application['building_type'],
            'operation_year' => $application['operation_year'],
            'premise_size' => $application['premise_size'],
            'position' => $application['position'],
            'ssm_registration' => $application['ssm_registration'],
            'male_workers' => $application['male_workers'],
            'female_workers' => $application['female_workers'],
            'has_signboard' => $application['has_signboard'],
            'signboard_type' => $application['signboard_type'],
            'signboard_size' => $application['signboard_size'],
            'applicant_name' => $application['applicant_name'],
            'applicant_ic' => $application['applicant_ic'],
            'status' => $application['status'],
            'status_borang' => $application['status_borang'],
            'created_at' => $application['created_at'],
            'updated_at' => $application['updated_at'],
            'files' => [
                'ssm_file' => $application['ssm_file'],
                'plan_file' => $application['plan_file'],
                'ic_file' => $application['ic_file'],
                'receipt_file' => $application['receipt_file'],
                'tax_file' => $application['tax_file'],
                'signboard_file' => $application['signboard_file'],
                'health_file' => $application['health_file'],
                'land_file' => $application['land_file'],
                'owner_file' => $application['owner_file'],
                'halal_file' => $application['halal_file']
            ]
        ],
        'applicant' => [
            'full_name' => $application['full_name'],
            'ic_number' => $application['ic_number'],
            'phone' => $application['phone'],
            'email' => $application['email'],
            'address' => $application['address'],
            'postcode' => $application['postcode'],
            'city' => $application['city'],
            'state' => $application['state']
        ],
        'status_history' => $status_history
    ];
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Application details retrieved successfully',
        'data' => $response_data
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