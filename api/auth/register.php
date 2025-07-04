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
    $full_name = trim($input['full_name'] ?? '');
    $ic_number = trim($input['ic_number'] ?? '');
    $phone = trim($input['phone'] ?? '');
    $email = trim($input['email'] ?? '');
    $address = trim($input['address'] ?? '');
    $postcode = trim($input['postcode'] ?? '');
    $city = trim($input['city'] ?? '');
    $state = trim($input['state'] ?? '');
    $password = $input['password'] ?? '';
    $warna_kad_pengenalan = trim($input['warna_kad_pengenalan'] ?? '');
    $tarikh_lahir = trim($input['tarikh_lahir'] ?? '');
    $umur = trim($input['umur'] ?? '');
    $agama = trim($input['agama'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($full_name)) {
        $errors[] = 'Nama penuh diperlukan';
    }
    
    if (empty($ic_number)) {
        $errors[] = 'Nombor kad pengenalan diperlukan';
    } elseif (!preg_match('/^\d{12}$/', $ic_number)) {
        $errors[] = 'Nombor kad pengenalan mestilah 12 digit nombor';
    }
    
    if (empty($phone)) {
        $errors[] = 'Nombor telefon diperlukan';
    } elseif (!preg_match('/^\d{10,11}$/', $phone)) {
        $errors[] = 'Nombor telefon tidak sah';
    }
    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Alamat e-mel tidak sah';
    }
    
    if (empty($address)) {
        $errors[] = 'Alamat diperlukan';
    }
    
    if (empty($postcode)) {
        $errors[] = 'Poskod diperlukan';
    } elseif (!preg_match('/^\d{5}$/', $postcode)) {
        $errors[] = 'Poskod mestilah 5 digit nombor';
    }
    
    if (empty($city)) {
        $errors[] = 'Bandar diperlukan';
    }
    
    if (empty($state)) {
        $errors[] = 'Negeri diperlukan';
    }
    
    if (empty($warna_kad_pengenalan)) {
        $errors[] = 'Warna kad pengenalan diperlukan';
    }
    
    if (empty($tarikh_lahir)) {
        $errors[] = 'Tarikh lahir diperlukan';
    }
    
    if ($umur === '' || !is_numeric($umur) || $umur < 0) {
        $errors[] = 'Umur tidak sah';
    }
    
    if (empty($agama)) {
        $errors[] = 'Agama diperlukan';
    }
    
    if (empty($password)) {
        $errors[] = 'Kata laluan diperlukan';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Kata laluan mestilah sekurang-kurangnya 6 aksara';
    }
    
    if (!empty($errors)) {
        throw new Exception(implode(', ', $errors));
    }
    
    // Connect to database
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception('Database connection failed');
    }
    
    // Check if IC number already exists
    $check_query = "SELECT id FROM users WHERE ic_number = :ic_number";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':ic_number', $ic_number);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        throw new Exception('Nombor kad pengenalan sudah didaftarkan');
    }
    
    // Check if email already exists (if provided)
    if (!empty($email)) {
        $email_check_query = "SELECT id FROM users WHERE email = :email";
        $email_check_stmt = $db->prepare($email_check_query);
        $email_check_stmt->bindParam(':email', $email);
        $email_check_stmt->execute();
        
        if ($email_check_stmt->rowCount() > 0) {
            throw new Exception('Alamat e-mel sudah didaftarkan');
        }
    }
    
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $insert_query = "INSERT INTO users (full_name, ic_number, phone, email, address, postcode, city, state, warna_kad_pengenalan, tarikh_lahir, umur, agama, password_hash) 
                     VALUES (:full_name, :ic_number, :phone, :email, :address, :postcode, :city, :state, :warna_kad_pengenalan, :tarikh_lahir, :umur, :agama, :password_hash)";
    
    $insert_stmt = $db->prepare($insert_query);
    $insert_stmt->bindParam(':full_name', $full_name);
    $insert_stmt->bindParam(':ic_number', $ic_number);
    $insert_stmt->bindParam(':phone', $phone);
    $insert_stmt->bindParam(':email', $email);
    $insert_stmt->bindParam(':address', $address);
    $insert_stmt->bindParam(':postcode', $postcode);
    $insert_stmt->bindParam(':city', $city);
    $insert_stmt->bindParam(':state', $state);
    $insert_stmt->bindParam(':warna_kad_pengenalan', $warna_kad_pengenalan);
    $insert_stmt->bindParam(':tarikh_lahir', $tarikh_lahir);
    $insert_stmt->bindParam(':umur', $umur);
    $insert_stmt->bindParam(':agama', $agama);
    $insert_stmt->bindParam(':password_hash', $password_hash);
    
    if ($insert_stmt->execute()) {
        $user_id = $db->lastInsertId();
        
        // Get the created user data
        $user_query = "SELECT id, full_name, ic_number, phone, email, address, postcode, city, state, warna_kad_pengenalan, tarikh_lahir, umur, agama, created_at 
                       FROM users WHERE id = :user_id";
        $user_stmt = $db->prepare($user_query);
        $user_stmt->bindParam(':user_id', $user_id);
        $user_stmt->execute();
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 201,
            'message' => 'Pendaftaran berjaya',
            'data' => [
                'user' => $user
            ]
        ]);
    } else {
        throw new Exception('Gagal mendaftar akaun');
    }
    
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