<?php
include 'config.php';

header('Content-Type: application/json');

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$wilaya = isset($_POST['wilaya']) ? trim($_POST['wilaya']) : '';
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

// Validate inputs
if (strlen($name) < 2) {
    echo json_encode(['error' => 'Le nom doit contenir au moins 2 caractères.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Adresse email invalide.']);
    exit;
}

if (!preg_match('/^(?:\+213|0)[5-7][0-9]{8}$/', $phone)) {
    echo json_encode(['error' => 'Numéro de téléphone invalide. Utilisez un numéro algérien (ex. +2136xxxxxxxx ou 06xxxxxxxx).']);
    exit;
}

$wilayas = [
    'أدرار', 'الشلف', 'الأغواط', 'أم البواقي', 'باتنة', 'بجاية', 'بسكرة', 'بشار',
    'البليدة', 'البويرة', 'تمنراست', 'تبسة', 'تلمسان', 'تيارت', 'تيزي وزو',
    'الجزائر', 'الجلفة', 'جيجل', 'سطيف', 'سعيدة', 'سكيكدة', 'سيدي بلعباس',
    'عنابة', 'قالمة', 'قسنطينة', 'المدية', 'مستغانم', 'المسيلة', 'معسكر',
    'ورقلة', 'وهران', 'البيض', 'إليزي', 'برج بوعريريج', 'بومرداس', 'الطارف',
    'تيندوف', 'تيسمسيلت', 'الوادي', 'خنشلة', 'سوق أهراس', 'تيبازة', 'ميلة',
    'عين الدفلى', 'النعامة', 'عين تيموشنت', 'غرداية', 'غليزان', 'تيميمون',
    'برج باجي مختار', 'أولاد جلال', 'بني عباس', 'عين صالح', 'عين قزام',
    'توقرت', 'جانت', 'المغير', 'الحدائق'
];
if (!in_array($wilaya, $wilayas)) {
    echo json_encode(['error' => 'Wilaya sélectionnée invalide.']);
    exit;
}

if ($course_id <= 0) {
    echo json_encode(['error' => 'ID de formation invalide.']);
    exit;
}

// Check if course exists
$stmt = $conn->prepare("SELECT id, title, price FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_check = $stmt->get_result();
if ($course_check->num_rows == 0) {
    echo json_encode(['error' => 'Formation non trouvée.']);
    $stmt->close();
    exit;
}
$course = $course_check->fetch_assoc();
$stmt->close();

// Check if client exists by email
$client_check = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$client_check->bind_param("s", $email);
$client_check->execute();
$client_result = $client_check->get_result();
$client_id = null;
if ($client_result->num_rows > 0) {
    $client_row = $client_result->fetch_assoc();
    $client_id = $client_row['id'];
    // Update client information
    $update_stmt = $conn->prepare("UPDATE clients SET name = ?, phone = ?, wilaya = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $name, $phone, $wilaya, $client_id);
    if (!$update_stmt->execute()) {
        echo json_encode(['error' => 'Erreur lors de la mise à jour des informations du client : ' . $conn->error]);
        $update_stmt->close();
        $client_check->close();
        exit;
    }
    $update_stmt->close();
} else {
    // Insert new client
    $insert_stmt = $conn->prepare("INSERT INTO clients (name, email, phone, wilaya) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $name, $email, $phone, $wilaya);
    if ($insert_stmt->execute()) {
        $client_id = $conn->insert_id;
    } else {
        echo json_encode(['error' => 'Erreur lors de l\'ajout du client : ' . $conn->error]);
        $insert_stmt->close();
        $client_check->close();
        exit;
    }
    $insert_stmt->close();
}
$client_check->close();

// Check if already registered
$reg_check = $conn->prepare("SELECT id FROM registrations WHERE client_id = ? AND course_id = ?");
$reg_check->bind_param("ii", $client_id, $course_id);
$reg_check->execute();
$reg_result = $reg_check->get_result();
if ($reg_result->num_rows > 0) {
    echo json_encode(['error' => 'Vous êtes déjà inscrit à cette formation.']);
    $reg_check->close();
    exit;
}
$reg_check->close();

// Insert registration
$reg_stmt = $conn->prepare("INSERT INTO registrations (client_id, course_id, status) VALUES (?, ?, 'not_confirmed')");
$reg_stmt->bind_param("ii", $client_id, $course_id);
if ($reg_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Erreur lors de l\'inscription : ' . $conn->error]);
}
$reg_stmt->close();
?>