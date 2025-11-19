<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    echo json_encode(["errore" => "Connessione fallita"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$id1 = intval($data["id1"]);
$id2 = intval($data["id2"]);

$stmt = $conn->prepare('
    INSERT INTO follow(user1, user2, stato) VALUES (?,?, "in sospeso")');
$stmt->bind_param("ii", $id1, $id2);
if ($stmt->execute()) {
    $stmt1 = $conn->prepare('INSERT INTO notification(type, sentBy, text, momentInserted) VALUES ("amicizia", ?, "", NOW())');
    $stmt1->bind_param("i", $id1);
    $stmt1->execute();
    $insertId = $conn->insert_id;
    $stmt2 = $conn->prepare("INSERT INTO mailbox (user, notification) VALUES (?, ?)");
    $stmt2->bind_param("ii", $id2, $insertId);
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