<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 405, 'message' => 'Method not allowed']);
    exit;
}

require_once '../config/database.php';

$headers = getallheaders();
$auth_header = $headers['Authorization'] ?? '';
if (empty($auth_header) || !preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    http_response_code(401);
    echo json_encode(['status' => 401, 'message' => 'Authorization token required']);
    exit;
}
$token = $matches[1];

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) throw new Exception('Database connection failed');
    $session_query = "SELECT u.id FROM user_sessions us JOIN users u ON us.user_id = u.id WHERE us.session_token = :token AND us.expires_at > NOW() AND u.status = 'active'";
    $stmt = $db->prepare($session_query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    if ($stmt->rowCount() === 0) throw new Exception('Invalid or expired session');
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['id'];

    $data = json_decode(file_get_contents('php://input'), true);
    $application_number = $data['application_number'] ?? null;
    if (!$application_number) throw new Exception('Application number required');

    // Only allow editing if status is 'pending'
    $check = $db->prepare("SELECT * FROM license_applications WHERE application_number = ? AND user_id = ? AND status = 'pending'");
    $check->execute([$application_number, $user_id]);
    if ($check->rowCount() === 0) throw new Exception('Application not found, not yours, or not editable');

    // Fetch application and check status_borang
    $application = $db->prepare("SELECT * FROM license_applications WHERE application_number = ? AND user_id = ?");
    $application->execute([$application_number, $user_id]);
    $application = $application->fetch(PDO::FETCH_ASSOC);
    if ($application['status_borang'] !== 'draft') {
        http_response_code(403);
        echo json_encode(['status' => 403, 'message' => 'Permohonan tidak boleh diedit selepas dihantar.']);
        exit;
    }

    $license_type = $data['license_type'] ?? null;
    $business_name = $data['business_name'] ?? null;
    $business_address = $data['business_address'] ?? null;
    if (!$license_type || !$business_name || !$business_address) throw new Exception('Missing required fields');

    $update = $db->prepare("UPDATE license_applications SET license_type = ?, business_name = ?, business_address = ?, updated_at = NOW() WHERE application_number = ? AND user_id = ?");
    $update->execute([$license_type, $business_name, $business_address, $application_number, $user_id]);

    echo json_encode(['status' => 200, 'message' => 'Application updated']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 