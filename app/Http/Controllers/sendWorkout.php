<?php
header("Content-Type: application/json");
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    echo json_encode(["errore" => "Connessione fallita"]);
    exit;
}
$u2 = $_SESSION['username'];
$sql = "SELECT id FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $u2);
$stmt->execute();
$result = $stmt->get_result();
$u2 = $result->fetch_assoc()['id'];
$u1=$_POST['id'];
$wid=$_POST['wid'];

$stmt1 = $conn->prepare('INSERT INTO notification(type, sentBy, text, momentInserted) VALUES ("allenamentoCoach", ?, ?, NOW())');
$stmt1->bind_param("is", $u2, $wid);
$stmt1->execute();
$insertId = $conn->insert_id;
$stmt3 = $conn->prepare("INSERT INTO mailbox (user, notification) VALUES (?, ?)");
$stmt3->bind_param("ii", $u1, $insertId);
$stmt3->execute();

$stmt = $conn->prepare("SELECT id FROM workout WHERE name = ?");
$stmt->bind_param("s", $wid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$wid = $row['id'];

$stmt2 = $conn->prepare("INSERT INTO saved_workouts VALUES(?,?)");
$stmt2->bind_param("ii", $u1,$wid);
$stmt2->execute();


$stmt->close();
$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();
?>