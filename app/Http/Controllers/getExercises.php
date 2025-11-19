<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strnk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die(json_encode(['error' => 'Connessione fallita']));
}

$sql = "SELECT id, name FROM exercise";
$result = $conn->query($sql);

$exercises = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $exercises[] = $row;
  }
}

echo json_encode($exercises);

$conn->close();
?>
