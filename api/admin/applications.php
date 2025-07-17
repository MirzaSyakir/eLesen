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
    
    // Get filter parameters
    $status_filter = $input['status'] ?? '';
    $search_term = $input['search'] ?? '';
    $page = max(1, intval($input['page'] ?? 1));
    $limit = max(1, min(50, intval($input['limit'] ?? 10)));
    $offset = ($page - 1) * $limit;
    
    // Build query
    $where_conditions = [];
    $params = [];
    
    if (!empty($status_filter)) {
        $where_conditions[] = "la.status = :status";
        $params[':status'] = $status_filter;
    }
    
    if (!empty($search_term)) {
        $where_conditions[] = "(la.application_number LIKE :search 
                              OR la.business_name LIKE :search 
                              OR la.license_type LIKE :search 
                              OR u.full_name LIKE :search 
                              OR u.ic_number LIKE :search)";
        $params[':search'] = "%{$search_term}%";
    }
    
    $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';
    
    // Get total count
    $count_query = "SELECT COUNT(*) as total 
                    FROM license_applications la
                    INNER JOIN users u ON la.user_id = u.id
                    {$where_clause}";
    
    $count_stmt = $db->prepare($count_query);
    foreach ($params as $key => $value) {
        $count_stmt->bindValue($key, $value);
    }
    $count_stmt->execute();
    $total_count = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get applications
    $query = "SELECT la.id, la.application_number, la.license_type, la.business_name, 
                     la.business_address, la.status, la.status_borang, la.created_at, la.updated_at,
                     la.no_ssm,
                     u.id as user_id, u.full_name as applicant_name, u.ic_number, u.phone, u.email
              FROM license_applications la
              INNER JOIN users u ON la.user_id = u.id
              {$where_clause}
              ORDER BY la.created_at DESC
              LIMIT :limit OFFSET :offset";
    
    $stmt = $db->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate pagination info
    $total_pages = ceil($total_count / $limit);
    $has_next = $page < $total_pages;
    $has_prev = $page > 1;
    
    // Return success response
    echo json_encode([
        'status' => 200,
        'message' => 'Applications retrieved successfully',
        'data' => [
            'applications' => $applications,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_count' => $total_count,
                'limit' => $limit,
                'has_next' => $has_next,
                'has_prev' => $has_prev
            ],
            'filters' => [
                'status' => $status_filter,
                'search' => $search_term
            ]
        ]
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