<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    die(" Connessione fallita: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    die("Errore: nessun utente loggato nella sessione.");
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user_id = $result->fetch_assoc()['id'] ?? null;

$workoutName = $_POST['Workout'] ?? null;

$stmt2 = $conn->prepare("SELECT id FROM workout WHERE name = ?");
$stmt2->bind_param("s", $workoutName);
$stmt2->execute();
$result2 = $stmt2->get_result();
$workout_id = $result2->fetch_assoc()['id'] ?? null;

$weeks = $_POST['week'] ?? [];
$days = $_POST['day'] ?? [];
$exercises = $_POST['exercise'] ?? [];
$sets = $_POST['sets'] ?? [];
$reps = $_POST['reps'] ?? [];
$weights = $_POST['peso'] ?? [];
$variants = $_POST['variante'] ?? [];
$rpes = $_POST['rpe'] ?? [];

if (empty($exercises)) {
    die("⚠️ Nessun esercizio ricevuto. Controlla che i name[] siano corretti.");
}
$query = "INSERT INTO workouts_exercises 
    (week, day, workout_id, exercise, sets, reps, weight, variant, RPE)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt4 = $conn->prepare($query);
if (!$stmt4) {
    die("Errore preparazione query: " . $conn->error);
}

$rows = count($exercises);
$inserted = 0;
for ($i = 0; $i < $rows; $i++) {
    $exercise_id = intval($exercises[$i] ?? 1);
    $week = intval($weeks[$i] ?? 1);
    $day = intval($days[$i] ?? 1);
    $set = intval($sets[$i] ?? 0);
    $rep = intval($reps[$i] ?? 0);
    $peso = floatval($weights[$i] ?? 0);
    $var = $variants[$i] ?? null;
    $rpe = floatval($rpes[$i] ?? 0);

    $stmt4->bind_param("iiiiiiisd", $week, $day, $workout_id, $exercise_id, $set, $rep, $peso, $var, $rpe);
    if ($stmt4->execute()) {
        $inserted++;
    } else {
        error_log("❌ Errore insert: " . $stmt4->error);
    }
}

echo "✅ Inseriti $inserted esercizi su $rows.";

$stmt->close();
$stmt2->close();
$stmt4->close();
$conn->close();
?>