<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'message' => 'Method not allowed'
    ]);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input');
    }

    $session_token = trim($input['session_token'] ?? '');
    $application_id = intval($input['application_id'] ?? 0);

    if (empty($session_token)) {
        throw new Exception('Session token diperlukan');
    }

    if ($application_id <= 0) {
        throw new Exception('ID permohonan tidak sah');
    }

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
    $query = "SELECT la.*, u.full_name, u.ic_number, u.phone, u.email, u.address, u.postcode, u.city, u.state, u.passport_photo
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
        'application' => $application,
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
        ],
        'applicant' => [
            'full_name' => $application['full_name'],
            'ic_number' => $application['ic_number'],
            'phone' => $application['phone'],
            'email' => $application['email'],
            'address' => $application['address'],
            'postcode' => $application['postcode'],
            'city' => $application['city'],
            'state' => $application['state'],
            'passport_photo' => $application['passport_photo']
        ],
        'status_history' => $status_history
    ];

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