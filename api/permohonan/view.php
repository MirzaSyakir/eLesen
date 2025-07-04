<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

    $application_number = $_GET['application_number'] ?? null;
    if ($application_number) {
        $query = $db->prepare("SELECT * FROM license_applications WHERE application_number = ? AND user_id = ?");
        $query->execute([$application_number, $user_id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) throw new Exception('Application not found or not yours');
        echo json_encode([
            'status' => 200,
            'data' => [
                'application' => $result,
            ]
        ]);
    } else {
        $query = $db->prepare("SELECT * FROM license_applications WHERE user_id = ? ORDER BY created_at DESC");
        $query->execute([$user_id]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 200, 'applications' => $results]);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 