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

// Auth
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

    // Get POST data from FormData
    $license_type = $_POST['licenseType'] ?? null;
    $processing_type = $_POST['processingType'] ?? null;
    $business_name = $_POST['businessName'] ?? null;
    $business_address = $_POST['businessAddress'] ?? null;
    $building_type = $_POST['buildingType'] ?? null;
    $operation_year = $_POST['operationYear'] ?? null;
    $premise_size = $_POST['premiseSize'] ?? null;
    $position = $_POST['position'] ?? null;
    $ssm_registration = $_POST['ssmRegistration'] ?? null;
    $male_workers = $_POST['maleWorkers'] ?? 0;
    $female_workers = $_POST['femaleWorkers'] ?? 0;
    $has_signboard = $_POST['hasSignboard'] ?? null;
    $signboard_type = $_POST['signboardType'] ?? null;
    $signboard_size = $_POST['signboardSize'] ?? null;
    $applicant_name = $_POST['applicantName'] ?? null;
    $applicant_ic = $_POST['applicantIC'] ?? null;
    $status_borang = isset($_POST['status_borang']) ? $_POST['status_borang'] : 'draft';

    // Required fields
    if (!$license_type || !$business_name || !$business_address) throw new Exception('Missing required fields');

    // Generate application number
    $application_number = 'DRAFT-' . strtoupper(uniqid());

    // Create folder for this application
    $folder = '../../uploads/permohonan/' . $application_number . '/';
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }

    // Handle file uploads (documents[])
    $doc_fields = ['ssm','plan','ic','receipt','tax','signboard','health','land','owner','halal'];
    $doc_paths = [];
    foreach ($doc_fields as $doc) {
        if (isset($_FILES['documents']['name'][$doc]) && $_FILES['documents']['error'][$doc] === UPLOAD_ERR_OK) {
            $tmp = $_FILES['documents']['tmp_name'][$doc];
            $name = basename($_FILES['documents']['name'][$doc]);
            $target = $folder . $name;
            if (move_uploaded_file($tmp, $target)) {
                $doc_paths[$doc] = 'uploads/permohonan/' . $application_number . '/' . $name;
            } else {
                $doc_paths[$doc] = null;
            }
        } else {
            $doc_paths[$doc] = null;
        }
    }

    // Insert draft
    $insert = $db->prepare("INSERT INTO license_applications (
        user_id, application_number, license_type, processing_type, business_name, business_address, building_type, operation_year, premise_size, position, ssm_registration, male_workers, female_workers, has_signboard, signboard_type, signboard_size, applicant_name, applicant_ic,
        ssm_file, plan_file, ic_file, receipt_file, tax_file, signboard_file, health_file, land_file, owner_file, halal_file, status, status_borang
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $insert->execute([
        $user_id, $application_number, $license_type, $processing_type, $business_name, $business_address, $building_type, $operation_year, $premise_size, $position, $ssm_registration, $male_workers, $female_workers, $has_signboard, $signboard_type, $signboard_size, $applicant_name, $applicant_ic,
        $doc_paths['ssm'], $doc_paths['plan'], $doc_paths['ic'], $doc_paths['receipt'], $doc_paths['tax'], $doc_paths['signboard'], $doc_paths['health'], $doc_paths['land'], $doc_paths['owner'], $doc_paths['halal'], 'pending', $status_borang
    ]);

    echo json_encode(['status' => 200, 'message' => 'Draft saved', 'application_number' => $application_number]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 400, 'message' => $e->getMessage()]);
} 