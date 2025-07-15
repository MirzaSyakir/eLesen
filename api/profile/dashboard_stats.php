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
    
    // Validate session
    $session_query = "SELECT u.id FROM user_sessions us JOIN users u ON us.user_id = u.id WHERE us.session_token = :token AND us.expires_at > NOW() AND u.status = 'active'";
    $stmt = $db->prepare($session_query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    if ($stmt->rowCount() === 0) throw new Exception('Invalid or expired session');
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $user['id'];

    // Get statistics
    // 1. Permohonan Aktif (all except 'approved', 'rejected', 'expired')
    $active_query = "SELECT COUNT(*) as total FROM license_applications WHERE user_id = :user_id AND status NOT IN ('approved', 'rejected', 'expired')";
    $active_stmt = $db->prepare($active_query);
    $active_stmt->bindParam(':user_id', $user_id);
    $active_stmt->execute();
    $permohonan_aktif = $active_stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // 2. Lesen Diluluskan (approved)
    $approved_query = "SELECT COUNT(*) as total FROM license_applications WHERE user_id = :user_id AND status = 'approved'";
    $approved_stmt = $db->prepare($approved_query);
    $approved_stmt->bindParam(':user_id', $user_id);
    $approved_stmt->execute();
    $lesen_diluluskan = $approved_stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // 3. Dalam Proses (processing)
    $processing_query = "SELECT COUNT(*) as total FROM license_applications WHERE user_id = :user_id AND status = 'processing'";
    $processing_stmt = $db->prepare($processing_query);
    $processing_stmt->bindParam(':user_id', $user_id);
    $processing_stmt->execute();
    $dalam_proses = $processing_stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // 4. Tamat Tempoh (expired)
    $expired_query = "SELECT COUNT(*) as total FROM license_applications WHERE user_id = :user_id AND status = 'expired'";
    $expired_stmt = $db->prepare($expired_query);
    $expired_stmt->bindParam(':user_id', $user_id);
    $expired_stmt->execute();
    $tamat_tempoh = $expired_stmt->fetch(PDO::FETCH_ASSOC)['total'];

    echo json_encode([
        'status' => 200,
        'data' => [
            'permohonan_aktif' => (int)$permohonan_aktif,
            'lesen_diluluskan' => (int)$lesen_diluluskan,
            'dalam_proses' => (int)$dalam_proses,
            'tamat_tempoh' => (int)$tamat_tempoh
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 