<?php
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$nome_utente = $_SESSION['username'];
$sql = "SELECT id, first_Name, pfp FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nome_utente);
$stmt->execute();
$result = $stmt->get_result();
$utente_id = $result->fetch_assoc()['id'];
$query = "SELECT u.id, CONCAT(u.first_Name, ' ', u.last_Name) AS nome_completo, u.pfp,
    GROUP_CONCAT(DISTINCT r.ruolo SEPARATOR ', ') AS ruoli,
    GROUP_CONCAT(DISTINCT s.specialita SEPARATOR ', ') AS specialita FROM user u
LEFT JOIN ruolo r ON u.id = r.utente
LEFT JOIN specialita s ON u.id = s.utente
WHERE u.id != ?
GROUP BY u.id";
$stmt2 = $conn->prepare($query);
$stmt2->bind_param("i", $utente_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

$utenti = [];

while ($riga = $result2->fetch_assoc()) {
    $utenti[] = $riga;
}
header('Content-Type: application/json');
echo json_encode($utenti);
?>