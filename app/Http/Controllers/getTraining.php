<?php
session_start();
header('Content-Type: application/json');
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
$date = $input['data'] ?? '';
$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore connessione al database']);
    exit;
}

$stmt = $conn->prepare("SELECT W.name FROM workout W INNER JOIN saved_workouts S on S.workout = W.id INNER JOIN user U on U.id = S.user WHERE W.start_date = ? AND U.username= ? ");
$stmt->bind_param("ss", $date, $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['name' => $row['name']]);
} else {
    echo json_encode(['name' => null]);
}

$stmt->close();
$conn->close();
?>