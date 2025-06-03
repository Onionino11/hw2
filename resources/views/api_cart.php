<?php
// api_cart.php
session_start();
header('Content-Type: application/json');

// Recupera l'id utente dal cookie (loggato)
if (!isset($_COOKIE['loggato'])) {
    echo json_encode(['success' => false, 'error' => 'Utente non loggato']);
    exit;
}
$user_id = intval($_COOKIE['loggato']);

// Connessione al DB
$conn = mysqli_connect('localhost', 'root', '', 'malu');
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Connessione al database fallita']);
    exit;
}

// Trova il carrello dell'utente
$res = mysqli_query($conn, "SELECT id FROM carrelli WHERE user_id = $user_id");
$carrello_id = 0;
if ($row = mysqli_fetch_assoc($res)) {
    $carrello_id = $row['id'];
}

$items = [];
if ($carrello_id) {
    $sql = "SELECT prodotto_id, nome, descrizione, prezzo, quantita FROM carrello_prodotti WHERE carrello_id = $carrello_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
        mysqli_free_result($result);
    }
}
mysqli_close($conn);

echo json_encode(['success' => true, 'items' => $items]);
?>
