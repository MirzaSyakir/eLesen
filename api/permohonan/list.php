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

    // Get filter parameters
    $status_filter = $_GET['status'] ?? null; // 'draft', 'submit', or null for all
    $page = max(1, intval($_GET['page'] ?? 1));
    $limit = max(1, min(50, intval($_GET['limit'] ?? 10)));
    $offset = ($page - 1) * $limit;

    // Build query
    $where_conditions = ["user_id = :user_id"];
    $params = [':user_id' => $user_id];

    if (!empty($status_filter)) {
        $where_conditions[] = "status_borang = :status_borang";
        $params[':status_borang'] = $status_filter;
    }

    $where_clause = implode(' AND ', $where_conditions);

    // Get total count
    $count_query = "SELECT COUNT(*) as total FROM license_applications WHERE $where_clause";
    $count_stmt = $db->prepare($count_query);
    // Only bind params that are actually in the query
    foreach ($params as $key => $value) {
        if (strpos($count_query, $key) !== false) {
            $count_stmt->bindValue($key, $value);
        }
    }
    $count_stmt->execute();
    $total_count = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get applications with pagination
    $query = "SELECT 
                id,
                application_number,
                license_type,
                processing_type,
                business_name,
                business_address,
                building_type,
                operation_year,
                premise_size,
                position,
                ssm_registration,
                male_workers,
                female_workers,
                has_signboard,
                signboard_type,
                signboard_size,
                applicant_name,
                applicant_ic,
                status_borang,
                status,
                created_at,
                updated_at
              FROM license_applications 
              WHERE $where_clause 
              ORDER BY created_at DESC 
              LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($query);
    foreach ($params as $key => $value) {
        if (strpos($query, $key) !== false) {
            $stmt->bindValue($key, $value);
        }
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate pagination info
    $total_pages = ceil($total_count / $limit);
    $has_next = $page < $total_pages;
    $has_prev = $page > 1;

    echo json_encode([
        'status' => 200,
        'data' => [
            'applications' => $applications,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_count' => $total_count,
                'limit' => $limit,
                'has_next' => $has_next,
                'has_prev' => $has_prev
            ]
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 