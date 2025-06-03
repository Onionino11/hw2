<?php
// remove_from_cart.php
// Rimuove un prodotto dal carrello o ne diminuisce la quantità

session_start();

$conn = mysqli_connect('localhost', 'root', '', 'malu');
if (!$conn) {
    die('Connessione al database fallita');
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (isset($_COOKIE['loggato'])) {

    $user_id = intval($_COOKIE['loggato']);
} else {
    header('Location: ../php/login_cookie.php');
    exit;
}

// Trova il carrello dell'utente
$carrello_id = 0;
$res = mysqli_query($conn, "SELECT id FROM carrelli WHERE user_id = $user_id");
if ($row = mysqli_fetch_assoc($res)) {
    $carrello_id = $row['id'];
} else {
    // Nessun carrello, niente da rimuovere
    mysqli_close($conn);
    header('Location: cart.php');
    exit;
}

// Controlla la quantità attuale
$res = mysqli_query($conn, "SELECT id, quantita FROM carrello_prodotti WHERE carrello_id = $carrello_id AND prodotto_id = $id");
if ($row = mysqli_fetch_assoc($res)) {
    if ($row['quantita'] > 1) {
        $quantita = $row['quantita'] - 1;
        mysqli_query($conn, "UPDATE carrello_prodotti SET quantita = $quantita WHERE id = " . $row['id']);
    } else {
        mysqli_query($conn, "DELETE FROM carrello_prodotti WHERE id = " . $row['id']);
    }
}

// Aggiorna il totale del carrello
$res = mysqli_query($conn, "SELECT SUM(prezzo * quantita) as totale FROM carrello_prodotti WHERE carrello_id = $carrello_id");
if ($row = mysqli_fetch_assoc($res)) {
    $totale = $row['totale'] ? $row['totale'] : 0.00;
    mysqli_query($conn, "UPDATE carrelli SET totale = $totale WHERE id = $carrello_id");
}

mysqli_close($conn);
header('Location: cart.php');
exit;
?>
