<?php

$alert_message = '';
if (isset($_GET['err'])) {
    $err = $_GET['err'];
} elseif (isset($_POST['err'])) {
    $err = $_POST['err'];
} else {
    $err = '';
}

switch($err) {
    case '1':
        $alert_message = 'Email già registrata!';
        break;
    case '2':
        $alert_message = 'Le password non coincidono!';
        break;
    case '3':
        $alert_message = 'Errore durante la registrazione.';
        break;
    case '4':
        $alert_message = 'Password o email errata.';
        break;
}

if ($alert_message !== '') {
    echo '<script>alert("' . $alert_message . '");</script>';
}
?>
