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

$admin_validation = validateAdminSession($session_token);
if ($admin_validation['status'] !== 200) {
    echo json_encode($admin_validation);
    exit;
}

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Get filter parameters
    $status = $input['status'] ?? '';
    $search = $input['search'] ?? '';
    $page = max(1, intval($input['page'] ?? 1));
    $limit = max(1, min(50, intval($input['limit'] ?? 10)));
    $offset = ($page - 1) * $limit;
    
    // Build WHERE clause
    $where_conditions = ["1=1"];
    $params = [];
    
    if (!empty($status)) {
        $where_conditions[] = "u.status = ?";
        $params[] = $status;
    }
    
    if (!empty($search)) {
        $where_conditions[] = "(u.full_name LIKE ? OR u.email LIKE ? OR u.ic_number LIKE ?)";
        $search_param = "%$search%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Get total count
    $count_sql = "SELECT COUNT(*) as total FROM users u WHERE $where_clause";
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute($params);
    $total_users = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get users with pagination
    $sql = "SELECT 
                u.id,
                u.full_name,
                u.email,
                u.ic_number,
                u.phone,
                u.address,
                u.status,
                u.created_at,
                u.updated_at
            FROM users u 
            WHERE $where_clause 
            ORDER BY u.created_at DESC 
            LIMIT ? OFFSET ?";
    
    $stmt = $pdo->prepare($sql);
    // Bind previous params
    $paramIndex = 1;
    foreach ($params as $p) {
        $stmt->bindValue($paramIndex, $p);
        $paramIndex++;
    }
    // Bind LIMIT and OFFSET as integers
    $stmt->bindValue($paramIndex, (int)$limit, PDO::PARAM_INT);
    $paramIndex++;
    $stmt->bindValue($paramIndex, (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate pagination info
    $total_pages = ceil($total_users / $limit);
    $has_prev = $page > 1;
    $has_next = $page < $total_pages;
    
    $pagination = [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_items' => $total_users,
        'items_per_page' => $limit,
        'has_prev' => $has_prev,
        'has_next' => $has_next
    ];
    
    echo json_encode([
        'status' => 200,
        'message' => 'Users retrieved successfully',
        'data' => [
            'users' => $users,
            'pagination' => $pagination
        ]
    ]);
    
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