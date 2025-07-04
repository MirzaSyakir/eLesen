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

    $application_query = "SELECT status_borang FROM license_applications WHERE application_number = ? AND user_id = ?";
    $application_stmt = $db->prepare($application_query);
    $application_stmt->execute([$application_number, $user_id]);
    if ($application_stmt->rowCount() === 0) throw new Exception('Application not found or not yours');
    $application = $application_stmt->fetch(PDO::FETCH_ASSOC);

    if ($application['status_borang'] !== 'draft') {
        http_response_code(403);
        echo json_encode(['status' => 403, 'message' => 'Permohonan yang telah dihantar tidak boleh dipadam.']);
        exit;
    }

    $delete = $db->prepare("DELETE FROM license_applications WHERE application_number = ? AND user_id = ?");
    $delete->execute([$application_number, $user_id]);
    if ($delete->rowCount() === 0) throw new Exception('Application not found or not yours');

    echo json_encode(['status' => 200, 'message' => 'Application deleted']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 