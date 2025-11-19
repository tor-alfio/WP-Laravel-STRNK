<?php
session_start();
$conn = new mysqli("localhost", "root", "", "strnk");
if ($conn->connect_error) {
    http_response_code(500);
    exit;
}
$stmt = $conn->prepare("SELECT N.id, N.sentBy, N.type, CONCAT(U.first_Name, ' ', U.last_Name) AS nome_completo, U.pfp, N.text, N.MomentInserted,N.seen FROM mailbox M INNER JOIN user U1 on U1.id = M.user INNER JOIN notification N on M.notification = N.id INNER JOIN user U on U.id = N.sentBy WHERE U1.username= ? ORDER BY N.MomentInserted DESC");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$notifiche = [];
while ($row = $result->fetch_assoc()) {
    $notifiche[] = $row;
}
header('Content-Type: application/json');
echo json_encode($notifiche);
$stmt->close();
$conn->close();
?>