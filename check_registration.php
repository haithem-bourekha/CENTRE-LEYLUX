<?php
include 'config.php';

header('Content-Type: application/json');

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Adresse email invalide.']);
    exit;
}

if ($course_id <= 0) {
    echo json_encode(['error' => 'ID de formation invalide.']);
    exit;
}

// Check if course exists
$stmt = $conn->prepare("SELECT id FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$course_check = $stmt->get_result();
if ($course_check->num_rows == 0) {
    echo json_encode(['error' => 'Formation non trouvée.']);
    $stmt->close();
    exit;
}
$stmt->close();

// Check client registration
$client_check = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$client_check->bind_param("s", $email);
$client_check->execute();
$client_result = $client_check->get_result();
if ($client_result->num_rows > 0) {
    $client_row = $client_result->fetch_assoc();
    $client_id = $client_row['id'];
    $reg_check = $conn->prepare("SELECT status FROM registrations WHERE client_id = ? AND course_id = ?");
    $reg_check->bind_param("ii", $client_id, $course_id);
    $reg_check->execute();
    $reg_result = $reg_check->get_result();
    if ($reg_result->num_rows > 0) {
        $reg_row = $reg_result->fetch_assoc();
        echo json_encode(['exists' => true, 'status' => $reg_row['status']]);
    } else {
        echo json_encode(['exists' => true, 'status' => null]);
    }
    $reg_check->close();
} else {
    echo json_encode(['exists' => false, 'status' => null]);
}
$client_check->close();
?>