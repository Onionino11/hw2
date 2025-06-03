<?php
header('Content-Type: application/json');
// Configurazione DB
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'malu';

// Connessione al database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore di connessione al database: ' . $conn->connect_error]);
    exit;
}

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';
$number = isset($_GET['number']) ? intval($_GET['number']) : 10;

// Mappatura delle query testuali alle categorie
$map = [
    'snac' => 1,
    'hamburger' => 3,
    'pasta' => 2,
    'salad' => 4,
    'drink' => 5,
    'dessert' => 6
];

if(array_key_exists($query, $map)) {
    $cat = intval($map[$query]);
    $sql = "SELECT * FROM prodotti WHERE categoria = $cat ORDER BY id ASC";
}
else {
    header('Location: ../php/index.php');
    $conn->close();
    exit;
}

$result = $conn->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nella query: ' . $conn->error]);
    $conn->close();
    exit;
}

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
$conn->close();

echo json_encode(['results' => $items]);
?>
