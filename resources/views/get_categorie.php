<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost","root","","malu");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT * FROM categoria";
$result = $conn->query($sql);

$categorie = [];
while ($row = $result->fetch_assoc()) {
    $categorie[] = $row;
}

echo json_encode($categorie);
$conn->close();
?>
