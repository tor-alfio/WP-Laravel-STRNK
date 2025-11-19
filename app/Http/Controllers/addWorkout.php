<?php
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_id = $row['id'];

$nome = !empty($_POST['nome']) ? $_POST['nome'] : "Allenamento del " . $_POST['date'];
$days = isset($_POST['days']) ? $_POST['days'] : 1;
$type = isset($_POST['type']) ? $_POST['type'] : null;

$isProgrammazione = isset($_POST['start_date']) && !empty($_POST['start_date']);

if ($isProgrammazione) {
    $start_date = $_POST['start_date'];
    $finish_date = $_POST['finish_date'];
    $days = $_POST['days'];
    $weeks = $_POST['weeks'];
} else {
    $start_date = $_POST['date'];
    $weeks = 0;
    $days = 1;
    $finish_date = null;
}
$query = "INSERT INTO workout (name, weeks, days, creator, start_date, finish_date, type ) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("siiisss",$nome, $weeks, $days, $user_id, $start_date, $finish_date, $type);
if (!$stmt->execute()) {
    die("Errore nell'inserimento workout: " . $stmt->error);
}

$workout_id = $conn->insert_id;

if ($workout_id == 0) {
    die("Errore: ID workout non ottenuto");
}

$stmt = $conn->prepare("INSERT INTO saved_workouts (user, workout) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $workout_id);
$stmt->execute();

$conn->close();

header("Location: programmazione.php");
exit();
?>