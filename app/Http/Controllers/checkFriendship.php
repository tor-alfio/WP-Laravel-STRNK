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

$stmt = $conn->prepare("
    SELECT user1, user2, stato 
    FROM follow 
    WHERE (user1 = ? AND user2 = ?) 
       OR (user1 = ? AND user2 = ?)
");
$stmt->bind_param("iiii", $id1, $id2, $id2, $id1);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["stato" => $row["stato"]]);
} else {
    echo json_encode(["stato" => "non_amici"]);
}

$stmt->close();
$conn->close();
?>