<?php
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");

if ($conn->connect_error) {
    http_response_code(500);
    die("Connessione fallita");
}
if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];

    $stmt = $conn->prepare("SELECT id FROM workout WHERE name = ? AND creator = (SELECT id FROM user WHERE username = ?)");
    $stmt->bind_param("ss", $nome, $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $workout_id = $row['id'];
        $stmt = $conn->prepare("DELETE FROM saved_workouts WHERE workout = ?");
        $stmt->bind_param("i", $workout_id);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM workouts_exercises WHERE workout_id = ?");
        $stmt->bind_param("i", $workout_id);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM workout WHERE id = ?");
        $stmt->bind_param("i", $workout_id);
        $stmt->execute();

        http_response_code(200);
        exit("Eliminazione completata");
    } else {
        http_response_code(404);
        exit("Workout non trovato");
    }
}
http_response_code(400);
exit("Parametro mancante");
