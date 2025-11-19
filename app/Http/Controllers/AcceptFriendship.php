<?php
header("Content-Type: application/json");
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    echo json_encode(["errore" => "Connessione fallita"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$stmt = $conn->prepare('SELECT id FROM user WHERE username = ?');
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id1 = $row['id'];
$id2 = intval($data["id2"]);
$notification = intval($data["notification"]);
echo $id2;
$stmt1 = $conn->prepare('
    UPDATE follow SET stato ="amici" WHERE (user1 = ? AND user2 = ?)OR(user2 = ? AND user1 = ?)');
$stmt1->bind_param("iiii", $id1, $id2, $id1, $id2);
if ($stmt1->execute()) {
    $stmt2 = $conn->prepare(' UPDATE notification  SET seen = 1 WHERE id = ?');
    $stmt2->bind_param("i", $notification);
    $stmt2->execute();
    echo json_encode(["successo" => true, "messaggio" => "Amicizia aggiunta"]);
} else {
    echo json_encode(["successo" => false, "errore" => "Errore nell'inserimento"]);
}
$stmt->close();
$stmt1->close();
$stmt2->close();
$conn->close();
?>