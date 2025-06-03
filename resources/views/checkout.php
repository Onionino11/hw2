<?php
session_start();
$ordine_inviato = false;
$errore_ordine = '';
$riepilogo = [];
$totale = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_COOKIE['loggato'])) {
    $user_id = intval($_COOKIE['loggato']);
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $note = isset($_POST['note']) ? $_POST['note'] : '';
    $consegna = isset($_POST['consegna']) ? $_POST['consegna'] : '';
    $pagamento = isset($_POST['pagamento']) ? $_POST['pagamento'] : '';

    $conn = mysqli_connect('localhost', 'root', '', 'malu');
    if ($conn) {
        $res = mysqli_query($conn, "SELECT id FROM carrelli WHERE user_id = $user_id");
        $carrello_id = 0;
        if ($row = mysqli_fetch_assoc($res)) {
            $carrello_id = $row['id'];
        }
        if ($carrello_id) {
            $items = [];
            $res = mysqli_query($conn, "SELECT prodotto_id, nome, prezzo, quantita FROM carrello_prodotti WHERE carrello_id = $carrello_id");
            while ($row = mysqli_fetch_assoc($res)) {
                $items[] = $row;
                $totale += $row['prezzo'] * $row['quantita'];
            }
            if (count($items) > 0) {
                $stmt = mysqli_prepare($conn, "INSERT INTO ordini (user_id, totale, note, first_name, last_name, phone, consegna, pagamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'idssssss', $user_id, $totale, $note, $first_name, $last_name, $phone, $consegna, $pagamento);
                if (mysqli_stmt_execute($stmt)) {
                    $ordine_id = mysqli_insert_id($conn);
                    foreach ($items as $item) {
                        $pid = $item['prodotto_id'];
                        $nome = $item['nome'];
                        $prezzo = $item['prezzo'];
                        $qta = $item['quantita'];
                        $stmt2 = mysqli_prepare($conn, "INSERT INTO ordini_prodotti (ordine_id, prodotto_id, nome, prezzo, quantita) VALUES (?, ?, ?, ?, ?)");
                        mysqli_stmt_bind_param($stmt2, 'iisdi', $ordine_id, $pid, $nome, $prezzo, $qta);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_close($stmt2);
                    }
                    mysqli_query($conn, "DELETE FROM carrello_prodotti WHERE carrello_id = $carrello_id");
                    mysqli_query($conn, "UPDATE carrelli SET totale = 0.00 WHERE id = $carrello_id");
                    $ordine_inviato = true;
                    $riepilogo = $items;
                } else {
                    $errore_ordine = 'Errore durante il salvataggio dell\'ordine.';
                }
                mysqli_stmt_close($stmt);
            } else {
                $errore_ordine = 'Il carrello è vuoto.';
            }
        } else {
            $errore_ordine = 'Nessun carrello trovato.';
        }
        mysqli_close($conn);
    } else {
        $errore_ordine = 'Connessione al database fallita.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Conferma Ordine - Maluburger</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <?php include 'header.php'; ?>
</head>
<body>
    <div id="modal-view" class="hidden"></div>
    <?php include 'navbar.php'; ?>
    <?php include 'header_section.php'; ?>
    <?php include 'navigazione.php'; ?>
    <article>
        <section id="panel">
            <div id="panel-heading"> <img class="panel-icon" class="icon" src="../assets/img/cart.svg"> Checkout</div>
            <div id="panel-body">
<?php if ($ordine_inviato): ?>
    <div class="form-group ordine-success">
        <strong>Ordine inviato con successo!</strong><br>
        Grazie per aver ordinato da Maluburger.<br>
        <br>
        <strong>Riepilogo ordine:</strong>
        <ul>
            <?php foreach($riepilogo as $item): ?>
                <li><span><?= htmlspecialchars($item['quantita']) ?> x <?= htmlspecialchars($item['nome']) ?></span> <span>€<?= number_format($item['prezzo'], 2, ',', '') ?></span></li>
            <?php endforeach; ?>
        </ul>
        <div class="ordine-totale">Totale: <span><?= number_format($totale, 2, ',', '') ?> €</span></div>
    </div>
<?php elseif ($errore_ordine): ?>
    <div class="form-group ordine-errore">
        <strong>Errore:</strong> <?= htmlspecialchars($errore_ordine) ?>
    </div>
<?php endif; ?>
<?php if (!$ordine_inviato): ?>
                <form action="#" method="post" class="form">
                    <div class="form-group">
                        <label for="note" class="control-label">Note per l'ordine</label>
                        <div class="controls">
                            <textarea name="note" class="form-control" placeholder="Eventuali note da allegare all'ordine."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="control-label">Nome</label>
                        <div class="controls">
                            <input type="text" name="first_name" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="control-label">Cognome</label>
                        <div class="controls">
                            <input type="text" name="last_name" class="form-control" placeholder="Cognome" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Telefono</label>
                        <div class="controls">
                            <input type="text" name="phone" class="form-control" placeholder="Telefono" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Metodo di consegna</label>
                        <div class="controls">
                            <label><input type="radio" name="consegna" value="ritiro" checked> Ritiro presso Maluburger</label>
                            <label><input type="radio" name="consegna" value="tavolo"> Ordine al tavolo</label>
                            <label><input type="radio" name="consegna" value="domicilio"> Consegna a domicilio</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Metodo di pagamento</label>
                        <div class="controls">
                            <label><input type="radio" name="pagamento" value="contanti"> In contanti</label>
                            <label><input type="radio" name="pagamento" value="carta"> Bancomat / Carta</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Riepilogo ordine</label>
                        <div class="controls">
                            <ul id="checkout-summary-list"></ul>
                            <div style="text-align:right; font-weight:bold;">Totale: <span id="checkout-summary-totale">0,00 €</span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Invia ordine" class="submit">
                    </div>
                </form>
<?php endif; ?>
            </div>
        </section>
    </article>
    <?php include 'footer.php'; ?>
    <?php if (!$ordine_inviato): ?>
    <script src="../assets/js/checkout.js"></script>
    <?php endif; ?>
</body>
</html>
